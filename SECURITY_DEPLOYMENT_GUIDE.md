# 🔒 Guide de Sécurité VeilleSci - Déploiement Sécurisé

## 1. Configuration d'Environnement (`.env`)

### Variables essentielles de sécurité

```bash
# Application Mode
APP_ENV=production           # Jamais "local" en production !
APP_DEBUG=false             # Désactiver le debug mode
APP_URL=https://your-domain.com

# Session Security
SESSION_DRIVER=database      # Utiliser la base de données (pas 'file')
SESSION_ENCRYPT=true         # Chiffrer les sessions
SESSION_SECURE_COOKIES=true  # HTTPS only
SESSION_LIFETIME=120         # 2 heures d'inactivité max

# CORS Configuration
SANCTUM_STATEFUL_DOMAINS=your-domain.com
SANCTUM_GUARD=web

# Email Configuration (pour les alertes d'audit)
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com

# Logging
LOG_CHANNEL=stack
LOG_LEVEL=warning            # Production = warning ou error
LOG_AUDIT_DAYS=90            # Conserver les logs d'audit 90 jours

# Database Security
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=veille_sci
DB_USERNAME=db_user
DB_PASSWORD=STRONG_PASSWORD  # Min 20 caractères complexes

# OAuth Google (depuis console Google Cloud)
GOOGLE_CLIENT_ID=your-client-id.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your-client-secret
GOOGLE_REDIRECT_URI=https://your-domain.com/auth/google/callback

# Services
ANTHROPIC_API_KEY=your-api-key  # Stocké de manière sécurisée
CROSSREF_EMAIL=admin@your-domain.com

# Rate Limiting
RATE_LIMITING_ENABLED=true

# CSP (Content Security Policy)
CSP_STRICT_DYNAMIC=true
```

---

## 2. Configuration Nginx/Apache

### Headers de sécurité essentiels

**Nginx (`nginx.conf` ou `server.conf`):**
```nginx
# SSL/TLS Configuration
ssl_protocols TLSv1.2 TLSv1.3;
ssl_ciphers HIGH:!aNULL:!MD5;
ssl_prefer_server_ciphers on;

# Security Headers
add_header X-Frame-Options "DENY" always;
add_header X-Content-Type-Options "nosniff" always;
add_header X-XSS-Protection "1; mode=block" always;
add_header Referrer-Policy "strict-origin-when-cross-origin" always;
add_header Permissions-Policy "geolocation=(), microphone=(), camera=(), payment=(), usb=()" always;

# Limiter la taille des uploads
client_max_body_size 10M;

# Rate limiting Nginx
limit_req_zone $binary_remote_addr zone=login:10m rate=5r/m;
limit_req_zone $binary_remote_addr zone=api:10m rate=100r/m;

location /auth/login {
    limit_req zone=login burst=10 nodelay;
    proxy_pass http://laravel;
}
```

**Apache (`.htaccess`):**
```apache
# SSL Redirect
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{HTTPS} !=on
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>

# Security Headers
<IfModule mod_headers.c>
    Header always set X-Frame-Options "DENY"
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
</IfModule>

# Disable directory listing
Options -Indexes

# Block access to files
<FilesMatch "\.env|\.git|vendor">
    Order allow,deny
    Deny from all
</FilesMatch>
```

---

## 3. Commandes Laravel à exécuter

### Installation et migrations

```bash
# 1. Installer les dépendances
composer install --no-dev --optimize-autoloader

# 2. Générer la clé APP_KEY
php artisan key:generate

# 3. Exécuter les migrations
php artisan migrate --force

# 4. Seed les données initiales (si nécessaire)
php artisan db:seed --class=DatabaseSeeder

# 5. Compiler les assets
npm run build

# 6. Optimiser l'application
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Optimiser l'autoloader
composer dump-autoload --optimize
```

---

## 4. Permissions des fichiers

```bash
# Web server user (généralement www-data ou nobody)
WEBUSER=www-data

# Changer le propriétaire
sudo chown -R $WEBUSER:$WEBUSER /var/www/VeilleSci

# Permissions des dossiers
sudo chmod -R 755 /var/www/VeilleSci

# Permissions des fichiers
sudo find /var/www/VeilleSci -type f -exec chmod 644 {} \;

# Permissions spéciales (writable par le web server)
sudo chmod -R 775 /var/www/VeilleSci/storage
sudo chmod -R 775 /var/www/VeilleSci/bootstrap/cache

# Protéger les fichiers sensibles
sudo chmod 600 /var/www/VeilleSci/.env
sudo chmod 600 /var/www/VeilleSci/.env.local
sudo chmod 600 /var/www/VeilleSci/config/database.php
```

---

## 5. Database Security

### Créer un utilisateur MySQL sécurisé

