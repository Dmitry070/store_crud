<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Магазин') ?></title>

    <!-- Подключаем CSS прямо здесь для простоты -->
    <style>
        /* ── Базовые стили ── */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 960px;
            margin: 0 auto;
            padding: 20px;
        }

        /* ── Навигация ── */
        nav {
            background-color: #2c3e50;
            padding: 15px 0;
            margin-bottom: 30px;
        }

        nav .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        nav a:hover {
            color: #3498db;
        }

        /* ── Кнопки ── */
        .btn {
            display: inline-block;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            color: white;
        }

        .btn-primary {
            background-color: #3498db;
        }

        .btn-success {
            background-color: #27ae60;
        }

        .btn-warning {
            background-color: #f39c12;
        }

        .btn-danger {
            background-color: #e74c3c;
        }

        .btn:hover {
            opacity: 0.85;
        }

        /* ── Таблица ── */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        /* ── Формы ── */
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-group textarea {
            height: 120px;
            resize: vertical;
        }

        /* ── Уведомления ── */
        .alert {
            padding: 12px 20px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* ── Карточка товара ── */
        .card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card h2 {
            margin-bottom: 15px;
        }

        .actions {
            margin-top: 15px;
        }

        .actions a,
        .actions button {
            margin-right: 8px;
        }
    </style>
</head>
<body>

<!-- Навигация -->
<nav>
    <div class="container">
        <a href="index.php">🛒 Магазин (CRUD)</a>
        <a href="index.php?action=create" class="btn btn-success">+ Добавить товар</a>
    </div>
</nav>

<div class="container">
