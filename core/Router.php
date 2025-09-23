<?php
class Router {
    private $routes = [];

    public function add($route, $controller_action) {
        $this->routes[$route] = $controller_action;
    }

    public function dispatch($url) {
        $url = trim($url, '/');
        
        if (array_key_exists($url, $this->routes)) {
            $controller_action = $this->routes[$url];
            $this->callAction($controller_action);
        } else {
            // 404 error
            echo "Page not found!";
        }
    }

    private function callAction($controller_action) {
        list($controller, $action) = explode('@', $controller_action);
        
        $controller_file = 'controllers/' . $controller . '.php';
        if (file_exists($controller_file)) {
            require_once $controller_file;
            $controller_obj = new $controller();
            $controller_obj->$action();
        } else {
            echo "Controller not found!";
        }
    }
}
?>