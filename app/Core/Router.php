<?php

namespace App\Core;

class Router
{
    protected $routes = [];

    public function add($method, $route, $controller)
    {
        $this->routes[] = [
            'method' => $method,
            'route' => $route,
            'controller' => $controller
        ];
    }

    public function dispatch($url)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = trim($url, '/');

        // Handle root URL specifically
        if ($url === '') {
            if (!isset($_SESSION['user_id'])) {
                header("Location: " . BASE_URL . "/login");
                exit;
            } else {
                header("Location: " . BASE_URL . "/dashboard");
                exit;
            }
        }

        foreach ($this->routes as $route) {
            $routePattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_]+)', trim($route['route'], '/'));
            $routePattern = "#^$routePattern$#";

            if ($route['method'] === $method && preg_match($routePattern, $url, $matches)) {
                array_shift($matches);
                list($controllerName, $action) = explode('@', $route['controller']);
                $controllerClass = "App\\Controllers\\$controllerName";
                
                if (class_exists($controllerClass)) {
                    $controller = new $controllerClass();
                    if (method_exists($controller, $action)) {
                        return call_user_func_array([$controller, $action], $matches);
                    }
                }
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}
