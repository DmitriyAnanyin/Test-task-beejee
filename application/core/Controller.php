<?php

namespace application\core;

use application\core\View;

abstract class Controller {

    public $route;
    public $view;

    public function __construct ($route) {
        $this->route = $route;
        $this->view = new View($route);
        $this->model = $this->loadModel($route['model']);
    }

    public function loadModel($name) {
        $path = 'application\models\\'.ucfirst($name).'Model';
        if (class_exists($path)) {
            return new $path;
        }
    }
}


?>