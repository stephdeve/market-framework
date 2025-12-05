# Market Framework - Guide d'Installation

## Option 1 : Créer un nouveau projet (Recommandé)

### Méthode Manuelle

1. **Créez la structure de votre projet :**

```bash
mkdir mon-projet
cd mon-projet
```

2. **Créez le fichier `composer.json` :**

```json
{
    "name": "votre-nom/mon-projet",
    "description": "Mon application avec Market Framework",
    "type": "project",
    "require": {
        "php": ">=7.4"
    },
    "repositories": [
        {
            "type": "path",
            "url": "../framework"
        }
    ],
    "autoload": {
        "psr-4": {
            "App\\": "app/"
        }
    },
    "scripts": {
        "serve": "php -S localhost:8000 -t public",
        "migrate": "php migrate.php",
        "seed": "php seed.php"
    }
}
```

3. **Créez la structure des dossiers :**

```bash
mkdir app app\Controllers app\Models
mkdir config migrations seeders public views logs
mkdir public\css public\js
mkdir views\layouts
```

4. **Copiez les fichiers essentiels depuis le demo :**

```bash
# Depuis le répertoire framework
copy demo\public\index.php mon-projet\public\
copy demo\public\.htaccess mon-projet\public\
copy demo\migrate.php mon-projet\
copy demo\seed.php mon-projet\
copy demo\config\*.php mon-projet\config\
copy demo\.env.example mon-projet\
```

5. **Créez un lien symbolique ou copiez le framework :**

```bash
# Option A: Lien symbolique (Windows avec droits admin)
mklink /D vendor\market-framework d:\Mes projets\framework

# Option B: Copier le framework
xcopy /E /I "d:\Mes projets\framework" vendor\market-framework
```

6. **Installez les dépendances :**

```bash
composer install
```

## Option 2 : Utiliser le script d'installation automatique

Je vais créer un script `create-project.php` qui fait tout automatiquement.

### Utilisation :

```bash
php d:\Mes projets\framework\create-project.php mon-nouveau-projet
```

## Structure d'un nouveau projet

```
mon-projet/
├── app/
│   ├── Controllers/
│   │   └── HomeController.php
│   └── Models/
│       └── User.php
├── config/
│   ├── app.php
│   └── database.php
├── migrations/
│   └── 001_create_users_table.php
├── seeders/
│   └── UserSeeder.php
├── public/
│   ├── css/
│   ├── js/
│   ├── index.php
│   └── .htaccess
├── views/
│   └── layouts/
│       └── app.php
├── logs/
├── .env
├── composer.json
├── migrate.php
└── seed.php
```

## Démarrage rapide

1. **Configurez la base de données** dans `.env` et `config/database.php`

2. **Créez votre premier contrôleur :**

```php
// app/Controllers/HomeController.php
namespace App\Controllers;

use Framework\Core\Controller;

class HomeController extends Controller {
    public function index()
    {
        $this->view('home', ['title' => 'Bienvenue']);
    }
}
```

3. **Créez votre première vue :**

```php
// views/home.php
<h1><?= $title ?></h1>
<p>Mon application avec Market Framework</p>
```

4. **Définissez vos routes dans `public/index.php` :**

```php
$router->get("/", "App\\Controllers\\HomeController@index");
```

5. **Lancez le serveur :**

```bash
composer serve
```

## Commandes disponibles

```bash
composer serve      # Démarrer le serveur de développement
php migrate.php     # Exécuter les migrations
php seed.php        # Exécuter les seeders
composer test       # Lancer les tests (si configuré)
```

## Prochaines étapes

- Consultez la [documentation complète](../README.md) pour tous les détails
- Explorez l'application `demo/` pour des exemples
- Créez vos modèles, contrôleurs et vues
