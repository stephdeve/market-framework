<?php
/**
 * Market Framework - Project Creator
 * 
 * Usage: php create-project.php project-name
 */

if ($argc < 2) {
    die("Usage: php create-project.php project-name\n");
}

$projectName = $argv[1];
$frameworkPath = __DIR__;
$projectPath = dirname($frameworkPath) . DIRECTORY_SEPARATOR . $projectName;

echo "Creating new Market Framework project: {$projectName}\n";
echo "Location: {$projectPath}\n\n";

// Check if directory exists
if (file_exists($projectPath)) {
    die("Error: Directory '{$projectName}' already exists!\n");
}

// Create project directory
mkdir($projectPath);
echo "✓ Created project directory\n";

// Create subdirectories
$dirs = [
    'app', 'app/Controllers', 'app/Models',
    'config', 'migrations', 'seeders',
    'public', 'public/css', 'public/js',
    'views', 'views/layouts',
    'logs'
];

foreach ($dirs as $dir) {
    mkdir($projectPath . DIRECTORY_SEPARATOR . $dir, 0777, true);
}
echo "✓ Created directory structure\n";

// Create composer.json
$composerJson = [
    'name' => 'app/' . strtolower($projectName),
    'description' => 'Application created with Market Framework',
    'type' => 'project',
    'require' => [
        'php' => '>=7.4'
    ],
    'repositories' => [
        [
            'type' => 'path',
            'url' => '../framework'
        ]
    ],
    'autoload' => [
        'psr-4' => [
            'App\\' => 'app/'
        ]
    ],
    'scripts' => [
        'serve' => 'php -S localhost:8000 -t public',
        'migrate' => 'php migrate.php',
        'seed' => 'php seed.php'
    ]
];

