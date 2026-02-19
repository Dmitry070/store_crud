<?php
// ============================================
// ШАБЛОН: Список всех товаров
// ============================================
?>

<!-- Уведомления -->
<?php
if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        <?php
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

<!-- ========== ФОРМА ПОИСКА (НОВОЕ) ========== -->
<div class="card">
    <form method="GET" action="index.php">
        <!-- action=list передаём скрытым полем, чтобы роутер знал что делать -->
        <input type="hidden" name="action" value="list">

        <div style="display: flex; gap: 10px;">
            <input type="text"
                   name="search"
                   value="<?= htmlspecialchars($search ?? '') ?>"
                   placeholder="🔍 Поиск по названию или описанию..."
                   style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px;">

            <button type="submit" class="btn btn-primary">🔍 Найти</button>

            <?php
            if (!empty($search)): ?>
                <a href="index.php?action=list" class="btn btn-danger">✖ Сбросить</a>
            <?php
            endif; ?>
        </div>
    </form>
</div>
<br>
<!-- ========== КОНЕЦ ФОРМЫ ПОИСКА ========== -->

<?php
if (!empty($search)): ?>
    <h1>🔍 Результаты поиска: «<?= htmlspecialchars($search) ?>» (<?= count($products) ?>)</h1>
<?php
else: ?>
    <h1>📦 Все товары (<?= count($products) ?>)</h1>
<?php
endif; ?>
<br>

<?php
if (empty($products)): ?>
    <div class="card">
        <?php
        if (!empty($search)): ?>
            <p>Ничего не найдено по запросу «<?= htmlspecialchars($search) ?>».
                <a href="index.php?action=list">Показать все товары</a></p>
        <?php
        else: ?>
            <p>Товаров пока нет. <a href="index.php?action=create">Добавьте первый!</a></p>
        <?php
        endif; ?>
    </div>
<?php
else: ?>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Категория</th>
            <th>Цена</th>
            <th>Кол-во</th>
            <th>Дата создания</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <td><?= htmlspecialchars($item['category_name'] ?? 'Без категории') ?></td>
        <?php
        foreach ($products as $item): ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td>
                    <a href="index.php?action=show&id=<?= $item['id'] ?>">
                        <?= htmlspecialchars($item['name']) ?>
                    </a>
                </td>
                <td><?= number_format($item['price'], 2, '.', ' ') ?> ₽</td>
                <td><?= $item['quantity'] ?> шт.</td>
                <td><?= date('d.m.Y H:i', strtotime($item['created_at'])) ?></td>
                <td>
                    <?php
                    if (Auth::isLoggedIn()): ?>
                        <a href="index.php?action=edit&id=<?= $item['id'] ?>"
                           class="btn btn-warning">✏️</a>
                    <?php
                    endif; ?>

                    <?php
                    if (Auth::isAdmin()): ?>
                        <form method="POST" action="index.php?action=delete"
                              style="display:inline;"
                              onsubmit="return confirm('Удалить товар?')">
                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                            <button type="submit" class="btn btn-danger">🗑️</button>
                        </form>
                    <?php
                    endif; ?>
                </td>
            </tr>
        <?php
        endforeach; ?>
        </tbody>
    </table>
<?php
endif; ?>
<!-- ========== ПАГИНАЦИЯ ========== -->
<?php
if ($totalPages > 1): ?>
    <div style="text-align: center; margin-top: 20px;">

        <!-- Кнопка "Назад" -->
        <?php
        if ($page > 1): ?>
            <a href="index.php?action=list&page=<?= $page - 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>"
               class="btn btn-primary">← Назад</a>
        <?php
        endif; ?>

        <!-- Номера страниц -->
        <?php
        for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php
            if ($i === $page): ?>
                <!-- Текущая страница — выделяем -->
                <span class="btn btn-warning" style="cursor: default;">
                    <strong><?= $i ?></strong>
                </span>
            <?php
            else: ?>
                <a href="index.php?action=list&page=<?= $i ?><?= $search ? '&search=' . urlencode($search) : '' ?>"
                   class="btn btn-primary"><?= $i ?></a>
            <?php
            endif; ?>
        <?php
        endfor; ?>

        <!-- Кнопка "Дальше" -->
        <?php
        if ($page < $totalPages): ?>
            <a href="index.php?action=list&page=<?= $page + 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>"
               class="btn btn-primary">Дальше →</a>
        <?php
        endif; ?>

        <p style="color: #888; margin-top: 10px;">
            Страница <?= $page ?> из <?= $totalPages ?> (всего товаров: <?= $totalItems ?>)
        </p>
    </div>
<?php
endif; ?>
