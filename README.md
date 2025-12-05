# Market Framework

A comprehensive, lightweight PHP MVC framework with modern features and clean architecture.

## Features

- **🏗️ MVC Architecture**: Clear separation of concerns with Models, Views, and Controllers
- **🛣️ Advanced Routing**: Support for GET, POST, PUT, DELETE, PATCH with middleware and route groups
- **🔐 Authentication**: Built-in authentication system with session management
- **✅ Validation**: Comprehensive validation system with multiple rules
- **🗄️ Query Builder**: Fluent SQL query builder for elegant database operations
- **📦 Migrations**: Database migration system for version control
- **🔗 Relationships**: Full ORM relationships (hasMany, belongsTo, hasOne, belongsToMany)
- **🌱 Seeders**: Database seeding system for test data
- **🔧 Middleware**: Flexible middleware system for request filtering
- **⚙️ Configuration**: Environment-based configuration management
- **🛠️ Helpers**: Useful helper functions and classes
- **📝 Logging**: Multi-level logging system
- **🧪 Testing**: PHPUnit integration for unit and feature tests
- **🎨 Modern**: PSR-4 autoloading and best practices

## Requirements

- PHP >= 7.4
- PDO Extension
- mod_rewrite (for clean URLs)
- MySQL/MariaDB

## Installation

1. Clone or download the framework
2. Include it in your project via Composer or manually

### Via Composer (recommended)

```bash
composer require market-framework/core
```

### Manual Installation

Copy the framework directory to your project and include the autoloader.

## Quick Start

See the `demo/` directory for a complete working example.

## Core Components

### 1. Routing

The router supports multiple HTTP methods, middleware, and route groups.

```php
use Framework\Routing\Router;
use Framework\Middleware\AuthMiddleware;

$router = new Router($_GET["url"] ?? '', $db, VIEWS);

// Basic routes
$router->get("/", "App\\Controllers\\HomeController@index");
$router->post("/users", "App\\Controllers\\UserController@store");
$router->put("/users/:id", "App\\Controllers\\UserController@update");
$router->delete("/users/:id", "App\\Controllers\\UserController@destroy");

// Route with middleware
$router->get("/dashboard", "App\\Controllers\\DashboardController@index")
       ->middleware(AuthMiddleware::class);

// Route groups
$router->group(['prefix' => 'api', 'middleware' => AuthMiddleware::class], function($router) {
    $router->get("/users", "App\\Controllers\\Api\\UserController@index");
    $router->post("/users", "App\\Controllers\\Api\\UserController@store");
});

// Named routes
$router->get("/users/:id", "App\\Controllers\\UserController@show")
       ->name('users.show');

$router->run();
```

### 2. Controllers

Controllers handle request logic and return views or JSON responses.

```php
namespace App\Controllers;

use Framework\Core\Controller;
use Framework\Core\Request;

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
        
        return $this->json([
            'success' => true,
            'data' => $user
        ]);
    }
}
```

### 3. Models

Models provide database interaction through an active record pattern.

```php
namespace App\Models;

use Framework\Core\Model;

class User extends Model {
    protected $table = 'users';
    
    // Custom methods
    public function findByEmail(string $email)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE email = ?", 
            [$email], 
            true
        );
    }
}

// Usage
$userModel = new User($db);
$users = $userModel->all('created_at');
$user = $userModel->findById(1, 'id');
$userModel->create(['name' => 'John', 'email' => 'john@example.com']);
$userModel->update(1, ['name' => 'Jane']);
$userModel->destroy(1);
```

### 4. Query Builder

Build complex queries fluently.

```php
use Framework\Database\QueryBuilder;

$qb = new QueryBuilder($db);

// Select
$users = $qb->table('users')
            ->select(['id', 'name', 'email'])
            ->where('status', '=', 'active')
            ->orderBy('created_at', 'DESC')
            ->limit(10)
            ->get();

// Joins
$posts = $qb->table('posts')
            ->select('posts.*, users.name as author')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->where('posts.published', '=', 1)
            ->get();

// Insert
$qb->table('users')->insert([
    'name' => 'John Doe',
    'email' => 'john@example.com'
]);

// Update
$qb->table('users')
   ->where('id', '=', 1)
   ->update(['name' => 'Jane Doe']);

// Delete
$qb->table('users')
   ->where('id', '=', 1)
   ->delete();
```

### 5. Validation

Validate request data with ease.

```php
use Framework\Validation\Validator;
use Framework\Core\Request;

$request = new Request();

$validator = new Validator($request->all(), [
    'name' => 'required|min:3|max:50',
    'email' => 'required|email',
    'age' => 'numeric|min:18',
    'password' => 'required|min:6',
    'password_confirmation' => 'same:password'
]);

if ($validator->fails()) {
    $errors = $validator->errors();
    // Handle errors
}
```

**Available validation rules:**
- `required`, `email`, `numeric`, `integer`, `alpha`, `alphanumeric`
- `min:n`, `max:n`, `url`, `confirmed`, `same:field`, `different:field`
- `in:val1,val2`, `notIn:val1,val2`

### 6. Authentication

Simple authentication system with session management.

```php
use Framework\Auth\Auth;

$auth = new Auth($db);

// Register
$auth->register([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => 'secret'
]);

// Login
if ($auth->attempt('john@example.com', 'secret')) {
    // Login successful
}

// Check authentication
if ($auth->check()) {
    $user = $auth->user();
}

// Logout
$auth->logout();
```

### 7. Middleware

Create custom middleware to filter requests.

```php
namespace App\Middleware;

use Framework\Middleware\Middleware;
use Framework\Core\Request;

class CustomMiddleware implements Middleware {
    
    public function handle(Request $request, callable $next)
    {
        // Before logic
        if (!someCondition()) {
            abort(403);
        }
        
        // Continue to next middleware/controller
        $response = $next($request);
        
        // After logic
        
        return $response;
    }
}
```

