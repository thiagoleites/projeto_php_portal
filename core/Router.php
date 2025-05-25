<?php

namespace Core;

class Router
{
    public static function dispatch()
    {

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // remove the '/projeto' prefix from the URI
        $base = '/projeto';
        if (str_starts_with($uri, $base)) {
            $uri = substr($uri, strlen($base));
        }

        $uri = trim($uri, '/');
        $segments = explode('/', $uri);

        if (!empty($segments[0]) && $segments[0] === 'admin') {
            // Load the admin routes
            array_shift($segments);
            $controller = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : 'DashboardController';
            $method = $segments[1] ?? 'index';
            $params = array_slice($segments, 2);

            $controllerClass = "\\App\Controllers\\Admin\\$controller";
            // if (class_exists($controllerClass)) {
            //     $controllerInstance = new $controllerClass();
            //     if (method_exists($controllerInstance, $method)) {
            //         call_user_func_array([$controllerInstance, $method], $params);
            //     } else {
            //         http_response_code(404);
            //         echo "Método não encontrado.";
            //     }
            // } else {
            //     http_response_code(404);
            //     echo "Controlador não encontrado.";
            // }
        } else {
            // Load the web routes
            $controller = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : 'HomeController';
            $method = $segments[1] ?? 'index';
            $params = array_slice($segments, 2);
            $controllerClass = "\\App\Controllers\\$controller";
        }

        if (class_exists($controllerClass)) {
            $controllerInstance = new $controllerClass();
            if (method_exists($controllerInstance, $$method)) {
                call_user_func_array([$controllerInstance, $method], $params);
                return;
            }
        }

        http_response_code(404);
        echo "Página não encontrada.";
    }
}