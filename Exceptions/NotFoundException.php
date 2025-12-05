<?php
namespace Framework\Exceptions;

use Exception;
use Throwable;

class NotFoundException extends Exception {
    private $viewsPath;
    
    public function __construct($message="", $code=0, ?Throwable $previous=null, string $viewsPath = '')
    {
        parent::__construct($message, $code, $previous);
        $this->viewsPath = $viewsPath;
    }

    public function error404()
    {
        http_response_code(404);
        
        $errorViewPath = $this->viewsPath . 'errors' . DIRECTORY_SEPARATOR . '404.php';
        
        if(file_exists($errorViewPath)){
            require $errorViewPath;
        } else {
            echo "<h1>404 - Page Not Found</h1>";
            echo "<p>{$this->getMessage()}</p>";
        }
    }
}