### 8. Migrations

Manage database schema with migrations.

```php
// migrations/001_create_users_table.php
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

Run migrations:
```php
use Framework\Database\MigrationRunner;

$runner = new MigrationRunner($db, './migrations');
$runner->migrate();
$runner->rollback(); // Rollback last batch
```

### 9. Configuration

Manage application configuration.

```php
use Framework\Config\Config;

// Load config files from directory
Config::load('./config');

// Get values with dot notation
$dbHost = Config::get('database.host');
$appName = Config::get('app.name', 'Default Name');

// Set values
Config::set('app.debug', true);
```

### 10. Helper Functions

Convenient global helper functions.

```php
// Debugging
dd($variable); // Dump and die
dump($variable); // Dump

// Request & Response
$request = request();
$email = $request->input('email');

return json(['status' => 'success']);
return redirect('/users');
return back();

// Session
session('key', 'value');
$value = session('key');

// Environment
$debug = env('APP_DEBUG', false);

// Configuration
$name = config('app.name');

// URLs & Assets
$url = url('/path');
$asset = asset('css/style.css');

// CSRF
echo csrf_field();
$token = csrf_token();

// Method override
echo method_field('PUT');
```

### 11. Logging

Log application events and errors.

```php
use Framework\Logging\Logger;

$logger = new Logger('./logs');

$logger->debug('Debug message');
$logger->info('Info message');
$logger->warning('Warning message');
$logger->error('Error message');
$logger->critical('Critical message');

// Log exceptions
try {
    // code
} catch (\Exception $e) {
    $logger->exception($e);
}
```

## Project Structure

```
your-project/
├── app/
│   ├── Controllers/
│   └── Models/
├── config/
│   ├── app.php
│   └── database.php
├── migrations/
├── public/
│   ├── css/
│   ├── js/
│   ├── .htaccess
│   └── index.php
├── views/
│   └── layout.php
├── logs/
├── .env
└── composer.json
```

## Environment Configuration

Create a `.env` file in your project root:

```env
DB_HOST=localhost
DB_NAME=your_database
DB_USER=root
DB_PASS=
APP_ENV=development
APP_DEBUG=true
```

## Complete Example

See the `demo/` directory for a complete working application with:
- User authentication (login/register)
- User management (CRUD)
- Protected routes with middleware
- Form validation
- Database migrations
- Database relationships (User hasMany Posts)
- Seeders for test data
- Responsive UI

## Database Relationships

Define relationships between models using the `HasRelationships` trait.

### One to Many (hasMany)

```php
class User extends Model {
    public function posts()
    {
        return $this->hasMany('App\\Models\\Post', 'user_id', 'id');
    }
}

// Usage
$user = $userModel->findById(1, 'id');
$posts = $user->posts()->get(); // Get all posts
$first = $user->posts()->first(); // Get first post
```

### Belongs To (belongsTo)

```php
class Post extends Model {
    public function user()
    {
        return $this->belongsTo('App\\Models\\User', 'user_id', 'id');
    }
}

// Usage
$post = $postModel->findById(1, 'id');
$author = $post->user()->get(); // Get the author
```

### One to One (hasOne)

```php
class User extends Model {
    public function profile()
    {
        return $this->hasOne('App\\Models\\Profile', 'user_id', 'id');
    }
}

// Usage
$user = $userModel->findById(1, 'id');
$profile = $user->profile()->get();
```

### Many to Many (belongsToMany)

```php
class User extends Model {
    public function roles()
    {
        return $this->belongsToMany(
            'App\\Models\\Role',
            'user_roles',      // pivot table
            'user_id',          // foreign key
            'role_id'           // related key
        );
    }
}

// Usage
$user = $userModel->findById(1, 'id');
$roles = $user->roles()->get();

// Attach/Detach
$user->roles()->attach(1); // Attach role ID 1
$user->roles()->detach(1); // Detach role ID 1
$user->roles()->sync([1, 2, 3]); // Sync to specific IDs
```

## Database Seeders

Populate your database with test data using seeders.

### Creating a Seeder

```php
// demo/seeders/UserSeeder.php
use Framework\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder {
    public function run(): void
    {
        $userModel = new User($this->db);
        
        $userModel->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Auth::hash('password')
        ]);
    }
}
```

### Running Seeders

```bash
# Run all seeders
php demo/seed.php

# Run specific seeder
php demo/seed.php UserSeeder

# Via Composer
composer seed
```

### Calling Other Seeders

```php
class DatabaseSeeder extends Seeder {
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(PostSeeder::class);
    }
}
```

## Unit Testing

The framework includes PHPUnit for testing.

### Running Tests

```bash
# Run all tests
composer test

# Or directly
vendor/bin/phpunit

# Run specific test file
vendor/bin/phpunit tests/Unit/ValidatorTest.php

# Run with coverage
vendor/bin/phpunit --coverage-html coverage
```

### Writing Tests

```php
// tests/Unit/MyTest.php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class MyTest extends TestCase {
    public function testSomething()
    {
        $this->assertTrue(true);
    }
}
```

### Test Structure

```
tests/
├── Unit/           # Unit tests
│   ├── ValidatorTest.php
│   ├── StrTest.php
│   └── ArrTest.php
└── Feature/        # Integration tests
    └── AuthenticationTest.php
```

## Scripts

Available Composer scripts:

```bash
composer test    # Run PHPUnit tests
composer seed    # Run database seeders
```

## License

Open source - based on the market-online project architecture

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

#   m a r k e t - f r a m e w o r k  
 