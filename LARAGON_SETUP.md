# 🚀 LARAGON SETUP - Mise à jour automatique des articles

## Configuration rapide pour Laragon

Laragon simplifie beaucoup les choses en local. Voici comment faire tourner le scheduler:

### 1. Tester d'abord (Manuel)
```bash
# Dans Laragon Terminal ou PowerShell
cd C:\laragon\www\VeilleSci
php artisan articles:sync --domaine="artificial intelligence" --limit=5
```

✅ Doit créer 5 articles avec résumés

### 2. Option 1: Tester le Scheduler (Manuel - Une seule fois)
```bash
php artisan schedule:run
```

✅ Affiche:
```
0 2 * * *  php artisan articles:sync --all --limit=20  [No output] 0s
0 * * * *  php artisan articles:sync --domaine="machine learning"...
```

### 3. Option 2: Créer une Tâche Programmée Windows (À FAIRE)

Pour exécuter le scheduler automatiquement toutes les minutes:

#### **Méthode A: Via Powershell (Facile)**

Créer un fichier `C:\laragon\www\VeilleSci\run_scheduler.ps1`:

```powershell
# run_scheduler.ps1
$laravelPath = "C:\laragon\www\VeilleSci"
$phpPath = "C:\laragon\bin\php\php-8.3.0-Win32-vs16-x64\php.exe"

while ($true) {
    Set-Location $laravelPath
    & $phpPath artisan schedule:run
    Start-Sleep -Seconds 60
}
```

Puis, créer `run_scheduler.bat` dans le même dossier:

```batch
@echo off
cd C:\laragon\www\VeilleSci
powershell -NoProfile -ExecutionPolicy Bypass -File "C:\laragon\www\VeilleSci\run_scheduler.ps1"
pause
```

Exécuter `run_scheduler.bat` et le laisser tourner!

#### **Méthode B: Via Task Scheduler (Automatique au démarrage)**

1. **Ouvrir Task Scheduler**: 
   - Windows key + R → `taskschd.msc` → Enter

2. **Créer une nouvelle tâche**:
   - Right-click "Task Scheduler Library" → "Create Basic Task"
   - Nom: `VeilleSci-Article-Sync`
   - Description: `Automatic article synchronization`

3. **Trigger (Déclencheur)**:
   - Select "On a schedule"
   - Daily / 12:00 AM / Repeat every 1 minute for a duration of 24 hours

4. **Action**:
   - Program/script: `C:\Windows\System32\cmd.exe`
   - Arguments (Add arguments): 
     ```
     /c "cd C:\laragon\www\VeilleSci && C:\laragon\bin\php\php-8.3.0-Win32-vs16-x64\php.exe artisan schedule:run"
     ```
   - Start in (optional): `C:\laragon\www\VeilleSci`

5. **Conditions**:
   - ☑️ Wake the computer to run this task (si désiré)
   - ☑️ Run with highest privileges

6. **Finish**: Click "Create"

### 4. Vérification de l'Installation

```bash
# Voir les tâches programmées
php artisan schedule:list

# Voir les logs
Get-Content storage/logs/laravel.log -Tail 50

# Ou en temps réel
tail -f storage/logs/laravel.log
```

### 5. Vérifier que ça marche

Après quelques heures, vérifier:

```bash
# Compter les articles
php artisan tinker
Article::count()  # Doit augmenter

# Voir les derniers
Article::latest()->take(3)->get(['titre', 'created_at'])
```

---

## 🔄 Domaines Synchro Automatiquement

Actuellement configurés dans `routes/console.php`:

| Domaine | Fréquence | Limite |
|---------|-----------|--------|
| Machine Learning | Chaque heure | 15 articles |
| Artificial Intelligence | Chaque heure | 15 articles |
| Tous (--all) | Quotidien 02:00 | 20 articles |

Pour **modifier**, éditez `routes/console.php` à la ligne ~18-50.

---

## 🆘 Dépannage Laragon

### Problème: Aucun article créé
```bash
# 1. Vérifier les clés API dans .env
notepad .env

# Chercher ces lignes:
# ANTHROPIC_API_KEY=sk-ant-...
# CROSSREF_EMAIL=devbanse@gmail.com

# 2. Tester manuellement
php artisan articles:sync --domaine="biologie" --limit=2

# 3. Voir les erreurs
Get-Content storage/logs/laravel.log -Tail 100
```

### Problème: Task Scheduler ne fonctionne pas
```bash
# 1. Vérifier le chemin PHP
where php.exe
# Puis remplacer dans la Task Scheduler

# 2. Tester le commande manuellement
cd C:\laragon\www\VeilleSci
php artisan schedule:run

# 3. Vérifier les permissions
# Right-click Task Scheduler → Run with highest privileges ✓
```

### Problème: Erreurs "API 400"
- Cela signifie que l'API Crossref rejette la requête
- Vérifier que `CROSSREF_EMAIL` est correct dans `.env`
- L'email doit être au format: `name@domain.com`

---

## 📋 Checklist Finale

- [ ] Clés API dans `.env` ✓ (vérifiez: `ANTHROPIC_API_KEY` et `CROSSREF_EMAIL`)
- [ ] Test manuel: `php artisan articles:sync --limit=3` ✓
- [ ] Scheduler visible: `php artisan schedule:list` ✓
- [ ] Task programmée créée ✓
- [ ] Logs vérifiés ✓
- [ ] Articles en BD augmentent ✓

---

## 💡 Tips

1. **Garder Laragon ouvert** (surtout si php n'est pas dans le PATH)
2. **Utiliser Laragon Terminal** pour tester rapidement
3. **Vérifier les logs régulièrement** pour les erreurs
4. **Tester chaque domaine** si vous en ajoutez de nouveaux

---

## 📞 Support

Si ça ne fonctionne pas:
1. Vérifier les logs: `tail -f storage/logs/laravel.log`
2. Tester manuellement: `php artisan articles:sync --limit=1`
3. Vérifier `.env` pour les clés API

---

**Prêt à synchroniser!** 🎉

Once you have set up the scheduler, you will get automatic article updates!
