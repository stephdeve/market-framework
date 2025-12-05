<?php
// Market Framework - Complete Professional Documentation
// This file should be copied to views/docs.php in new projects
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market Framework - Documentation Complète</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f8f9fa;
        }
        
        /* Sidebar Navigation */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 280px;
            background: #2c3e50;
            color: white;
            overflow-y: auto;
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 2rem 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .sidebar-header h1 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .sidebar-header p {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .nav-section {
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .nav-section h3 {
            padding: 0.5rem 1.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.6;
        }
        
        .nav-link {
            display: block;
            padding: 0.75rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 0.9rem;
        }
        
        .nav-link:hover,
        .nav-link:focus {
            background: rgba(255,255,255,0.1);
            color: white;
            padding-left: 2rem;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            max-width: 1200px;
        }
        
        .page-header {
            padding: 3rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }
        
        .page-header h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .page-header p {
            font-size: 1.25rem;
            opacity: 0.95;
        }
        
        .content-section {
            background: white;
            padding: 2.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }
        
        h2 {
            color: #667eea;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 3px solid #667eea;
        }
        
        h3 {
            color: #333;
            font-size: 1.5rem;
            margin: 2rem 0 1rem 0;
        }
        
        h4 {
            color: #555;
            font-size: 1.25rem;
            margin: 1.5rem 0 0.75rem 0;
        }
        
        p {
            margin-bottom: 1rem;
            line-height: 1.8;
            color: #444;
        }
        
        /* Code Blocks */
        .command-box {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1.5rem 0;
            font-family: 'Courier New', Consolas, monospace;
            position: relative;
            border-left: 4px solid #667eea;
            font-size: 0.95em;
        }
        
        .command-box-label {
            position: absolute;
            top: -10px;
            left: 15px;
            background: #667eea;
            color: white;
            padding: 2px 10px;
            border-radius: 3px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        code {
            background: #f5f5f5;
            padding: 0.2rem 0.5rem;
            border-radius: 3px;
            font-family: 'Courier New', Consolas, monospace;
            color: #e83e8c;
            font-size: 0.9em;
        }
        
        pre code {
            background: none;
            color: #f8f8f2;
            padding: 0;
        }
        
        /* Feature Grid */
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .feature-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 1.5rem;
            border-radius: 10px;
            border-left: 4px solid #667eea;
            transition: transform 0.3s;
        }
        
        .feature-card:hover {
            transform: translateY(-3px);
        }
        
        .feature-card h4 {
            color: #667eea;
            margin-top: 0;
            margin-bottom: 0.5rem;
        }
        
        .feature-card p {
            color: #333;
            font-size: 0.95rem;
            margin: 0;
        }
        
        /* Lists */
        ul, ol {
            margin: 1rem 0 1rem 2rem;
            line-height: 1.8;
        }
        
        li {
            margin: 0.5rem 0;
        }
        
        /* Installation Steps */
        .step {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1rem 0;
            border-left: 4px solid #28a745;
        }
        
        .step-number {
            display: inline-block;
            width: 30px;
            height: 30px;
            background: #28a745;
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            font-weight: 600;
            margin-right: 1rem;
        }
        
        .step-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        /* Alert Boxes */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 5px;
            margin: 1.5rem 0;
            border-left: 4px solid;
        }
        
        .alert-info {
            background: #e7f3ff;
            border-color: #2196F3;
            color: #0c5aa6;
        }
        
        .alert-success {
            background: #e8f5e9;
            border-color: #4caf50;
            color: #2e7d32;
        }
        
        .alert-warning {
            background: #fff3e0;
            border-color: #ff9800;
            color: #e65100;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
            }
            .page-header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h1>📚 Market Framework</h1>
            <p>Documentation Complète</p>
        </div>
        
        <div class="nav-section">
            <h3>Démarrage</h3>
            <a href="/" class="nav-link">🏠 Retour à l'accueil</a>
            <a href="#installation" class="nav-link">Installation</a>
            <a href="#quick-start" class="nav-link">Démarrage Rapide</a>
        </div>
        
        <div class="nav-section">
            <h3>Fonctionnalités</h3>
            <a href="#routing" class="nav-link">Routing</a>
            <a href="#controllers" class="nav-link">Controllers</a>
            <a href="#models" class="nav-link">Models & BDD</a>
            <a href="#views" class="nav-link">Views</a>
            <a href="#middleware" class="nav-link">Middleware</a>
        </div>
        
        <div class="nav-section">
            <h3>Avancé</h3>
            <a href="#authentication" class="nav-link">Authentification</a>
            <a href="#validation" class="nav-link">  Validation</a>
            <a href="#relationships" class="nav-link">Relations BDD</a>
            <a href="#migrations" class="nav-link">Migrations</a>
            <a href="#seeders" class="nav-link">Seeders</a>
        </div>
        
        <div class="nav-section">
            <h3>Outils</h3>
            <a href="#testing" class="nav-link">Tests</a>
            <a href="#helpers" class="nav-link">Helpers</a>
            <a href="#tailwind" class="nav-link">Tailwind CSS</a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="page-header">
            <h1>🎯 Market Framework</h1>
            <p>Framework PHP MVC Moderne, Léger et Puissant</p>
        </div>
        
        <!-- Introduction / README -->
        <div class="content-section">
            <h2>À Propos</h2>
            <p>
                Market Framework est un framework PHP MVC complet et léger, conçu pour rendre le développement web
                rapide, efficace et agréable. Construit avec des standards PHP modernes et les meilleures pratiques,
                il fournit tous les outils nécessaires pour créer des applications web robustes.
            </p>
            
            <div class="feature-grid">
                <div class="feature-card">
                    <h4>🏗️ Architecture MVC</h4>
                    <p>Séparation claire: Models, Views, Controllers</p>
                </div>
                <div class="feature-card">
                    <h4>🔐 Authentification</h4>
                    <p>Système auth complet avec sessions</p>
                </div>
                <div class="feature-card">
                    <h4>🗄️ ORM & Relations</h4>
                    <p>Query Builder et relations complètes</p>
                </div>
                <div class="feature-card">
                    <h4>✅ Validation</h4>
                    <p>15+ règles de validation</p>
                </div>
                <div class="feature-card">
                    <h4>🛣️ Routing Avancé</h4>
                    <p>Tous les HTTP methods + middleware</p>
                </div>
                <div class="feature-card">
                    <h4>🧪 Tests</h4>
                    <p>PHPUnit intégré</p>
                </div>
            </div>
            
            <h3>Prérequis</h3>
            <ul>
                <li><strong>PHP >= 7.4</strong> (PHP 8+ recommandé)</li>
                <li><strong>Extension PDO</strong> - Pour base de données</li>
                <li><strong>MySQL/MariaDB</strong> - Serveur de base de données</li>
                <li><strong>Apache/Nginx</strong> avec mod_rewrite OU serveur PHP intégré</li>
                <li><strong>Composer</strong> (optionnel) - Gestion dépendances</li>
                <li><strong>Node.js & npm</strong> (optionnel) - Pour Tailwind CSS</li>
            </ul>
        </div>
        
        <!-- Installation -->
        <div class="content-section" id="installation">
            <h2>🚀 Installation</h2>
            
            <h3>Méthode Automatique (Recommandée)</h3>
            
            <div class="step">
                <span class="step-number">1</span>
                <div class="step-content">
                    <div class="step-title">Télécharger le Framework</div>
                    <p>Clonez ou téléchargez le framework</p>
                    <div class="command-box">
                        <div class="command-box-label">Terminal</div>
                        <pre><code>cd "d:\Mes projets"
git clone https://github.com/your-repo/market-framework framework</code></pre>
                    </div>
                </div>
            </div>
            
            <div class="step">
                <span class="step-number">2</span>
                <div class="step-content">
                    <div class="step-title">Créer un Nouveau Projet</div>
                    <p>Utilisez le script créateur de projet</p>
                    <div class="command-box">
                        <div class="command-box-label">Terminal</div>
                        <pre><code>php framework\create-project.php mon-app
cd mon-app</code></pre>
                    </div>
                </div>
            </div>
            
            <div class="step">
                <span class="step-number">3</span>
                <div class="step-content">
                    <div class="step-title">Configurer la Base de Données</div>
                    <p>Éditez <code>config/database.php</code> avec vos identifiants MySQL</p>
                    <div class="command-box">
                        <div class="command-box-label">config/database.php</div>
                        <pre><code>return [
    'host' => 'localhost',
    'dbname' => 'ma_base',
    'username' => 'root',
    'password' => 'votre_password'
];</code></pre>
                    </div>
                </div>
            </div>
            
            <div class="step">
                <span class="step-number">4</span>
                <div class="step-content">
                    <div class="step-title">Créer la Base de Données</div>
                    <div class="command-box">
                        <div class="command-box-label">MySQL</div>
                        <pre><code>mysql -u root -p
CREATE DATABASE ma_base CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;</code></pre>
                    </div>
                </div>
            </div>
            
            <div class="step">
                <span class="step-number">5</span>
                <div class="step-content">
                    <div class="step-title">Lancer le Serveur</div>
                    <div class="command-box">
                        <div class="command-box-label">Terminal</div>
                        <pre><code>composer serve
# Ou manuellement:
php -S localhost:8000 -t public</code></pre>
                    </div>
                </div>
            </div>
            
            <div class="step">
                <span class="step-number">6</span>
                <div class="step-content">
                    <div class="step-title">Visitez Votre Application</div>
                    <div class="alert alert-success">
                        <strong>✓ Succès!</strong> Visitez <code>http://localhost:8000</code>
                    </div>
                </div>
            </div>
            
            <h3>Installation Authentification</h3>
            <div class="command-box">
                <div class="command-box-label">Terminal</div>
                <pre><code># Copier l'installeur auth
copy "..\framework\install-auth.php" .

# Exécuter l'installation
php install-auth.php

# Exécuter les migrations
php migrate.php

# Authentification prête!
# Visitez: http://localhost:8000/register</code></pre>
            </div>
            
            <h3>Installation Tailwind CSS</h3>
            <div class="command-box">
                <div class="command-box-label">Terminal</div>
                <pre><code># Copier l'installeur Tailwind
copy "..\framework\install-tailwind.php" .

# Exécuter l'installation
php install-tailwind.php

# Installer les dépendances
npm install

# Démarrer Tailwind en mode watch
npm run dev</code></pre>
            </div>
        </div>
        
        <!-- Quick Start -->
        <div class="content-section" id="quick-start">
            <h2>⚡ Démarrage Rapide</h2>
            
            <h3>Créer Votre Premier Controller</h3>
            <div class="command-box">
                <div class="command-box-label">app/Controllers/WelcomeController.php</div>
                <pre><code>&lt;?php
namespace App\Controllers;

use Framework\Core\Controller;

class WelcomeController extends Controller {
    public function index()
    {
        $this->view('welcome' [
            'message' => 'Hello World!'
        ]);
    }
}</code></pre>
            </div>
            
            <h3>Ajouter une Route</h3>
            <div class="command-box">
                <div class="command-box-label">public/index.php</div>
                <pre><code>$router->get("/welcome", "App\\Controllers\\WelcomeController@index");</code></pre>
            </div>
            
            <h3>Créer une Vue</h3>
            <div class="command-box">
                <div class="command-box-label">views/welcome.php</div>
                <pre><code>&lt;!DOCTYPE html>
&lt;html>
&lt;head>
    &lt;title>Welcome&lt;/title>
&lt;/head>
&lt;body>
    &lt;h1>&lt;?= $message ?>&lt;/h1>
&lt;/body>
&lt;/html></code></pre>
            </div>
        </div>
        
        <!-- Routing Section -->
        <div class="content-section" id="routing">
            <h2>🛣️ Routing</h2>
            <p>Le routeur supporte plusieurs méthodes HTTP, middleware, et groupes de routes.</p>
            
            <h3>Routes de Base</h3>
            <div class="command-box">
                <div class="command-box-label">PHP</div>
                <pre><code>$router->get("/", "App\\Controllers\\HomeController@index");
$router->post("/users", "App\\Controllers\\UserController@store");
$router->put("/users/:id", "App\\Controllers\\UserController@update");
$router->delete("/users/:id", "App\\Controllers\\UserController@destroy");</code></pre>
            </div>
            
            <h3>Routes avec Middleware</h3>
            <div class="command-box">
                <div class="command-box-label">PHP</div>
                <pre><code>use Framework\Middleware\AuthMiddleware;

$router->get("/dashboard", "App\\Controllers\\DashboardController@index")
       ->middleware(AuthMiddleware::class);</code></pre>
            </div>
            
            <h3>Groupes de Routes</h3>
            <div class="command-box">
                <div class="command-box-label">PHP</div>
                <pre><code>$router->group(['prefix' => 'admin', 'middleware' => AuthMiddleware::class], function($router) {
    $router->get("/users", "App\\Controllers\\Admin\\UserController@index");
    $router->get("/posts", "App\\Controllers\\Admin\\PostController@index");
});</code></pre>
            </div>
        </div>
        
        <!-- Controllers Section -->
        <div class="content-section" id="controllers">
            <h2>🎮 Controllers</h2>
            <p>Les controllers gèrent la logique des requêtes et retournent des vues ou du JSON.</p>
            
            <div class="command-box">
                <div class="command-box-label">app/Controllers/UserController.php</div>
                <pre><code>&lt;?php
namespace App\Controllers;

use Framework\Core\Controller;
use Framework\Core\Request;
use App\Models\User;

class UserController extends Controller {
    
    public function index()
    {
        $users = (new User($this->db))->all('id');
        
        $this->view('users.index', [
            'users' => $users
        ]);
    }
    
    public function show($id)
    {
        $user = (new User($this->db))->findById($id, 'id');
        
        $this->view('users.show', [
            'user' => $user
        ]);
    }
}</code></pre>
            </div>
        </div>
        
        <!-- Models & Database Section -->
        <div class="content-section" id="models">
            <h2>🗄️ Models & Base de Données</h2>
            
            <h3>Créer un Model</h3>
            <div class="command-box">
                <div class="command-box-label">app/Models/Product.php</div>
                <pre><code>&lt;?php
namespace App\Models;

use Framework\Core\Model;

class Product extends Model {
    protected $table = 'products';
}</code></pre>
            </div>
            
            <h3>Utiliser le Query Builder</h3>
            <div class="command-box">
                <div class="command-box-label">PHP</div>
                <pre><code>use Framework\Database\QueryBuilder;

$qb = new QueryBuilder($db);

$products = $qb->table('products')
    ->where('price', '>', 100)
    ->orderBy('name')
    ->get();

$product = $qb->table('products')
    ->where('id', '=', 1)
    ->first();</code></pre>
            </div>
        </div>
        
        <!-- Relationships Section -->
        <div class="content-section" id="relationships">
            <h2>🔗 Relations de Base de Données</h2>
            
            <h3>hasMany (One to Many)</h3>
            <div class="command-box">
                <div class="command-box-label">PHP</div>
                <pre><code>class User extends Model {
    public function posts()
    {
        return $this->hasMany('App\\Models\\Post', 'user_id', 'id');
    }
}

// Utilisation
$user = $userModel->findById(1, 'id');
$posts = $user->posts()->get();</code></pre>
            </div>
            
            <h3>belongsTo (Inverse)</h3>
            <div class="command-box">
                <div class="command-box-label">PHP</div>
                <pre><code>class Post extends Model {
    public function user()
    {
        return $this->belongsTo('App\\Models\\User', 'user_id', 'id');
    }
}

// Utilisation
$post = $postModel->findById(1, 'id');
$author = $post->user()->get();</code></pre>
            </div>
            
            <h3>belongsToMany (Many to Many)</h3>
            <div class="command-box">
                <div class="command-box-label">PHP</div>
                <pre><code>class User extends Model {
    public function roles()
    {
        return $this->belongsToMany(
            'App\\Models\\Role',
            'user_roles',  // table pivot
            'user_id',
            'role_id'
        );
    }
}

// Utilisation
$roles = $user->roles()->get();
$user->roles()->attach(1);    // Attacher role
$user->roles()->detach(1);    // Détacher role
$user->roles()->sync([1,2]);  // Synchroniser</code></pre>
            </div>
        </div>
        
        <!-- Validation Section -->
        <div class="content-section" id="validation">
            <h2>✅ Validation</h2>
            <p>Système de validation complet avec 15+ règles.</p>
            
            <div class="command-box">
                <div class="command-box-label">PHP</div>
                <pre><code>use Framework\Validation\Validator;
use Framework\Core\Request;

$request = new Request();

$validator = new Validator($request->all(), [
    'email' => 'required|email',
    'name' => 'required|min:3',
    'age' => 'required|numeric|min:18',
    'password' => 'required|min:6',
    'password_confirmation' => 'required|same:password'
]);

if ($validator->fails()) {
    $_SESSION['errors'] = $validator->errors();
    $this->redirect('/form');
    return;
}

// Les données sont valides!</code></pre>
            </div>
            
            <h3>Règles Disponibles</h3>
            <ul>
                <li><code>required</code> - Champ requis</li>
                <li><code>email</code> - Email valide</li>
                <li><code>min:n</code> - Longueur minimum</li>
                <li><code>max:n</code> - Longueur maximum</li>
                <li><code>numeric</code> - Valeur numérique</li>
                <li><code>same:field</code> - Même valeur qu'un autre champ</li>
                <li><code>alpha</code> - Lettres seulement</li>
                <li><code>alphanumeric</code> - Lettres et chiffres</li>
                <li>Et plus...</li>
            </ul>
        </div>
        
        <!-- Authentication Section -->
        <div class="content-section" id="authentication">
            <h2>🔐 Authentification</h2>
            <p>Système d'authentification complet avec sessions et hashage des mots de passe.</p>
            
            <h3>Installation</h3>
            <div class="command-box">
                <div class="command-box-label">Terminal</div>
                <pre><code>php install-auth.php
php migrate.php</code></pre>
            </div>
            
            <h3>Protéger des Routes</h3>
            <div class="command-box">
                <div class="command-box-label">PHP</div>
                <pre><code>use Framework\Middleware\AuthMiddleware;

$router->group(['middleware' => AuthMiddleware::class], function($router) {
    $router->get("/dashboard", "App\\Controllers\\DashboardController@index");
    $router->get("/profile", "App\\Controllers\\ProfileController@show");
});</code></pre>
            </div>
            
            <h3>Vérifier l'Authentification</h3>
            <div class="command-box">
                <div class="command-box-label">PHP</div>
                <pre><code>use Framework\Auth\Auth;

$auth = new Auth($this->db);

if ($auth->check()) {
    $user = $auth->user();
    // Utilisateur connecté
}</code></pre>
            </div>
        </div>
        
        <!-- Migrations Section -->
        <div class="content-section" id="migrations">
            <h2>📦 Migrations</h2>
            
            <h3>Créer une Migration</h3>
            <div class="command-box">
                <div class="command-box-label">migrations/001_create_products_table.php</div>
                <pre><code>&lt;?php
use Framework\Database\Migration;
use Framework\Database\Schema;

class CreateProductsTable extends Migration {
    
    public function up(): void
    {
        $this->createTable('products', function(Schema $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->text('description');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        $this->dropTable('products');
    }
}</code></pre>
            </div>
            
            <h3>Exécuter les Migrations</h3>
            <div class="command-box">
                <div class="command-box-label">Terminal</div>
                <pre><code>php migrate.php</code></pre>
            </div>
        </div>
        
        <!-- Seeders Section -->
        <div class="content-section" id="seeders">
            <h2>🌱 Seeders</h2>
            
            <h3>Créer un Seeder</h3>
            <div class="command-box">
                <div class="command-box-label">seeders/ProductSeeder.php</div>
                <pre><code>&lt;?php
use Framework\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder {
    
    public function run(): void
    {
        $productModel = new Product($this->db);
        
        $products = [
            ['name' => 'Product 1', 'price' => 99.99],
            ['name' => 'Product 2', 'price' => 149.99],
        ];
        
        foreach ($products as $product) {
            $productModel->create($product);
        }
    }
}</code></pre>
            </div>
            
            <h3>Exécuter les Seeders</h3>
            <div class="command-box">
                <div class="command-box-label">Terminal</div>
                <pre><code># Tous les seeders
php seed.php

# Seeder spécifique
php seed.php ProductSeeder

# Via Composer
composer seed</code></pre>
            </div>
        </div>
        
        <!-- Testing Section -->
        <div class="content-section" id="testing">
            <h2>🧪 Tests</h2>
            
            <h3>Exécuter les Tests</h3>
            <div class="command-box">
                <div class="command-box-label">Terminal</div>
                <pre><code># Tous les tests
composer test

# Tests unitaires
vendor/bin/phpunit tests/Unit

# Test spécifique
vendor/bin/phpunit tests/Unit/ValidatorTest.php</code></pre>
            </div>
            
            <h3>Écrire un Test</h3>
            <div class="command-box">
                <div class="command-box-label">tests/Unit/MyTest.php</div>
                <pre><code>&lt;? namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class MyTest extends TestCase {
    
    public function testSomething()
    {
        $this->assertTrue(true);
    }
}</code></pre>
            </div>
        </div>
        
        <!-- Helpers Section -->
        <div class="content-section" id="helpers">
            <h2>🛠️ Helpers</h2>
            
            <h3>Fonctions Globales</h3>
            <div class="command-box">
                <div class="command-box-label">PHP</div>
                <pre><code>// Debug & Die
dd($variable);

// Redirection
redirect('/dashboard');

// Session
session('key', 'value');
$value = session('key');

// Configuration
$value = config('app.name', 'default');

// Request & Response
$request = request();
$response = response()->json(['status' => 'success']);

// CSRF Token
&lt;input type="hidden" name="_token" value="&lt;?= csrf_token() ?>"></code></pre>
            </div>
            
            <h3>String Helpers</h3>
            <div class="command-box">
                <div class="command-box-label">PHP</div>
                <pre><code>use Framework\Helpers\Str;

Str::slugify('Hello World');       // 'hello-world'
Str::camelCase('hello_world');     // 'helloWorld'
Str::snakeCase('HelloWorld');      // 'hello_world'
Str::random(10);                   // Random string</code></pre>
            </div>
            
            <h3>Array Helpers</h3>
            <div class="command-box">
                <div class="command-box-label">PHP</div>
                <pre><code>use Framework\Helpers\Arr;

Arr::get($array, 'user.name', 'default');
Arr::set($array, 'user.age', 25);
Arr::has($array, 'user.email');
Arr::pluck($users, 'name');</code></pre>
            </div>
        </div>
        
        <!-- Tailwind Section -->
        <div class="content-section" id="tailwind">
            <h2>🎨 Tailwind CSS</h2>
            
            <h3>Installation</h3>
            <div class="command-box">
                <div class="command-box-label">Terminal</div>
                <pre><code>php install-tailwind.php
npm install
npm run dev</code></pre>
            </div>
            
            <h3>Utilisation</h3>
            <div class="command-box">
                <div class="command-box-label">HTML</div>
                <pre><code>&lt;head>
    &lt;link rel="stylesheet" href="/css/output.css">
&lt;/head>

&lt;body class="bg-gray-100">
    &lt;div class="container mx-auto px-4">
        &lt;h1 class="text-3xl font-bold text-blue-600">
            Hello Tailwind!
        &lt;/h1>
        
        &lt;-- Composants préconfigurés -->
        &lt;button class="btn btn-primary">Click Me&lt;/button>
        &lt;div class="card">Content&lt;/div>
    &lt;/div>
&lt;/body></code></pre>
            </div>
            
            <div class="alert alert-info">
                <strong>💡 Pro Tip:</strong> Tailwind fonctionne parfaitement avec le CSS natif. Vous pouvez utiliser les deux ensemble!
            </div>
        </div>
        
        <!-- Footer Section -->
        <div class="content-section">
            <h2>🎉 Prêt à Commencer !</h2>
            <p>
                Vous avez maintenant toutes les connaissances nécessaires pour créer des applications web
                puissantes avec Market Framework.
            </p>
            
            <div class="alert alert-success">
                <strong>✓ Framework Complet:</strong> Auth, BDD, Relations, Migrations, Seeders, Tests, et plus encore !
            </div>
            
            <p style="margin-top: 2rem; text-align: center; color: #666;">
                Créé avec ❤️ par la communauté Market Framework
            </p>
        </div>
    </div>
</body>
</html>