file_put_contents(
    $projectPath . '/composer.json',
    json_encode($composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
);
echo "✓ Created composer.json\n";

// Copy essential files from demo
$filesToCopy = [
    'demo/public/index.php' => 'public/index.php',
    'demo/public/.htaccess' => 'public/.htaccess',
    'demo/migrate.php' => 'migrate.php',
    'demo/seed.php' => 'seed.php',
    'demo/config/app.php' => 'config/app.php',
    'demo/config/database.php' => 'config/database.php',
    'demo/.env.example' => '.env.example',
];

foreach ($filesToCopy as $source => $dest) {
    $sourcePath = $frameworkPath . DIRECTORY_SEPARATOR . $source;
    $destPath = $projectPath . DIRECTORY_SEPARATOR . $dest;
    
    if (file_exists($sourcePath)) {
        copy($sourcePath, $destPath);
    }
}
echo "✓ Copied configuration files\n";

// Create autoload.php for the project
$autoload = <<<'PHP'
<?php
// Custom autoloader for the application

spl_autoload_register(function ($class) {
    // Framework namespace
    if (strpos($class, 'Framework\\') === 0) {
        $relativePath = str_replace('Framework\\', '', $class);
        $relativePath = str_replace('\\', DIRECTORY_SEPARATOR, $relativePath);
        $file = __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'market-framework' . DIRECTORY_SEPARATOR . $relativePath . '.php';
        
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    }
    
    // App namespace
    if (strpos($class, 'App\\') === 0) {
        $relativePath = str_replace('App\\', '', $class);
        $relativePath = str_replace('\\', DIRECTORY_SEPARATOR, $relativePath);
        $file = __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $relativePath . '.php';
        
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    }
    
    return false;
});

// Load framework helpers
$helpersFile = __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'market-framework' . DIRECTORY_SEPARATOR . 'helpers.php';
if (file_exists($helpersFile)) {
    require_once $helpersFile;
}
PHP;

file_put_contents($projectPath . '/autoload.php', $autoload);
echo "✓ Created autoload.php\n";

// Create migrate.php
$migratePhp = <<<'PHP'
<?php
require_once __DIR__ . '/autoload.php';

use Framework\Core\Database;
use Framework\Database\MigrationRunner;
use Framework\Config\Config;

echo "Running Migrations...\n";

// Load configuration
Config::load(__DIR__ . '/config');

// Database configuration
$dbConfig = Config::get('database');
$db = new Framework\Core\Database(
    $dbConfig['dbname'],
    $dbConfig['host'],
    $dbConfig['username'],
    $dbConfig['password']
);

// Run migrations
$migrationRunner = new MigrationRunner($db, __DIR__ . '/migrations');

if (isset($argv[1]) && $argv[1] === 'rollback') {
    $migrationRunner->rollback();
} else {
    $migrationRunner->migrate();
}

echo "Done.\n";
PHP;

file_put_contents($projectPath . '/migrate.php', $migratePhp);
echo "✓ Created migrate.php\n";

// Create seed.php
$seedPhp = <<<'PHP'
<?php
require_once __DIR__ . '/autoload.php';

use Framework\Core\Database;
use Framework\Database\SeederRunner;
use Framework\Config\Config;

echo "Running Seeders...\n";

// Load configuration
Config::load(__DIR__ . '/config');

// Database configuration
$dbConfig = Config::get('database');
$db = new Framework\Core\Database(
    $dbConfig['dbname'],
    $dbConfig['host'],
    $dbConfig['username'],
    $dbConfig['password']
);

// Run seeders
$seederRunner = new SeederRunner($db, __DIR__ . '/seeders');

if (isset($argv[1])) {
    // Run specific seeder
    $seederClass = $argv[1];
    require_once __DIR__ . '/seeders/' . $seederClass . '.php';
    $seederRunner->seed($seederClass);
} else {
    // Run all seeders
    $seederRunner->seedAll();
}

echo "Done.\n";
PHP;

file_put_contents($projectPath . '/seed.php', $seedPhp);
echo "✓ Created seed.php\n";

// Create public/index.php
$indexPhp = <<<'PHP'
<?php
// Start session for authentication and flash messages
session_start();

// Load framework autoloader
require_once __DIR__ . '/../autoload.php';

use Framework\Core\Database;
use Framework\Routing\Router;
use Framework\Exceptions\NotFoundException;
use Framework\Config\Config;

// Load configuration
Config::load(__DIR__ . '/../config');

// Database configuration from config file
$dbConfig = Config::get('database');
$db = new Database(
    $dbConfig['dbname'],
    $dbConfig['host'],
    $dbConfig['username'],
    $dbConfig['password']
);

// Views path
define('VIEWS', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);

// Get the URL path (works with both Apache and PHP built-in server)
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$requestUri = parse_url($requestUri, PHP_URL_PATH);
$requestUri = $requestUri === '/' ? '' : $requestUri;

// Initialize router
$router = new Router($requestUri, $db, VIEWS);

// Define your routes here
$router->get("/", "App\\Controllers\\HomeController@index");

// Run the router
try {
    $router->run();
} catch(NotFoundException $e) {
    echo $e->error404();
}
PHP;

file_put_contents($projectPath . '/public/index.php', $indexPhp);
echo "✓ Created public/index.php\n";

// Copy .htaccess
copy($frameworkPath . '/demo/public/.htaccess', $projectPath . '/public/.htaccess');

// Create default HomeController
$homeController = <<<'PHP'
<?php
namespace App\Controllers;

use Framework\Core\Controller;

class HomeController extends Controller {
    
    public function index()
    {
        $this->view('home', [
            'title' => 'Welcome to Market Framework'
        ]);
    }
}
PHP;

file_put_contents($projectPath . '/app/Controllers/HomeController.php', $homeController);
echo "✓ Created HomeController\n";

// Create default view
$homeView = <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Market Framework' ?></title>
    <style>
        body {
            font-family: system-ui, -apple-system, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .container {
            text-align: center;
            padding: 2rem;
        }
        h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        p {
            font-size: 1.25rem;
            opacity: 0.9;
        }
        .links {
            margin-top: 2rem;
        }
        .links a {
            color: white;
            text-decoration: none;
            margin: 0 1rem;
            padding: 0.5rem 1rem;
            border: 2px solid white;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .links a:hover {
            background: white;
            color: #667eea;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= htmlspecialchars($title) ?></h1>
        <p>Your application is ready!</p>
        <div class="links">
            <a href="https://github.com/market-framework" target="_blank">Documentation</a>
            <a href="/about">Get Started</a>
        </div>
    </div>
</body>
</html>
HTML;

file_put_contents($projectPath . '/views/home.php', $homeView);
echo "✓ Created home view\n";

// Create README
$readme = <<<MD
# {$projectName}

Application created with Market Framework.

## Installation

1. Install dependencies:
```bash
composer install
```

2. Configure database in `config/database.php`

3. Run migrations:
```bash
php migrate.php
```

4. Start server:
```bash
composer serve
```

5. Visit http://localhost:8000

## Commands

- `composer serve` - Start development server
- `php migrate.php` - Run database migrations
- `php seed.php` - Run seeders

## Documentation

See the Market Framework documentation for more information.
MD;

file_put_contents($projectPath . '/README.md', $readme);
echo "✓ Created README.md\n";

// Copy framework to vendor/market-framework
$vendorPath = $projectPath . DIRECTORY_SEPARATOR . 'vendor';
$marketFrameworkPath = $vendorPath . DIRECTORY_SEPARATOR . 'market-framework';

if (!file_exists($vendorPath)) {
    mkdir($vendorPath);
}

echo "Copying framework to vendor...\n";

// Function to recursively copy directory
function copyDirectory($src, $dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                // Skip demo, tests, and vendor directories
                if (in_array($file, ['demo', 'tests', 'vendor', '.git'])) {
                    continue;
                }
                copyDirectory($src . '/' . $file, $dst . '/' . $file);
            } else {
                // Skip certain files
                if (in_array($file, ['create-project.php', 'INSTALLATION.md', 'composer.lock'])) {
                    continue;
                }
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

copyDirectory($frameworkPath, $marketFrameworkPath);
echo "✓ Framework copied to vendor/market-framework\n";

echo "\n";
echo "========================================\n";
echo "Project '{$projectName}' created successfully!\n";
echo "========================================\n";
echo "\n";
echo "Next steps:\n";
echo "1. cd {$projectName}\n";
echo "2. Copy .env.example to .env and configure\n";
echo "3. Configure database in config/database.php\n";
echo "4. Run: composer install\n";
echo "5. Run: php migrate.php\n";
echo "6. Run: composer serve\n";
echo "7. Visit: http://localhost:8000\n";
echo "\n";
echo "Happy coding! 🚀\n";
