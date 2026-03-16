<?php
require_once __DIR__ . '/Controller.php';

class Router {
    private array $routes = [];

    public function get(string $path, array $handler): void {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, array $handler): void {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $path, string $method): void {
        $method = strtoupper($method);
        if (!isset($this->routes[$method][$path])) {
            http_response_code(404);
            echo '404 Not Found';
            return;
        }

        [$controllerName, $action] = $this->routes[$method][$path];
        require_once __DIR__ . '/../controllers/' . $controllerName . '.php';
        $controller = new $controllerName();
        $controller->$action();
    }
}
