#!/bin/bash

echo "🔍 Vérification et remplissage des données d'opportunités..."

# Exécuter le seeder
php artisan db:seed --class=OpportuniteSeeder

echo ""
echo "✅ Opportunités ajoutées en base de données!"
echo "🌐 Allez sur http://localhost:8000/app pour voir les opportunités"
