<?php
/**
 * Market Framework - Install Missing Pages
 * 
 * Usage: php install-pages.php
 */

$projectPath = __DIR__;

echo "Installing Missing Pages...\n";
echo "===========================\n\n";

// 1. Create About page view
$aboutView = <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Market Framework</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .header {
            text-align: center;
            margin-bottom: 3rem;
        }
        h1 {
            color: #667eea;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        .subtitle {
            color: #666;
            font-size: 1.1rem;
        }
        .section {
            margin-bottom: 2rem;
        }
        .section h2 {
            color: #333;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #667eea;
        }
        .section p {
            color: #666;
            line-height: 1.8;
            margin-bottom: 1rem;
        }
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
        }
        .feature {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 10px;
            text-align: center;
        }
        .feature h3 {
            color: #667eea;
            margin-bottom: 0.5rem;
        }
        .feature p {
            color: #666;
            font-size: 0.9rem;
        }
        .buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.2s;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>About Market Framework</h1>
            <p class="subtitle">A Modern PHP MVC Framework</p>
        </div>

        <div class="section">
            <h2>What is Market Framework?</h2>
            <p>
                Market Framework is a lightweight, modern PHP MVC framework designed to make 
                web development fast, efficient, and enjoyable. Built with simplicity and 
                power in mind, it provides all the tools you need to create robust web applications.
            </p>
        </div>

        <div class="section">
            <h2>Key Features</h2>
            <div class="features">
                <div class="feature">
                    <h3>🏗️ MVC Architecture</h3>
                    <p>Clean separation of concerns</p>
                </div>
                <div class="feature">
                    <h3>🔐 Authentication</h3>
                    <p>Built-in auth system</p>
                </div>
                <div class="feature">
                    <h3>🗄️ ORM</h3>
                    <p>Query Builder & Relations</p>
                </div>
                <div class="feature">
                    <h3>✅ Validation</h3>
                    <p>Comprehensive validation</p>
                </div>
                <div class="feature">
                    <h3>🛣️ Routing</h3>
                    <p>Advanced routing system</p>
                </div>
                <div class="feature">
                    <h3>🧪 Testing</h3>
                    <p>PHPUnit integration</p>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Getting Started</h2>
            <p>
                Getting started with Market Framework is easy. Create your models, controllers, 
                and views, define your routes, and you're ready to build amazing applications.
            </p>
            <p>
                The framework includes everything you need: authentication, database migrations, 
                seeders, validation, middleware, and much more.
            </p>
        </div>

        <div class="buttons">
            <a href="/register" class="btn btn-primary">Create an Account</a>
            <a href="/docs" class="btn btn-secondary">View Documentation</a>
            <a href="/" class="btn btn-secondary">Back to Home</a>
        </div>
    </div>
</body>
</html>
HTML;

file_put_contents($projectPath . '/views/about.php', $aboutView);
echo "✓ Created about page view\n";

