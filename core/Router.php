<?php
/**
 * ---------------------------------------------------------------------
 * Project:       Sistema personalizado em PHP
 * Author:        Thiago Leite - Devt Digital
 * License:       Proprietary - Todos os direitos reservados
 * File:          Router.php
 * Description:   Classe responsável pelo roteamento de requisições
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */

declare(strict_types=1);
namespace Core;

class Router
{
    // Armazena as rotas registradas, separadas por método HTTP
    protected static array $routes = [];

    // Prefixo base para a aplicação (ex: '/projeto')
    protected static string $basePath = '/basephp';

    /**
     * Registra uma rota GET.
     *
     * @param string $uri O padrão da URI (ex: '/users/{id}/profile')
     * @param callable|string $action A ação a ser executada (callback ou 'Controller@method')
     */
    public static function get(string $uri, $action): void
    {
        self::addRoute('GET', $uri, $action);
    }

    /**
     * Registra uma rota POST.
     *
     * @param string $uri O padrão da URI
     * @param callable|string $action A ação a ser executada
     */
    public static function post(string $uri, $action): void
    {
        self::addRoute('POST', $uri, $action);
    }

    /**
     * Registra uma rota PUT.
     *
     * @param string $uri O padrão da URI
     * @param callable|string $action A ação a ser executada
     */
    public static function put(string $uri, $action): void
    {
        self::addRoute('PUT', $uri, $action);
    }

    /**
     * Registra uma rota DELETE.
     *
     * @param string $uri O padrão da URI
     * @param callable|string $action A ação a ser executada
     */
    public static function delete(string $uri, $action): void
    {
        self::addRoute('DELETE', $uri, $action);
    }

    /**
     * Adiciona uma rota à lista de rotas.
     *
     * @param string $method O método HTTP (GET, POST, etc.)
     * @param string $uri O padrão da URI
     * @param callable|string $action A ação a ser executada
     */
    protected static function addRoute(string $method, string $uri, $action): void
    {
        // Garante que a URI comece com '/'
        $uri = '/' . trim($uri, '/');
        self::$routes[$method][$uri] = $action;
    }

    /**
     * Despacha a requisição atual para a rota correspondente.
     */
    public static function dispatch(): void
    {
        // echo dirname($_SERVER['PHP_SELF']); die;
        // Obtém a URI da requisição e o método HTTP
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // echo "DEBUG: Request URI: " . $_SERVER['REQUEST_URI'] . "<br>"; // remover debug
        // echo "DEBUG: Request URI parse_url: " . $requestUri . "<br>"; // remover debug
        // echo "DEBUG: Request Method: " . $requestMethod . "<br>"; // remover debug
        // echo "DEBUG: Base Path: " . self::$basePath . "<br>"; // remover debug

        // Remove o prefixo base da URI, se existir
        if (str_starts_with($requestUri, self::$basePath)) {
            $requestUri = substr($requestUri, strlen(self::$basePath));
        }
        $requestUri = '/' . trim($requestUri, '/');
        // echo "DEBUG: Request URI após remover base path: " . $requestUri . "<br>"; // remover debug

        // Verifica se há rotas registradas para o método da requisição
        if (!isset(self::$routes[$requestMethod])) {
            // Se não houver rotas para o método, retorna 404
            // echo "DEBUG: Nenhuma rota registrada para o método " . $requestMethod . "<br>"; // remover debug
            self::notFound();
            return;
        }

        // Verifica se há rotas registradas para a URI solicitada
        // echo "DEBUG: Verificando rotas para o método " . $requestMethod . "<br>";

        // Itera sobre as rotas registradas para o método atual
        foreach (self::$routes[$requestMethod] as $routeUri => $action) {
            // Converte o padrão da rota em uma expressão regular para capturar parâmetros
            // Ex: '/users/{id}' se torna '#^/users/(\d+)$#'
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_]+)', $routeUri);
            $pattern = '#^' . $pattern . '$#';

            // Tenta casar a URI da requisição com o padrão da rota
            if (preg_match($pattern, $requestUri, $matches)) {
                // Remove o primeiro elemento (a URI completa) dos matches
                array_shift($matches);
                $params = $matches; // Os parâmetros capturados

                // Se a ação for uma string 'Controller@method'
                if (is_string($action)) {
                    [$controllerName, $methodName] = explode('@', $action);

                    // Determina o namespace do controlador (Admin ou Site)
                    $controllerClass = '';
                    if (str_starts_with($controllerName, 'Admin\\')) {
                        $controllerClass = "\\App\\Controllers\\Admin\\" . str_replace('Admin\\', '', $controllerName);
                    } else {
                        $controllerClass = "\\App\\Controllers\\Site\\" . $controllerName;
                    }

                    if (class_exists($controllerClass)) {
                        $controllerInstance = new $controllerClass();
                        if (method_exists($controllerInstance, $methodName)) {
                            // Chama o método do controlador com os parâmetros
                            call_user_func_array([$controllerInstance, $methodName], $params);
                            return; // Rota encontrada e despachada
                        }
                    }
                } elseif (is_callable($action)) {
                    // Se a ação for um callback (função anônima)
                    call_user_func_array($action, $params);
                    return; // Rota encontrada e despachada
                }
            }
        }

        // Se nenhuma rota foi encontrada
        self::notFound();
    }

    /**
     * Define o prefixo base da aplicação.
     *
     * @param string $path O caminho base (ex: '/projeto')
     */
    public static function setBasePath(string $path): void
    {
        self::$basePath = $path;
    }

    /**
     * Exibe a página de erro 404.
     */
    protected static function notFound(): void
    {
        http_response_code(404);
        echo "Página não encontrada.";
    }
}
