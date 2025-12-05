<?php
namespace Framework\Core;

class Request {
    private $get;
    private $post;
    private $files;
    private $server;
    private $headers;
    
    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->files = $_FILES;
        $this->server = $_SERVER;
        $this->headers = $this->getHeaders();
    }
    
    /**
     * Get all input data (GET and POST merged)
     */
    public function all(): array
    {
        return array_merge($this->get, $this->post);
    }
    
    /**
     * Get a specific input value
     */
    public function input(string $key, $default = null)
    {
        $all = $this->all();
        return $all[$key] ?? $default;
    }
    
    /**
     * Get only specified keys from input
     */
    public function only(array $keys): array
    {
        $all = $this->all();
        return array_intersect_key($all, array_flip($keys));
    }
    
    /**
     * Get all except specified keys from input
     */
    public function except(array $keys): array
    {
        $all = $this->all();
        return array_diff_key($all, array_flip($keys));
    }
    
    /**
     * Check if input has a key
     */
    public function has(string $key): bool
    {
        $all = $this->all();
        return isset($all[$key]);
    }
    
    /**
     * Get GET parameter
     */
    public function get(string $key, $default = null)
    {
        return $this->get[$key] ?? $default;
    }
    
    /**
     * Get POST parameter
     */
    public function post(string $key, $default = null)
    {
        return $this->post[$key] ?? $default;
    }
    
    /**
     * Get uploaded file
     */
    public function file(string $key)
    {
        return $this->files[$key] ?? null;
    }
    
    /**
     * Get request method
     */
    public function method(): string
    {
        return $this->server['REQUEST_METHOD'] ?? 'GET';
    }
    
    /**
     * Check if request method is...
     */
    public function isMethod(string $method): bool
    {
        return strtoupper($this->method()) === strtoupper($method);
    }
    
    /**
     * Check if request is GET
     */
    public function isGet(): bool
    {
        return $this->isMethod('GET');
    }
    
    /**
     * Check if request is POST
     */
    public function isPost(): bool
    {
        return $this->isMethod('POST');
    }
    
    /**
     * Check if request is AJAX
     */
    public function isAjax(): bool
    {
        return isset($this->server['HTTP_X_REQUESTED_WITH']) 
            && strtolower($this->server['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
    
    /**
     * Get request URI
     */
    public function uri(): string
    {
        return $this->server['REQUEST_URI'] ?? '/';
    }
    
    /**
     * Get request path
     */
    public function path(): string
    {
        $path = $this->uri();
        return parse_url($path, PHP_URL_PATH) ?? '/';
    }
    
    /**
     * Get all headers
     */
    private function getHeaders(): array
    {
        $headers = [];
        foreach ($this->server as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $header = str_replace('_', '-', substr($key, 5));
                $headers[$header] = $value;
            }
        }
        return $headers;
    }
    
    /**
     * Get a specific header
     */
    public function header(string $key, $default = null)
    {
        $key = strtoupper(str_replace('-', '_', $key));
        return $this->headers[$key] ?? $default;
    }
    
    /**
     * Get JSON input data
     */
    public function json(): ?array
    {
        $contentType = $this->header('CONTENT-TYPE');
        if ($contentType && strpos($contentType, 'application/json') !== false) {
            $input = file_get_contents('php://input');
            return json_decode($input, true);
        }
        return null;
    }
    
    /**
     * Check if request expects JSON
     */
    public function expectsJson(): bool
    {
        $accept = $this->header('ACCEPT', '');
        return strpos($accept, 'application/json') !== false;
    }
}
