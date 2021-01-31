<?php

namespace Src\Core;
use Src\Controller;

class Router 
{
    private $routers = [];

    public function get(string $uri, string $controller)
    {
        $this->routers[$uri] = $controller;
    }

    public function dispatch() 
    {
        $path = $_SERVER['REQUEST_URI'];
        
        if ($path != '/') {
            $path = rtrim($path, '/');
        }
        if (array_key_exists($path, $this->routers)) {
            list($controller, $action) = explode('@', $this->routers[$path]);
            $controller = 'Src\\Controller\\' . $controller . 'Controller'; 
            $controller = new $controller();
            $controller->$action();
        } else {
            echo "PAGE NOT FOUND 404!";
        }
    }
}