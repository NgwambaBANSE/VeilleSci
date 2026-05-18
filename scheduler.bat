@echo off
REM ========================================================
REM VeilleSci - Script de demarrage du scheduler automatique
REM ========================================================

SETLOCAL ENABLEDELAYEDEXPANSION

REM Configuration
SET APP_PATH=C:\laragon\www\VeilleSci
SET PHP_PATH=C:\laragon\bin\php\php-8.3.0-Win32-vs16-x64\php.exe

REM Verification que les chemins existent
IF NOT EXIST "!PHP_PATH!" (
    echo ERROR: PHP not found at !PHP_PATH!
    echo Please verify your Laragon installation.
    pause
    exit /b 1
)

IF NOT EXIST "!APP_PATH!" (
    echo ERROR: Application not found at !APP_PATH!
    pause
    exit /b 1
)

REM Afficher le menu
cls
echo.
echo ╔════════════════════════════════════════════════════════════╗
echo ║  VeilleSci - Article Sync Scheduler                        ║
echo ╚════════════════════════════════════════════════════════════╝
echo.
echo Options:
echo   1. Demarrer le scheduler (recommande)
echo   2. Tester une synchronisation manuelle
echo   3. Generer les resumes IA
echo   4. Voir les taches programmees
echo   5. Verifier l'etat du systeme
echo   6. Voir les logs
echo   0. Quitter
echo.
set /p choice="Choisir une option (0-6): "

cd /d "!APP_PATH!"

IF "!choice!"=="1" (
    echo.
    echo Demarrage du scheduler...
    echo Le scheduler va tourner continuellement.
    echo Appuyer sur Ctrl+C pour arreter.
    echo.
    "!PHP_PATH!" artisan schedule:work
    
) ELSE IF "!choice!"=="2" (
    echo.
    set /p domain="Domaine (artificial intelligence): "
    if "!domain!"=="" set domain=artificial intelligence
    set /p limit="Nombre d'articles (5): "
    if "!limit!"=="" set limit=5
    
    echo.
    echo Synchronisation de !limit! articles en domaine: !domain!
    echo.
    "!PHP_PATH!" artisan articles:sync --domaine="!domain!" --limit=!limit!
    echo.
    pause
    
) ELSE IF "!choice!"=="3" (
    echo.
    set /p limit="Nombre d'articles a traiter (10): "
    if "!limit!"=="" set limit=10
    
    echo.
    echo Generation des resumes IA pour !limit! articles...
    echo.
    "!PHP_PATH!" artisan articles:generate-summaries --limit=!limit!
    echo.
    pause
    
) ELSE IF "!choice!"=="4" (
    echo.
    echo Taches programmees:
    echo.
    "!PHP_PATH!" artisan schedule:list
    echo.
    pause
    
) ELSE IF "!choice!"=="5" (
    echo.
    echo Verification du systeme...
    echo.
    "!PHP_PATH!" verify_sync.php
    echo.
    pause
    
) ELSE IF "!choice!"=="6" (
    echo.
    echo Logs (derniers 50 lignes):
    echo.
    type "!APP_PATH!\storage\logs\laravel.log" | tail -50
    echo.
    pause
    
) ELSE IF "!choice!"=="0" (
    echo.
    echo Fermeture...
    goto END
    
) ELSE (
    echo Option invalide
    timeout /t 2
    goto START
)

goto START

:END
endlocal
