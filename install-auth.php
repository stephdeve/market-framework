<?php
/**
 * Market Framework - Authentication Installer
 * 
 * Usage: php install-auth.php
 */

$projectPath = __DIR__;

echo "Installing Authentication System...\n";
echo "===================================\n\n";

// 1. Create User model if it doesn't exist
if (!file_exists($projectPath . '/app/Models/User.php')) {
    $userModel = <<<'PHP'
<?php
namespace App\Models;

use Framework\Core\Model;

#[AllowDynamicProperties]
class User extends Model {
    protected $table = 'users';
    
    /**
     * Find a user by email
     */
    public function findByEmail(string $email)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE email = ?", [$email], true);
    }
    
    /**
     * Check if email exists
     */
    public function emailExists(string $email): bool
    {
        $user = $this->findByEmail($email);
        return $user !== false && $user !== null;
    }
}
PHP;
    
    file_put_contents($projectPath . '/app/Models/User.php', $userModel);
    echo "✓ Created User model\n";
} else {
    echo "✓ User model already exists\n";
}

// 2. Create AuthController
$authController = <<<'PHP'
<?php
namespace App\Controllers;

use Framework\Core\Controller;
use Framework\Core\Request;
use Framework\Validation\Validator;
use Framework\Auth\Auth;
use App\Models\User;

class AuthController extends Controller {
    
    public function showLogin()
    {
        $this->view('auth.login', [
            'title' => 'Login'
        ]);
    }
    
    public function login()
    {
        $request = new Request();
        
        $validator = new Validator($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if ($validator->fails()) {
            $_SESSION['errors'] = $validator->errors();
            $this->redirect('/login');
            return;
        }
        
        $auth = new Auth($this->db);
        
        if ($auth->attempt($request->input('email'), $request->input('password'))) {
            $this->redirect('/dashboard');
        } else {
            $_SESSION['errors'] = ['auth' => ['Invalid credentials']];
            $this->redirect('/login');
        }
    }
    
    public function showRegister()
    {
        $this->view('auth.register', [
            'title' => 'Register'
        ]);
    }
    
    public function register()
    {
        $request = new Request();
        
        $validator = new Validator($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password'
        ]);
        
        if ($validator->fails()) {
            $_SESSION['errors'] = $validator->errors();
            $_SESSION['old'] = $request->except(['password', 'password_confirmation']);
            $this->redirect('/register');
            return;
        }
        
        $auth = new Auth($this->db);
        
        if ($auth->register($request->only(['name', 'email', 'password']))) {
            $_SESSION['success'] = 'Account created successfully! Please login.';
            $this->redirect('/login');
        } else {
            $_SESSION['errors'] = ['registration' => ['Registration failed. Email may already exist.']];
            $this->redirect('/register');
        }
    }
    
    public function logout()
    {
        $auth = new Auth($this->db);
        $auth->logout();
        $this->redirect('/');
    }
}
PHP;

file_put_contents($projectPath . '/app/Controllers/AuthController.php', $authController);
echo "✓ Created AuthController\n";

// 3. Create auth views directory
if (!file_exists($projectPath . '/views/auth')) {
    mkdir($projectPath . '/views/auth', 0777, true);
}

