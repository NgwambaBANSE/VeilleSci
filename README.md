# VeilleSci

Portail de veille scientifique automatisée pour le Burkina Faso.

## Description

VeilleSci centralise la veille documentaire scientifique, les opportunités et le forum des chercheurs.

## Installation

1. Dupliquez `.env.example` en `.env`
2. Configurez vos variables d'environnement
3. Installez les dépendances PHP et JS :

```bash
composer install
npm install
```

4. Générez la clé d'application :

```bash
php artisan key:generate
```

5. Exécutez les migrations :

```bash
php artisan migrate
```

6. Lancez l'application en local :

```bash
php artisan serve
npm run dev
```

## Logs

Les fichiers de logs se trouvent dans `storage/logs/veille_sci.log`.

## Utilisation

- `php artisan migrate` : applique les migrations
- `php artisan db:seed` : insère les données de test
- `npm run dev` : démarre Vite en mode développement

## License

Ce projet est distribué sous licence MIT.

