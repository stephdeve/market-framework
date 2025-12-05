<?php
namespace Framework\Routing;

use Framework\Core\Database;
use Framework\Core\Request;

class Route {
    public $path;
    public $action;
    public $matches;
    protected $middlewares = [];
    protected $name;
    
    public function __construct($path, $action)
    {
        $this->path = trim($path, '/');
        $this->action = $action;
    }

    public function matches(string $url)
    {
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $pathToMatch = "#^$path$#";
        
        if (preg_match($pathToMatch, $url, $matches)){
            $this->matches = $matches;
            return true;
        }else{
            return false;
        }
    }

    /**
     * Add middleware to this route
     */
    public function middleware($middleware): self
    {
        if (is_array($middleware)) {
            $this->middlewares = array_merge($this->middlewares, $middleware);
        } else {
            $this->middlewares[] = $middleware;
        }
        return $this;
    }

    /**
     * Set route name
     */
    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get route name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Execute middleware pipeline
     */
    private function executeMiddleware(Request $request, callable $finalHandler)
    {
        $middlewares = array_reverse($this->middlewares);
        
        $pipeline = array_reduce($middlewares, function($next, $middleware) {
            return function($request) use ($next, $middleware) {
                if (is_string($middleware)) {
                    $middleware = new $middleware();
                }
                return $middleware->handle($request, $next);
            };
        }, $finalHandler);
        
        return $pipeline($request);
    }

    public function execute(Database $db, string $viewsPath = '')
    {
        $request = new Request();
        
        // If there are middlewares, execute them
        if (!empty($this->middlewares)) {
            return $this->executeMiddleware($request, function($request) use ($db, $viewsPath) {
                return $this->executeController($db, $viewsPath);
            });
        }
        
        return $this->executeController($db, $viewsPath);
    }

    /**
     * Execute the controller action
     */
    private function executeController(Database $db, string $viewsPath = '')
    {
        $params = explode('@', $this->action);
        $controller = new $params[0]($db, $viewsPath);
        $method = $params[1];
        
        // Extract all route parameters (skip first match which is full URL)
        $routeParams = array_slice($this->matches, 1);
        
        // Call controller method with all parameters
        return call_user_func_array([$controller, $method], $routeParams);
    }
}