// 4. Create login view
$loginView = <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        h1 { color: #333; margin-bottom: 1.5rem; text-align: center; }
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; margin-bottom: 0.5rem; color: #555; font-weight: 500; }
        input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        input:focus {
            outline: none;
            border-color: #667eea;
        }
        .btn {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .btn:hover { transform: translateY(-2px); }
        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        .alert-error {
            background: #fee;
            border: 1px solid #fcc;
            color: #c00;
        }
        .form-footer {
            text-align: center;
            margin-top: 1rem;
            color: #666;
        }
        .form-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        
        <?php if(isset($_SESSION['errors'])): ?>
            <div class="alert alert-error">
                <?php foreach($_SESSION['errors'] as $field => $errors): ?>
                    <?php foreach($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <?php unset($_SESSION['errors']); ?>
            </div>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert" style="background: #efe; border: 1px solid #cfc; color: #060;">
                <p><?= htmlspecialchars($_SESSION['success']) ?></p>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="/login">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">Login</button>
            
            <p class="form-footer">
                Don't have an account? <a href="/register">Register here</a>
            </p>
        </form>
    </div>
</body>
</html>
HTML;

file_put_contents($projectPath . '/views/auth/login.php', $loginView);
echo "✓ Created login view\n";

// 5. Create register view
$registerView = <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        h1 { color: #333; margin-bottom: 1.5rem; text-align: center; }
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; margin-bottom: 0.5rem; color: #555; font-weight: 500; }
        input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e0e0e0;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        input:focus {
            outline: none;
            border-color: #667eea;
        }
        .btn {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .btn:hover { transform: translateY(-2px); }
        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        .alert-error {
            background: #fee;
            border: 1px solid #fcc;
            color: #c00;
        }
        .form-footer {
            text-align: center;
            margin-top: 1rem;
            color: #666;
        }
        .form-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        
        <?php if(isset($_SESSION['errors'])): ?>
            <div class="alert alert-error">
                <?php foreach($_SESSION['errors'] as $field => $errors): ?>
                    <?php foreach($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <?php unset($_SESSION['errors']); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="/register">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($_SESSION['old']['name'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>
            
            <button type="submit" class="btn">Register</button>
            
            <p class="form-footer">
                Already have an account? <a href="/login">Login here</a>
            </p>
        </form>
    </div>
    <?php unset($_SESSION['old']); ?>
</body>
</html>
HTML;

file_put_contents($projectPath . '/views/auth/register.php', $registerView);
echo "✓ Created register view\n";

// 6. Create users migration if it doesn't exist
$migrationFile = null;
$migrationsDir = $projectPath . '/migrations';

// Check if users migration already exists
if (is_dir($migrationsDir)) {
    $files = scandir($migrationsDir);
    foreach ($files as $file) {
        if (strpos($file, 'users') !== false) {
            $migrationFile = $file;
            break;
        }
    }
}

if (!$migrationFile) {
    // Find the next migration number
    $files = scandir($migrationsDir);
    $maxNumber = 0;
    foreach ($files as $file) {
        if (preg_match('/^(\d+)_/', $file, $matches)) {
            $maxNumber = max($maxNumber, (int)$matches[1]);
        }
    }
    $nextNumber = str_pad($maxNumber + 1, 3, '0', STR_PAD_LEFT);
    
    $migrationContent = <<<'PHP'
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
PHP;
    
    $migrationFile = $nextNumber . '_create_users_table.php';
    file_put_contents($migrationsDir . '/' . $migrationFile, $migrationContent);
    echo "✓ Created users migration: {$migrationFile}\n";
} else {
    echo "✓ Users migration already exists: {$migrationFile}\n";
}

// 7. Create DashboardController
$dashboardController = <<<'PHP'
<?php
namespace App\Controllers;

use Framework\Core\Controller;
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
        
        $this->view('dashboard', [
            'title' => 'Dashboard',
            'user' => $user
        ]);
    }
}
PHP;

file_put_contents($projectPath . '/app/Controllers/DashboardController.php', $dashboardController);
echo "✓ Created DashboardController\n";

// 8. Create dashboard view
$dashboardView = <<<'HTML'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar h1 { font-size: 1.5rem; }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border: 2px solid white;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .navbar a:hover {
            background: white;
            color: #667eea;
        }
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        .welcome-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .welcome-card h2 {
            color: #333;
            margin-bottom: 1rem;
        }
        .welcome-card p {
            color: #666;
            line-height: 1.6;
        }
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }
        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card h3 {
            color: #667eea;
            margin-bottom: 0.5rem;
        }
        .card p {
            color: #666;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Market Framework</h1>
        <div>
            <span style="margin-right: 1rem;">Welcome, <?= htmlspecialchars($user->name) ?>!</span>
            <a href="/logout">Logout</a>
        </div>
    </div>
    
    <div class="container">
        <div class="welcome-card">
            <h2>Welcome to your Dashboard!</h2>
            <p>You are now logged in. This is a protected area that requires authentication to access.</p>
            <p style="margin-top: 0.5rem;"><strong>Email:</strong> <?= htmlspecialchars($user->email) ?></p>
        </div>
        
        <div class="cards">
            <div class="card">
                <h3>🔐 Authentication</h3>
                <p>Your authentication system is working perfectly!</p>
            </div>
            <div class="card">
                <h3>🛡️ Protected Routes</h3>
                <p>This page is protected by AuthMiddleware.</p>
            </div>
            <div class="card">
                <h3>🚀 Ready to Build</h3>
                <p>Start building your amazing application now!</p>
            </div>
        </div>
    </div>
</body>
</html>
HTML;

file_put_contents($projectPath . '/views/dashboard.php', $dashboardView);
echo "✓ Created dashboard view\n";

// 9. Auto-inject routes into public/index.php
$indexPath = $projectPath . '/public/index.php';
if (file_exists($indexPath)) {
    $indexContent = file_get_contents($indexPath);
    
    // Check if routes are already added
    if (strpos($indexContent, 'AuthController') === false) {
        // Find the position to insert routes (before $router->run())
        $searchPattern = '// Run the router';
        $pos = strpos($indexContent, $searchPattern);
        
        if ($pos !== false) {
            $routesToAdd = <<<'ROUTES'

// ============================================
// Authentication Routes (Auto-generated)
// ============================================
$router->get("/login", "App\\Controllers\\AuthController@showLogin");
$router->post("/login", "App\\Controllers\\AuthController@login");
$router->get("/register", "App\\Controllers\\AuthController@showRegister");
$router->post("/register", "App\\Controllers\\AuthController@register");
$router->get("/logout", "App\\Controllers\\AuthController@logout");

// Protected Routes (Require Authentication)
use Framework\Middleware\AuthMiddleware;

$router->group(['middleware' => AuthMiddleware::class], function($router) {
    $router->get("/dashboard", "App\\Controllers\\DashboardController@index");
});

ROUTES;
            
            $indexContent = substr_replace($indexContent, $routesToAdd, $pos, 0);
            file_put_contents($indexPath, $indexContent);
            echo "✓ Routes automatically added to public/index.php\n";
        } else {
            echo "⚠ Could not auto-inject routes. Please add manually.\n";
        }
    } else {
        echo "✓ Routes already exist in public/index.php\n";
    }
}

echo "\n";
echo "========================================\n";
echo "Authentication installed successfully!\n";
echo "========================================\n";
echo "\n";
echo "✅ Created Files:\n";
echo "   - app/Models/User.php\n";
echo "   - app/Controllers/AuthController.php\n";
echo "   - app/Controllers/DashboardController.php\n";
echo "   - views/auth/login.php\n";
echo "   - views/auth/register.php\n";
echo "   - views/dashboard.php\n";
echo "   - migrations/{$migrationFile}\n";
echo "\n";
echo "✅ Routes automatically added to public/index.php:\n";
echo "   - GET  /login\n";
echo "   - POST /login\n";
echo "   - GET  /register\n";
echo "   - POST /register\n";
echo "   - GET  /logout\n";
echo "   - GET  /dashboard (protected)\n";
echo "\n";
echo "🚀 Next steps:\n";
echo "1. Run migrations: php migrate.php\n";
echo "2. Visit: http://localhost:8000/register\n";
echo "3. Create an account and login\n";
echo "4. Access your dashboard at /dashboard\n";
echo "\n";
echo "Done! 🎉\n";

