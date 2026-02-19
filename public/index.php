<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Auth.php';
Auth::start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Product.php';
require_once __DIR__ . '/../src/Category.php';
require_once __DIR__ . '/../src/User.php';
require_once __DIR__ . '/../src/Validator.php';
require_once __DIR__ . '/../src/ProductController.php';
require_once __DIR__ . '/../src/AuthController.php';
require_once __DIR__ . '/../src/Router.php';

$product   = new Product($pdo);
$category  = new Category($pdo);
$user      = new User($pdo);
$validator = new Validator();

$productController = new ProductController($product, $category, $validator);
$authController    = new AuthController($user, $validator);

$router = new Router($productController, $authController);
$router->run();