<?php
// Custom autoloader for loading framework and app classes

spl_autoload_register(function ($class) {
    // Framework namespace
    if (strpos($class, 'Framework\\') === 0) {
        $relativePath = str_replace('Framework\\', '', $class);
        $relativePath = str_replace('\\', DIRECTORY_SEPARATOR, $relativePath);
        $file = __DIR__ . DIRECTORY_SEPARATOR . $relativePath . '.php';
        
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    }
    
    // App namespace (for demo application)
    if (strpos($class, 'App\\') === 0) {
        $relativePath = str_replace('App\\', '', $class);
        $relativePath = str_replace('\\', DIRECTORY_SEPARATOR, $relativePath);
        $file = __DIR__ . DIRECTORY_SEPARATOR . 'demo' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $relativePath . '.php';
        
        if (file_exists($file)) {
            require_once $file;
            return true;
        }
    }
    
    return false;
});

// Load helpers
require_once __DIR__ . DIRECTORY_SEPARATOR . 'helpers.php';
