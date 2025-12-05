<?php
namespace Framework\Middleware;

use Framework\Core\Request;

class CsrfMiddleware implements Middleware {
    
    public function handle(Request $request, callable $next)
    {
        // Start session if not started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Only check CSRF for state-changing methods
        if (in_array($request->method(), ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            $token = $request->input('_csrf_token');
            
            if (!$token || !isset($_SESSION['_csrf_token']) || $token !== $_SESSION['_csrf_token']) {
                http_response_code(403);
                die('CSRF token mismatch');
            }
        }
        
        // Generate new token if not exists
        if (!isset($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        
        return $next($request);
    }
    
    /**
     * Get the current CSRF token
     */
    public static function getToken(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        
        return $_SESSION['_csrf_token'];
    }
}
