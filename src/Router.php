<?php

declare(strict_types=1);

class Router
{
    private ProductController $productController;
    private AuthController $authController;

    public function __construct(
        ProductController $productController,
        AuthController $authController
    ) {
        $this->productController = $productController;
        $this->authController = $authController;
    }

    public function run(): void
    {
        $action = $_GET['action'] ?? 'list';

        // Маршруты для товаров
        $productRoutes = [
            'list' => 'index',
            'show' => 'show',
            'create' => 'create',
            'edit' => 'edit',
            'delete' => 'delete',
        ];

        // Маршруты для авторизации
        $authRoutes = [
            'login' => 'login',
            'logout' => 'logout',
            'register' => 'register',
        ];

        if (array_key_exists($action, $productRoutes)) {
            $method = $productRoutes[$action];
            $this->productController->$method();
        } elseif (array_key_exists($action, $authRoutes)) {
            $method = $authRoutes[$action];
            $this->authController->$method();
        } else {
            http_response_code(404);
            echo "Страница не найдена";
        }
    }
}
