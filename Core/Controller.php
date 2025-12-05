<?php
namespace Framework\Core;

abstract class Controller {
    protected $db;
    protected $viewsPath;
    
    public function __construct(Database $db, string $viewsPath = '')
    {
        $this->db = $db;
        $this->viewsPath = $viewsPath;
    }

    protected function view(string $path, array $params = [])
    {
        ob_start();
        extract($params);
        $path = str_replace(".", DIRECTORY_SEPARATOR, $path);
        require $this->viewsPath . $path . '.php';
        $content = ob_get_clean();
        
        if(file_exists($this->viewsPath . 'layout.php')){
            require $this->viewsPath . 'layout.php';
        } else {
            echo $content;
        }
    }

    protected function getDB()
    {
        return $this->db;
    }

    protected function redirect(string $url)
    {
        header("Location: $url");
        exit;
    }

    protected function json($data, int $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
