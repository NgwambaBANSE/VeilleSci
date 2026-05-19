# 📚 Guide de Mise à Jour Automatique des Articles

## Configuration Complète ✅

La mise à jour automatique des articles scientifiques est maintenant configurée avec:

### 1. **Services d'Intégration**
- ✅ **CrossrefService**: Récupère les articles de l'API Crossref
- ✅ **ClaudeService**: Résume et extrait les mots-clés avec Claude AI
- ✅ **Clés API**: Configurées dans `.env`

### 2. **Méthodes de Synchronisation**

#### A) Via Command (Artisan CLI)
Exécuter manuellement:
```bash
# Synchroniser tous les domaines
php artisan articles:sync --all --limit=20

# Synchroniser un domaine spécifique
php artisan articles:sync --domaine="artificial intelligence" --limit=30

# Domaines disponibles:
# - sante, medecine, nutrition
# - agriculture, environnement, eau
# - ia, informatique, telecommunications
# - education, economie, sciences-sociales
# - biologie, chimie, physique, mathematiques
# - energie, mines, general
```

#### B) Via Jobs (Queue - Mode Arrière-Plan)
Les tâches s'exécutent via la queue de l'application (configuration: `QUEUE_CONNECTION=database`).

#### C) Scheduler (Automatique - À ACTIVER)
Les tâches sont programmées dans `routes/console.php`:

```
0 2 * * *    Sync tous les domaines - 02:00 AM (quotidien)
0 * * * *    Sync Machine Learning - Chaque heure
0 * * * *    Sync IA - Chaque heure
0 * * * *    Job IA - Chaque heure
0 * * * *    Job ML - Chaque heure
```

---

## 🚀 DÉPLOIEMENT EN PRODUCTION

Pour que le scheduler fonctionne **automatiquement**, vous devez:

### Option 1: Cron (Linux/MacOS - Recommandé)
Ajouter à votre crontab:
```bash
crontab -e
```

Ajouter cette ligne:
```bash
* * * * * cd /path/to/VeilleSci && php artisan schedule:run >> /dev/null 2>&1
```

Cela exécute le scheduler chaque minute, qui lancera les tâches programmées.

### Option 2: Windows Task Scheduler
1. Ouvrir "Task Scheduler" (Planificateur de tâches)
2. Créer une tâche programmée
3. Configurer pour exécuter:
   ```
   C:\path\to\php.exe -r "chdir('C:\laragon\www\VeilleSci'); require 'vendor/autoload.php'; $app = require_once 'bootstrap/app.php'; $app->make('Illuminate\Contracts\Console\Kernel')->call('schedule:run');"
   ```
4. Répétition: Chaque minute

### Option 3: Docker / Services
Si vous utilisez Docker, ajouter au `Dockerfile`:
```dockerfile
RUN (crontab -l 2>/dev/null; echo "* * * * * cd /app && php artisan schedule:run") | crontab -
```

### Option 4: Superviseur (Long-running Process)
Installer Supervisor et créer `/etc/supervisor/conf.d/veille_sci-scheduler.conf`:
```ini
[program:veille_sci-scheduler]
process_name=%(program_name)s
command=php /path/to/VeilleSci/artisan schedule:work
autostart=true
autorestart=true
numprocs=1
redirect_stderr=true
stdout_logfile=/path/to/VeilleSci/storage/logs/scheduler.log
stopwaitsecs=3600
```

---

## 👷 WORKERS EN ARRIÈRE-PLAN (Pour les Jobs)

Si vous utilisez les Jobs, configurez les workers:

### Option 1: Queue Worker (Linux)
```bash
php artisan queue:work --queue=default --tries=3 --timeout=600
```

### Option 2: Supervisor
```ini
[program:veille_sci-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/VeilleSci/artisan queue:work --queue=default --tries=3 --timeout=600
autostart=true
autorestart=true
numprocs=8
redirect_stderr=true
stdout_logfile=/path/to/VeilleSci/storage/logs/worker.log
```

---

## 📊 MONITORING

### Voir les tâches programmées
```bash
php artisan schedule:list
```

### Afficher les logs
```bash
tail -f storage/logs/veille_sci.log
```

