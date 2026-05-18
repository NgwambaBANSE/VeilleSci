#!/usr/bin/env php
<?php
/**
 * Setup Admin Management System
 * Initializes the admin management system and ensures at least one admin exists
 */

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "\n╔═══════════════════════════════════════════════════════════╗\n";
echo "║   🔐 Setup - Système de Gestion des Administrateurs       ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n\n";

try {
    $totalUsers = User::count();
    $adminUsers = User::where('is_admin', true)->count();
    
    echo "📊 Statistiques actuelles:\n";
    echo "   • Utilisateurs totaux: $totalUsers\n";
    echo "   • Administrateurs: $adminUsers\n\n";

    if ($totalUsers === 0) {
        echo "⚠️  Aucun utilisateur trouvé dans la base de données.\n";
        echo "   Créez d'abord un utilisateur via l'authentification.\n\n";
        exit(1);
    }

    if ($adminUsers === 0) {
        echo "⚠️  Aucun administrateur trouvé!\n";
        echo "   Promotion du premier utilisateur...\n\n";
        
        $firstUser = User::first();
        $firstUser->promoteToAdmin();
        
        echo "✅ Succès!\n";
        echo "   • Utilisateur: {$firstUser->name}\n";
        echo "   • Email: {$firstUser->email}\n";
        echo "   • Statut: Administrateur\n\n";
    } else {
        echo "✅ Au moins un administrateur est configuré.\n\n";
        echo "👥 Liste des administrateurs:\n";
        
        User::admins()->get()->each(function ($admin) {
            echo "   • {$admin->name} ({$admin->email})\n";
        });
        echo "\n";
    }

    echo "🎯 Accès au panneau d'administration:\n";
    echo "   http://localhost:8000/admin/admins\n\n";
    
    echo "📝 Commandes disponibles:\n";
    echo "   • Ajouter admin: php artisan tinker\n";
    echo "     User::find(ID)->promoteToAdmin()\n";
    echo "   • Retirer admin: php artisan tinker\n";
    echo "     User::find(ID)->demoteFromAdmin()\n\n";

} catch (\Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n\n";
    exit(1);
}

echo "✅ Système prêt!\n\n";