// 2. Create Documentation page view
$docsView = <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentation - Market Framework</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: system-ui, -apple-system, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        .card {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 { color: white; margin: 0; }
        h2 { color: #667eea; margin-bottom: 1rem; }
        h3 { color: #333; margin: 1.5rem 0 0.5rem 0; }
        p { color: #666; line-height: 1.6; margin-bottom: 1rem; }
        code {
            background: #f5f5f5;
            padding: 0.2rem 0.5rem;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            color: #e83e8c;
        }
        pre {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 1rem;
            border-radius: 5px;
            overflow-x: auto;
            margin: 1rem 0;
        }
        pre code {
            background: none;
            color: #f8f8f2;
        }
        .back-link {
            display: inline-block;
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            background: rgba(255,255,255,0.2);
            border-radius: 5px;
            margin-left: 1rem;
        }
        .back-link:hover {
            background: rgba(255,255,255,0.3);
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Market Framework Documentation <a href="/" class="back-link">← Back to Home</a></h1>
    </div>

    <div class="container">
        <div class="card">
            <h2>Quick Start Guide</h2>
            
            <h3>1. Creating a Controller</h3>
            <pre><code>&lt;?php
namespace App\Controllers;

use Framework\Core\Controller;

class MyController extends Controller {
    public function index()
    {
        $this->view('my-view', ['data' => 'Hello World']);
    }
}</code></pre>

            <h3>2. Defining Routes</h3>
            <p>Add routes in <code>public/index.php</code>:</p>
            <pre><code>$router->get("/my-route", "App\\Controllers\\MyController@index");
$router->post("/submit", "App\\Controllers\\MyController@submit");</code></pre>

            <h3>3. Creating a Model</h3>
            <pre><code>&lt;?php
namespace App\Models;

use Framework\Core\Model;

class Product extends Model {
    protected $table = 'products';
}</code></pre>

            <h3>4. Using the Query Builder</h3>
            <pre><code>$products = $productModel->all('id');
$product = $productModel->findById(1, 'id');

// With Query Builder
use Framework\Database\QueryBuilder;
$qb = new QueryBuilder($db);
$products = $qb->table('products')
    ->where('price', '>', 100)
    ->orderBy('name')
    ->get();</code></pre>

            <h3>5. Validation</h3>
            <pre><code>use Framework\Validation\Validator;

$validator = new Validator($request->all(), [
    'email' => 'required|email',
    'name' => 'required|min:3',
    'age' => 'required|numeric|min:18'
]);

if ($validator->fails()) {
    $_SESSION['errors'] = $validator->errors();
    $this->redirect('/form');
}</code></pre>
        </div>

        <div class="card">
            <h2>Authentication</h2>
            <p>The framework includes a complete authentication system.</p>
            
            <h3>Protecting Routes</h3>
            <pre><code>use Framework\Middleware\AuthMiddleware;

$router->group(['middleware' => AuthMiddleware::class], function($router) {
    $router->get("/dashboard", "App\\Controllers\\DashboardController@index");
});</code></pre>

            <h3>Checking Authentication</h3>
            <pre><code>use Framework\Auth\Auth;

$auth = new Auth($this->db);
if ($auth->check()) {
    $user = $auth->user();
}</code></pre>
        </div>

        <div class="card">
            <h2>Database Migrations</h2>
            <p>Create and run database migrations easily.</p>
            
            <h3>Creating a Migration</h3>
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
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        $this->dropTable('products');
    }
}</code></pre>

            <h3>Running Migrations</h3>
            <pre><code>php migrate.php</code></pre>
        </div>

        <div class="card">
            <h2>Need More Help?</h2>
            <p>Check out the complete documentation in the framework's README.md file or visit the GitHub repository for more examples and guides.</p>
        </div>
    </div>
</body>
</html>
HTML;

file_put_contents($projectPath . '/views/docs.php', $docsView);
echo "✓ Created documentation page view\n";

// 3. Auto-inject routes into public/index.php
$indexPath = $projectPath . '/public/index.php';
if (file_exists($indexPath)) {
    $indexContent = file_get_contents($indexPath);
    
    // Check if routes are already added
    if (strpos($indexContent, '/about') === false) {
        // Find the position to insert routes (before authentication routes or run)
        $searchPattern = '// Run the router';
        $pos = strpos($indexContent, $searchPattern);
        
        if ($pos !== false) {
            $routesToAdd = <<<'ROUTES'

// ============================================
// Public Pages (Auto-generated)
// ============================================
$router->get("/about", "App\\Controllers\\HomeController@about");
$router->get("/docs", "App\\Controllers\\HomeController@docs");

ROUTES;
            
            $indexContent = substr_replace($indexContent, $routesToAdd, $pos, 0);
            file_put_contents($indexPath, $indexContent);
            echo "✓ Routes automatically added to public/index.php\n";
        }
    } else {
        echo "✓ Routes already exist in public/index.php\n";
    }
}

// 4. Update HomeController with new methods
$homeControllerPath = $projectPath . '/app/Controllers/HomeController.php';
if (file_exists($homeControllerPath)) {
    $homeControllerContent = file_get_contents($homeControllerPath);
    
    // Check if methods already exist
    if (strpos($homeControllerContent, 'function about') === false) {
        // Add methods before the closing brace
        $newMethods = <<<'PHP'
    
    public function about()
    {
        $this->view('about', [
            'title' => 'About Market Framework'
        ]);
    }
    
    public function docs()
    {
        $this->view('docs', [
            'title' => 'Documentation'
        ]);
    }
PHP;
        
        // Find last closing brace
        $pos = strrpos($homeControllerContent, '}');
        if ($pos !== false) {
            $homeControllerContent = substr_replace($homeControllerContent, $newMethods . "\n}", $pos, 1);
            file_put_contents($homeControllerPath, $homeControllerContent);
            echo "✓ Added about() and docs() methods to HomeController\n";
        }
    } else {
        echo "✓ Methods already exist in HomeController\n";
    }
}

echo "\n";
echo "========================================\n";
echo "Pages installed successfully!\n";
echo "========================================\n";
echo "\n";
echo "✅ Created Files:\n";
echo "   - views/about.php\n";
echo "   - views/docs.php\n";
echo "\n";
echo "✅ Routes automatically added:\n";
echo "   - GET /about\n";
echo "   - GET /docs\n";
echo "\n";
echo "✅ Updated:\n";
echo "   - app/Controllers/HomeController.php\n";
echo "\n";
echo "🚀 You can now visit:\n";
echo "   - http://localhost:8000/about\n";
echo "   - http://localhost:8000/docs\n";
echo "\n";
echo "Done! 🎉\n";
