<?php
class Router {
    private $routes = [];

    // Adiciona uma nova rota
    public function add($route, $action) {
        $this->routes[$route] = $action;
    }

    // Processa a rota atual
    public function dispatch($url) {
        // Separa a parte da URL e os parâmetros de query
        $parsedUrl = parse_url($url);
        $route = $parsedUrl['path'];  // Aqui fica o caminho da rota (ex: home/index)
        $params = isset($parsedUrl['query']) ? $parsedUrl['query'] : '';  // Aqui ficam os parâmetros de query string (ex: id=1)

        // Verifica se a rota existe
        if (array_key_exists($route, $this->routes)) {
            list($controllerName, $methodName) = explode('@', $this->routes[$route]);

            $controllerFile = "app/Controllers/$controllerName.php";
            if (file_exists($controllerFile)) {
                require_once $controllerFile;

                $controller = new $controllerName();

                // Se houver parâmetros, passa para o método
                if (!empty($params)) {
                    parse_str($params, $parsedParams);  // Converte os parâmetros de string para array
                    call_user_func_array([$controller, $methodName], $parsedParams);
                } else {
                    call_user_func([$controller, $methodName]);
                }
            } else {
                echo "Controlador $controllerName não encontrado!";
            }
        } else {
            echo "Rota não encontrada!";
        }
    }
}