```sql
-- Créer un utilisateur avec permissions limitées
CREATE USER 'veille_user'@'localhost' IDENTIFIED BY 'STRONG_PASSWORD_20_CHARS_MIN';

-- Accorder uniquement les permissions nécessaires
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER ON veille_sci.* TO 'veille_user'@'localhost';

-- Supprimer l'utilisateur root avec password faible
DELETE FROM mysql.user WHERE User='root' AND Host='%';

-- Recharger les permissions
FLUSH PRIVILEGES;

-- Optionnel: Activer le chiffrement au repos
ALTER TABLE users MODIFY COLUMN google_token LONGTEXT;
ALTER TABLE users MODIFY COLUMN google_id VARCHAR(255);
```

---

## 6. Firewall Configuration

### UFW (Ubuntu/Debian)

```bash
sudo ufw enable
sudo ufw allow 22/tcp      # SSH
sudo ufw allow 80/tcp      # HTTP (rediriger vers HTTPS)
sudo ufw allow 443/tcp     # HTTPS
sudo ufw allow from 10.0.0.0/8 to any port 3306  # MySQL (subnet interne)
sudo ufw status verbose
```

---

## 7. SSL/TLS Certificate

### Using Let's Encrypt with Certbot

```bash
# Install Certbot
sudo apt-get install certbot python3-certbot-nginx

# Generate certificate
sudo certbot certonly --nginx -d your-domain.com -d www.your-domain.com

# Auto-renewal
sudo systemctl enable certbot.timer
sudo systemctl start certbot.timer

# Verify auto-renewal works
sudo certbot renew --dry-run
```

---

## 8. Monitoring & Logging

### Set up log rotation

**`/etc/logrotate.d/veille-sci`:**
```
/var/www/VeilleSci/storage/logs/*.log {
    daily
    missingok
    rotate 90
    compress
    delaycompress
    notifempty
    create 0640 www-data www-data
    sharedscripts
    postrotate
        /usr/lib/php/sessionclean >/dev/null 2>&1 || true
    endscript
}
```

### Monitor suspicious activities

```bash
# Watch audit logs
tail -f storage/logs/audit.log

# Monitor failed auth attempts
grep "Unauthorized access attempt" storage/logs/audit.log | tail -20

# Check error logs
tail -f storage/logs/laravel.log
```

---

## 9. Backup Strategy

```bash
#!/bin/bash
# backup.sh

BACKUP_DIR="/backups/veille-sci"
DATE=$(date +%Y-%m-%d_%H-%M-%S)
ENCRYPTION_PASS="YOUR_ENCRYPTION_PASSWORD"

# Backup database
mysqldump -u veille_user -p$DB_PASSWORD veille_sci | \
    gzip | \
    openssl enc -aes-256-cbc -pbkdf2 -pass pass:$ENCRYPTION_PASS \
    > $BACKUP_DIR/db_$DATE.sql.gz.enc

# Backup application files (excluding vendor, node_modules)
tar --exclude='vendor' --exclude='node_modules' --exclude='storage/logs' \
    -czf - /var/www/VeilleSci | \
    openssl enc -aes-256-cbc -pbkdf2 -pass pass:$ENCRYPTION_PASS \
    > $BACKUP_DIR/app_$DATE.tar.gz.enc

# Remove old backups (keep 30 days)
find $BACKUP_DIR -name "*.enc" -mtime +30 -delete

# Upload to S3 (optional)
aws s3 sync $BACKUP_DIR s3://your-backup-bucket/
```

---

## 10. Regular Security Maintenance

### Weekly tasks
- [ ] Review audit logs
- [ ] Check for failed authentication attempts
- [ ] Monitor disk space and logs size

### Monthly tasks
- [ ] Update Laravel and dependencies: `composer update`
- [ ] Update OS packages: `apt-get update && apt-get upgrade`
- [ ] Review user access and permissions
- [ ] Test backup restoration

### Quarterly tasks
- [ ] Security audit and vulnerability scan
- [ ] Penetration testing
- [ ] Review firewall rules and configurations
- [ ] Test disaster recovery plan

---

## 11. Incident Response

### If compromised:

1. **Isolate immediately** - Take server offline or block internet access
2. **Preserve logs** - Copy all logs to external storage
3. **Change credentials** - All database passwords, API keys, SSH keys
4. **Run security audit** - Check for backdoors and malware
5. **Notify users** - If data was exposed
6. **Restore from backup** - Use clean backup from before compromise
7. **Re-deploy** - Update all security configurations
8. **Monitor** - Watch for continued attacks

---

## Checklist de sécurité final

- [ ] `.env` sécurisé et non versionné
- [ ] SSL/TLS activé (HTTPS)
- [ ] APP_DEBUG = false
- [ ] SESSION_ENCRYPT = true
- [ ] Rate limiting activé sur toutes les routes critiques
- [ ] CSP headers configurés
- [ ] CORS configuré correctement
- [ ] Permissions de fichiers correctes
- [ ] Backups chiffrés et testés
- [ ] Logs d'audit activés
- [ ] Firewall configuré
- [ ] SSH key-based authentication
- [ ] Monitoring et alertes mis en place
- [ ] Documentation de sécurité à jour

---

**Dernière mise à jour:** 19 Mai 2026
**Version:** 1.0
