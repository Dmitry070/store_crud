<?php

class Router
{
    private ProductController $controller;

    public function __construct(ProductController $controller)
    {
        $this->controller = $controller;
    }

    public function run(): void
    {
        $action = $_GET['action'] ?? 'list';

        $routes = [
            'list' => 'index',
            'show' => 'show',
            'create' => 'create',
            'edit' => 'edit',
            'delete' => 'delete',
        ];

        if (array_key_exists($action, $routes)) {
            $method = $routes[$action];
            $this->controller->$method();
        } else {
            http_response_code(404);
            echo "Страница не найдена";
        }
    }
}
