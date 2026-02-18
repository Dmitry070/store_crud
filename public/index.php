<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../src/Product.php';
require_once __DIR__ . '/../src/Validator.php';
require_once __DIR__ . '/../src/ProductController.php';
require_once __DIR__ . '/../src/Router.php';

$product = new Product($pdo);
$validator = new Validator();
$controller = new ProductController($product, $validator);

$router = new Router($controller);
$router->run();
