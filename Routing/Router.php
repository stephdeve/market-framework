<?php
namespace Framework\Routing;

use Framework\Exceptions\NotFoundException;
use Framework\Core\Database;
use Framework\Core\Request;
use Framework\Middleware\Middleware;

class Router {
    public $url;
    public $routes = [];
    private $db;
    private $viewsPath;
    private $currentRouteGroup = [];
    private $namedRoutes = [];

    public function __construct($url, Database $db, string $viewsPath = '')
    {
        $this->url = trim($url, '/');
        $this->db = $db;
        $this->viewsPath = $viewsPath;
    }

    public function get(string $path, string $action)
    {
        $route = new Route($this->applyGroupPrefix($path), $action);
        $this->applyGroupMiddleware($route);
        $this->routes["GET"][] = $route;
        return $route;
    }

    public function post(string $path, string $action)
    {
        $route = new Route($this->applyGroupPrefix($path), $action);
        $this->applyGroupMiddleware($route);
        $this->routes["POST"][] = $route;
        return $route;
    }

    public function put(string $path, string $action)
    {
        $route = new Route($this->applyGroupPrefix($path), $action);
        $this->applyGroupMiddleware($route);
        $this->routes["PUT"][] = $route;
        return $route;
    }

    public function delete(string $path, string $action)
    {
        $route = new Route($this->applyGroupPrefix($path), $action);
        $this->applyGroupMiddleware($route);
        $this->routes["DELETE"][] = $route;
        return $route;
    }

    public function patch(string $path, string $action)
    {
        $route = new Route($this->applyGroupPrefix($path), $action);
        $this->applyGroupMiddleware($route);
        $this->routes["PATCH"][] = $route;
        return $route;
    }

    /**
     * Create a route group
     */
    public function group(array $attributes, callable $callback)
    {
        $this->currentRouteGroup[] = $attributes;
        call_user_func($callback, $this);
        array_pop($this->currentRouteGroup);
    }

    /**
     * Apply group prefix to path
     */
    private function applyGroupPrefix(string $path): string
    {
        $prefix = '';
        foreach ($this->currentRouteGroup as $group) {
            if (isset($group['prefix'])) {
                $prefix .= '/' . trim($group['prefix'], '/');
            }
        }
        return ltrim($prefix . '/' . trim($path, '/'), '/');
    }

    /**
     * Apply group middleware to route
     */
    private function applyGroupMiddleware(Route $route): void
    {
        foreach ($this->currentRouteGroup as $group) {
            if (isset($group['middleware'])) {
                $middlewares = is_array($group['middleware']) ? $group['middleware'] : [$group['middleware']];
                foreach ($middlewares as $middleware) {
                    $route->middleware($middleware);
                }
            }
        }
    }

    /**
     * Get route by name
     */
    public function getRouteByName(string $name): ?Route
    {
        return $this->namedRoutes[$name] ?? null;
    }

    /**
     * Register a named route
     */
    public function registerNamedRoute(string $name, Route $route): void
    {
        $this->namedRoutes[$name] = $route;
    }

    public function run(){
        $method = $_SERVER["REQUEST_METHOD"];
        
        // Support method override for PUT, DELETE, PATCH via POST
        if ($method === "POST" && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }
        
        if (!isset($this->routes[$method])) {
            throw new NotFoundException("La page demandée est introuvable");
        }
        
        foreach ($this->routes[$method] as $route){
            if ($route->matches($this->url)){
                return $route->execute($this->db, $this->viewsPath);
            }
        }
        
        throw new NotFoundException("La page demandée est introuvable");
    }
}
