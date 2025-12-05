<?php
// Start session for authentication and flash messages
session_start();

// Load framework autoloader
require_once __DIR__ . '/../../autoload.php';

use Framework\Core\Database;
use Framework\Routing\Router;
use Framework\Exceptions\NotFoundException;
use Framework\Config\Config;
use Framework\Middleware\AuthMiddleware;

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

// Public routes
$router->get("/", "App\\Controllers\\HomeController@index");
$router->get("/about", "App\\Controllers\\HomeController@about");

// Auth routes
$router->get("/login", "App\\Controllers\\AuthController@showLogin");
$router->post("/login", "App\\Controllers\\AuthController@login");
$router->get("/register", "App\\Controllers\\AuthController@showRegister");
$router->post("/register", "App\\Controllers\\AuthController@register");
$router->get("/logout", "App\\Controllers\\AuthController@logout");

// Protected routes (require authentication)
$router->group(['middleware' => AuthMiddleware::class], function($router) {
    $router->get("/users", "App\\Controllers\\UserController@index");
    $router->get("/users/create", "App\\Controllers\\UserController@create");
    $router->post("/users", "App\\Controllers\\UserController@store");
    $router->get("/users/:id", "App\\Controllers\\UserController@show");
});

// Run the router
try {
    $router->run();
} catch(NotFoundException $e) {
    echo $e->error404();
}
