<?php

use Framework\Core\Request;
use Framework\Core\Response;
use Framework\Config\Config;

if (!function_exists('dd')) {
    /**
     * Dump and die
     */
    function dd(...$vars) {
        foreach ($vars as $var) {
            echo '<pre>';
            var_dump($var);
            echo '</pre>';
        }
        die();
    }
}

if (!function_exists('dump')) {
    /**
     * Dump variable(s)
     */
    function dump(...$vars) {
        foreach ($vars as $var) {
            echo '<pre>';
            var_dump($var);
            echo '</pre>';
        }
    }
}

if (!function_exists('env')) {
    /**
     * Get environment variable
     */
    function env(string $key, $default = null) {
        $value = getenv($key);
        
        if ($value === false) {
            return $default;
        }
        
        // Convert string booleans
        if (strtolower($value) === 'true') {
            return true;
        }
        
        if (strtolower($value) === 'false') {
            return false;
        }
        
        return $value;
    }
}

if (!function_exists('config')) {
    /**
     * Get config value
     */
    function config(string $key, $default = null) {
        return Config::get($key, $default);
    }
}

if (!function_exists('redirect')) {
    /**
     * Create a redirect response
     */
    function redirect(string $url, int $statusCode = 302): Response {
        return Response::redirect($url, $statusCode);
    }
}

if (!function_exists('back')) {
    /**
     * Redirect back to previous page
     */
    function back(): Response {
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        return Response::redirect($referer);
    }
}

if (!function_exists('request')) {
    /**
     * Get the request instance
     */
    function request(): Request {
        return new Request();
    }
}

if (!function_exists('response')) {
    /**
     * Create a response
     */
    function response($content = '', int $statusCode = 200): Response {
        return new Response($content, $statusCode);
    }
}

if (!function_exists('json')) {
    /**
     * Create a JSON response
     */
    function json($data, int $statusCode = 200): Response {
        return Response::json($data, $statusCode);
    }
}

if (!function_exists('old')) {
    /**
     * Get old input value from session
     */
    function old(string $key, $default = null) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $value = $_SESSION['_old_input'][$key] ?? $default;
        
        return $value;
    }
}

if (!function_exists('csrf_token')) {
    /**
     * Get CSRF token
     */
    function csrf_token(): string {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        
        return $_SESSION['_csrf_token'];
    }
}

if (!function_exists('csrf_field')) {
    /**
     * Generate CSRF hidden input field
     */
    function csrf_field(): string {
        $token = csrf_token();
        return '<input type="hidden" name="_csrf_token" value="' . $token . '">';
    }
}

if (!function_exists('method_field')) {
    /**
     * Generate method override hidden input field
     */
    function method_field(string $method): string {
        return '<input type="hidden" name="_method" value="' . strtoupper($method) . '">';
    }
}

if (!function_exists('asset')) {
    /**
     * Generate an asset path
     */
    function asset(string $path): string {
        return '/' . ltrim($path, '/');
    }
}

if (!function_exists('url')) {
    /**
     * Generate a URL
     */
    function url(string $path = ''): string {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        return $protocol . '://' . $host . '/' . ltrim($path, '/');
    }
}

if (!function_exists('abort')) {
    /**
     * Abort with HTTP status code
     */
    function abort(int $code = 404, string $message = '') {
        http_response_code($code);
        
        if ($message) {
            echo $message;
        }
        
        exit;
    }
}

if (!function_exists('session')) {
    /**
     * Get/set session value
     */
    function session($key = null, $default = null) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (is_null($key)) {
            return $_SESSION;
        }
        
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $_SESSION[$k] = $v;
            }
            return null;
        }
        
        return $_SESSION[$key] ?? $default;
    }
}
