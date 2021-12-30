<?php

namespace application\core;

class Router {
    
    protected $routes = [];
    protected $params = [];

    public function __construct () {
        $routesArr = require 'application/config/routes.php';
        foreach ($routesArr as $key => $val) {
            $this->add($key, $val);
        }
    }
    
    public function add($route, $params) {
        $route = '#^'.$route.'$#';
        $this->routes[$route] = $params;
    }
    
    public function match() {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                $this->params = $params;
                return true;
            }
        }
        return false;
    }
    
    public function run() {
        if ($this->match()) {
            $pathToController = 'application\controllers\\'.ucfirst($this->params['controller']).'Controller';
            if (class_exists($pathToController)) {
                $action = $this->params['action'].'Action';
                if (method_exists($pathToController, $action)) {
                    $controller = new $pathToController($this->params);
                    $controller->$action();
                } else {       
                View::errorCode(404);
                }
            } else {
                View::errorCode(404);
            }
        } else {
            View::errorCode(404);
        }
    }
}


?>