<?php
namespace Framework\Middleware;

use Framework\Core\Request;
use Framework\Core\Response;

class AuthMiddleware implements Middleware {
    
    public function handle(Request $request, callable $next)
    {
        // Start session if not started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is authenticated
        if (!isset($_SESSION['user_id'])) {
            // User is not authenticated
            if ($request->expectsJson()) {
                $response = Response::unauthorized('Authentication required');
                $response->send();
                exit;
            } else {
                // Redirect to login page
                $response = Response::redirect('/login');
                $response->send();
                exit;
            }
        }
        
        // User is authenticated, proceed to next middleware/controller
        return $next($request);
    }
}
