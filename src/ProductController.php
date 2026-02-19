<?php

declare(strict_types=1);

class ProductController
{
    private Product $product;
    private Validator $validator;

    public function __construct(Product $product, Validator $validator)
    {
        $this->product = $product;
        $this->validator = $validator;
    }

    public function index(): void
    {
        $search = trim($_GET['search'] ?? '');
        $page = max(1, (int)($_GET['page'] ?? 1));  // Минимум 1
        $perPage = 5;  // Товаров на странице

        if ($search !== '') {
            // Поиск с пагинацией
            $products = $this->product->searchPage($search, $page, $perPage);
            $totalItems = $this->product->getSearchCount($search);
        } else {
            // Все товары с пагинацией
            $products = $this->product->getPage($page, $perPage);
            $totalItems = $this->product->getTotalCount();
        }

        // Считаем общее количество страниц
        // ceil() — округление вверх: 12 товаров / 5 на стр = 2.4 → 3 страницы
        $totalPages = (int)ceil($totalItems / $perPage);

        $pageTitle = 'Список товаров';
        $this->render('list', [
            'products' => $products,
            'search' => $search,
            'page' => $page,
            'totalPages' => $totalPages,
            'totalItems' => $totalItems,
        ]);
    }

    public function show(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $item = $this->product->getById($id);

        if (!$item) {
            http_response_code(404);
            echo "Товар не найден";
            return;
        }

        $pageTitle = $item['name'];
        $this->render('show', [
            'item' => $item,
        ]);
    }

    public function create(): void
    {
        Auth::requireLogin();

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->getFormData();
            $errors = $this->validator->validateProduct($data);

            if (empty($errors)) {
                $this->product->create($data);
                $this->redirect('index.php?action=list&success=created');
                return;
            }
        }

        $pageTitle = 'Добавить товар';
        $this->render('create', [
            'errors' => $errors,
        ]);
    }

    public function edit(): void
    {
        Auth::requireLogin();

        $id = (int)($_GET['id'] ?? 0);
        $item = $this->product->getById($id);
        $errors = [];

        if (!$item) {
            http_response_code(404);
            echo "Товар не найден";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->getFormData();
            $errors = $this->validator->validateProduct($data);

            if (empty($errors)) {
                $this->product->update($id, $data);
                $this->redirect("index.php?action=show&id=$id&success=updated");
                return;
            }

            $item = $data;
            $item['id'] = $id;
        }

        $pageTitle = 'Редактировать: ' . $item['name'];
        $this->render('edit', [
            'item' => $item,
            'errors' => $errors,
        ]);
    }

    public function delete(): void
    {
        Auth::requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            $this->product->delete($id);
        }

        $this->redirect("index.php?action=list&success=deleted");
    }

    private function getFormData(): array
    {
        return [
            'name' => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'price' => (float)($_POST['price'] ?? 0),
            'quantity' => (int)($_POST['quantity'] ?? 0),
        ];
    }

    private function render(string $template, array $data = []): void
    {
        extract($data);

        require __DIR__ . '/../templates/header.php';
        require __DIR__ . "/../templates/$template.php";
        require __DIR__ . '/../templates/footer.php';
    }

    private function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }
}
