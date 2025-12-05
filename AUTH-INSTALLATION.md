# Installation du Système d'Authentification

## Vue d'ensemble

Le framework Market inclut un système d'authentification complet que vous pouvez installer facilement dans n'importe quel projet.

## Méthode 1 : Installation Automatique (Recommandée)

### Étape 1 : Copier le script d'installation

```bash
# Depuis votre projet
copy "d:\Mes projets\framework\install-auth.php" .
```

### Étape 2 : Exécuter le script

```bash
php install-auth.php
```

Le script va automatiquement :
- ✅ Créer le modèle `User`
- ✅ Créer `AuthController` avec login, register, logout
- ✅ Créer les vues `login.php` et `register.php`
- ✅ Créer la migration pour la table `users`
- ✅ Fournir un exemple de routes à ajouter

### Étape 3 : Exécuter la migration

```bash
php migrate.php
```

### Étape 4 : Ajouter les routes

Ouvrez `public/index.php` et ajoutez ces routes avant `$router->run()` :

```php
// Auth routes
$router->get("/login", "App\\Controllers\\AuthController@showLogin");
$router->post("/login", "App\\Controllers\\AuthController@login");
$router->get("/register", "App\\Controllers\\AuthController@showRegister");
$router->post("/register", "App\\Controllers\\AuthController@register");
$router->get("/logout", "App\\Controllers\\AuthController@logout");
```

### Étape 5 : Protéger vos routes (optionnel)

Pour protéger certaines routes avec authentification :

```php
use Framework\Middleware\AuthMiddleware;

$router->group(['middleware' => AuthMiddleware::class], function($router) {
    $router->get("/dashboard", "App\\Controllers\\DashboardController@index");
    $router->get("/profile", "App\\Controllers\\ProfileController@show");
});
```

## Méthode 2 : Installation Manuelle

Si vous préférez installer manuellement :

### 1. Créer le modèle User

```php
// app/Models/User.php
<?php
namespace App\Models;

use Framework\Core\Model;

#[AllowDynamicProperties]
class User extends Model {
    protected $table = 'users';
    
    public function findByEmail(string $email)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE email = ?", [$email], true);
    }
}
```

### 2. Créer AuthController

Copiez depuis `demo/app/Controllers/AuthController.php`

### 3. Créer les vues

Créez `views/auth/login.php` et `views/auth/register.php` (voir demo)

### 4. Créer la migration

```php
// migrations/001_create_users_table.php
<?php
use Framework\Database\Migration;
use Framework\Database\Schema;

class CreateUsersTable extends Migration {
    public function up(): void
    {
        $this->createTable('users', function(Schema $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        $this->dropTable('users');
    }
}
```

## Utilisation

### S'enregistrer

```
Visitez: http://localhost:8000/register
```

### Se connecter

```
Visitez: http://localhost:8000/login
```

### Vérifier l'authentification dans un contrôleur

```php
use Framework\Auth\Auth;

class DashboardController extends Controller {
    public function index()
    {
        $auth = new Auth($this->db);
        
        if (!$auth->check()) {
            $this->redirect('/login');
            return;
        }
        
        $user = $auth->user();
        $this->view('dashboard', ['user' => $user]);
    }
}
```

### Déconnexion

```
Visitez: http://localhost:8000/logout
```

## Personnalisation

### Changer la redirection après connexion

Dans `AuthController::login()` :

```php
if ($auth->attempt($email, $password)) {
    $this->redirect('/dashboard'); // Changez ici
}
```

### Ajouter des champs à l'inscription

1. Modifiez la migration pour ajouter des colonnes
2. Mettez à jour la vue `register.php`
3. Ajoutez les champs dans `AuthController::register()`

### Personnaliser les vues

Les vues se trouvent dans `views/auth/`. Vous pouvez :
- Modifier le HTML
- Changer le CSS inline
- Utiliser un layout commun

## Fichiers créés

Après installation, vous aurez :
- `app/Models/User.php`
- `app/Controllers/AuthController.php`
- `views/auth/login.php`
- `views/auth/register.php`
- `migrations/XXX_create_users_table.php`
- `routes-auth.example.php`

## Dépannage

**Erreur : Class Auth not found**
- Vérifiez que le framework est bien dans `vendor/market-framework`
- L'autoloader est-il correctement configuré ?

**Les sessions ne fonctionnent pas**
- Vérifiez que `session_start()` est dans `public/index.php`

**Erreur : Table users doesn't exist**
- Exécutez `php migrate.php`
