<?php
// ============================================
// ШАБЛОН: Список всех товаров
// ============================================
// Переменные, доступные здесь:
//   $products — массив всех товаров из БД
?>

<!-- Уведомления об успехных действиях -->
<?php
if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        <?php
        // Определяем текст уведомления по параметру success
        switch ($_GET['success']) {
            case 'created':
                echo '✅ Товар успешно создан!';
                break;
            case 'updated':
                echo '✅ Товар успешно обновлён!';
                break;
            case 'deleted':
                echo '✅ Товар успешно удалён!';
                break;
        }
        ?>
    </div>
<?php
endif; ?>

<h1>📦 Все товары (<?= count($products) ?>)</h1>
<br>

<?php
if (empty($products)): ?>
    <!-- Если товаров нет -->
    <div class="card">
        <p>Товаров пока нет. <a href="index.php?action=create">Добавьте первый!</a></p>
    </div>
<?php
else: ?>
    <!-- Таблица товаров -->
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Кол-во</th>
            <th>Дата создания</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($products as $item): ?>
            <tr>
                <td><?= $item['id'] ?></td>

                <!-- htmlspecialchars() — защита от XSS-атак -->
                <!-- Превращает спецсимволы в безопасные HTML-сущности -->
                <!-- Например: <script> → &lt;script&gt; -->
                <td>
                    <a href="index.php?action=show&id=<?= $item['id'] ?>">
                        <?= htmlspecialchars($item['name']) ?>
                    </a>
                </td>

                <!-- number_format() — форматирует число -->
                <!-- (число, знаков после запятой, разделитель дробной части, разделитель тысяч) -->
                <td><?= number_format($item['price'], 2, '.', ' ') ?> ₽</td>

                <td><?= $item['quantity'] ?> шт.</td>

                <td><?= date('d.m.Y H:i', strtotime($item['created_at'])) ?></td>

                <td>
                    <!-- Ссылка на редактирование -->
                    <a href="index.php?action=edit&id=<?= $item['id'] ?>"
                       class="btn btn-warning">✏️</a>

                    <!-- Форма удаления (POST-запрос) -->
                    <!-- Удаление через форму, а не ссылку — это безопаснее -->
                    <form method="POST" action="index.php?action=delete"
                          style="display:inline;"
                          onsubmit="return confirm('Удалить товар?')">

                        <!-- Скрытое поле с ID товара -->
                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                        <button type="submit" class="btn btn-danger">🗑️</button>
                    </form>
                </td>
            </tr>
        <?php
        endforeach; ?>
        </tbody>
    </table>
<?php
endif; ?>
