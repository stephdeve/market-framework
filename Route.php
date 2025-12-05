<?php

namespace Router;
use Database\DBConnexion;
class Route{
    public $path;
    public $action;
    public $matches;
    public function __construct($path, $action)
    {
        $this->path = trim($path, '/');
        $this->action = $action;
    }

    public function matches(string $url)
    {
        
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $pathToMatch = "#^$path$#";
        // echo $pathToMatch, $path;
        if (preg_match($pathToMatch, $url, $matches)){
            $this->matches = $matches;
            return true;
        }else{
            return false;
        }
    }

    public function execute()
    {
        $params = explode('@', $this->action);
        // echo $params[0];
        $controller = new $params[0](new DBConnexion(DB_NAME, DB_HOST, DB_USER, DB_PWD));
        $method = $params[1];
        // var_dump(isset($this->matches[2])); die();
        if(isset($this->matches[2])){
            return $controller->$method($this->matches[1], $this->matches[2]);
        }elseif((isset($this->matches[1]))){
            return $controller->$method($this->matches[1]);
        }else{
            return $controller->$method();
        }
        
    }
}