### Lancer le scheduler en mode debug (une fois)
```bash
php artisan schedule:run
```

---

## 🔧 CONFIGURATION DE QUEUE

Dans `.env`:
```env
# Actuel (Database Queue)
QUEUE_CONNECTION=database

# Options:
# - database (Stocke en DB - idéal pour démarrage)
# - sync (Synchrone - exécution immédiate, pas de worker)
# - redis (Plus rapide - require Redis)
# - sqs (AWS - production)
```

Si vous changez le driver, exécutez:
```bash
php artisan queue:table  # Si database
php artisan migrate      # Pour créer les tables
```

---

## ✅ VÉRIFICATION

### 1. Tester le synchronisation
```bash
php artisan articles:sync --domaine="machine learning" --limit=5
```
✓ Doit créer 5 articles

### 2. Vérifier les logs
```bash
tail -f storage/logs/veille_sci.log | grep -E "(✅|❌|🔄)"
```
✓ Doit voir les messages de sync

### 3. Vérifier la base de données
```bash
php artisan tinker
Article::count()  # Doit augmenter
Article::latest()->first()  # Voir le dernier article
```

### 4. Tester une tâche programmée (simulation)
```bash
php artisan schedule:run
```
✓ Affiche les tâches exécutées

---

## 🆘 DÉPANNAGE

### Les articles ne se créent pas
1. Vérifier les logs: `tail -f storage/logs/veille_sci.log`
2. Vérifier les clés API dans `.env`:
   ```env
   ANTHROPIC_API_KEY=sk-ant-...
   CROSSREF_EMAIL=votre@email.com
   ```
3. Tester manuellement:
   ```bash
   php artisan articles:sync --domaine="artificial intelligence" --limit=3
   ```

### Le scheduler ne fonctionne pas
1. Vérifier que cron/Task Scheduler est en cours d'exécution
2. Tester manuellement:
   ```bash
   php artisan schedule:run
   ```
3. Voir la liste des tâches:
   ```bash
   php artisan schedule:list
   ```

### Erreurs d'API
- **Crossref 400**: Vérifier `CROSSREF_EMAIL` dans `.env`
- **Claude timeout**: Vérifier `ANTHROPIC_API_KEY` et la connexion internet
- **Rate limiting**: Crossref a des limites - attendre quelques minutes

---

## 📝 EXEMPLE COMPLET (Ubuntu/Debian)

```bash
# 1. Configurer le cron
sudo crontab -e

# Ajouter:
* * * * * cd /home/user/VeilleSci && /usr/bin/php /home/user/VeilleSci/artisan schedule:run >> /dev/null 2>&1

# 2. Configurer les workers (optionnel)
sudo vim /etc/supervisor/conf.d/veille_sci-worker.conf

# 3. Redémarrer Supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start veille_sci-worker:*

# 4. Vérifier
ps aux | grep schedule:work  # Doit voir le process
tail -f /home/user/VeilleSci/storage/logs/veille_sci.log
```

---

## 📋 RÉCAPITULATIF DES ÉTAPES

- [x] Services API configurés (Crossref + Claude)
- [x] Command `articles:sync` fonctionnel
- [x] Job `SyncArticlesJob` créé
- [x] Scheduler configuré dans `routes/console.php`
- [ ] **À FAIRE: Configurer cron/Task Scheduler** ← PROCHAINE ÉTAPE
- [ ] Vérifier l'exécution automatique

---

## ❓ FAQ

**Q: Combien de temps prend une synchronisation?**
R: ~2 secondes par article (dépend de Claude). 20 articles = ~40 secondes.

**Q: Puis-je synchroniser plusieurs domaines?**
R: Oui! Utilisez `--all` pour tous les domaines configurés.

**Q: Comment ajouter de nouveaux domaines?**
R: Modifier `CrossrefService::searchByField()` méthode.

**Q: Est-ce que Claude API coûte cher?**
R: Dépend du nombre de résumés. ~$0.001-0.01 par article.

**Q: Can I disable automatic sync?**
R: Oui, commentez les lignes du scheduler dans `routes/console.php`.

---

**Dernière mise à jour**: 18 mai 2026
**Version**: 1.0
**Auteur**: VeilleSci Dev Team

