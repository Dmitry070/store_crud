<?php
// ============================================
// ШАБЛОН: Просмотр одного товара
// ============================================
// Переменные:
//   $item — данные товара
?>

<?php
if (isset($_GET['success']) && $_GET['success'] === 'updated'): ?>
    <div class="alert alert-success">✅ Товар успешно обновлён!</div>
<?php
endif; ?>

<div class="card">
    <h2><?= htmlspecialchars($item['name']) ?></h2>

    <table>
        <tr>
            <th style="width:200px;">ID</th>
            <td><?= $item['id'] ?></td>
        </tr>
        <tr>
            <th>Название</th>
            <td><?= htmlspecialchars($item['name']) ?></td>
        </tr>
        <tr>
            <th>Описание</th>
            <td><?= nl2br(htmlspecialchars($item['description'] ?? 'Нет описания')) ?></td>
            <!-- nl2br() — заменяет переносы строк (\n) на HTML-тег <br> -->
        </tr>
        <tr>
            <th>Цена</th>
            <td><strong><?= number_format($item['price'], 2, '.', ' ') ?> ₽</strong></td>
        </tr>
        <tr>
            <th>На складе</th>
            <td><?= $item['quantity'] ?> шт.</td>
        </tr>
        <tr>
            <th>Создан</th>
            <td><?= date('d.m.Y в H:i', strtotime($item['created_at'])) ?></td>
        </tr>
        <tr>
            <th>Обновлён</th>
            <td><?= date('d.m.Y в H:i', strtotime($item['updated_at'])) ?></td>
        </tr>
    </table>

    <div class="actions">
        <a href="index.php" class="btn btn-primary">← К списку</a>
        <a href="index.php?action=edit&id=<?= $item['id'] ?>" class="btn btn-warning">✏️ Редактировать</a>

        <form method="POST" action="index.php?action=delete"
              style="display:inline;"
              onsubmit="return confirm('Вы уверены? Товар будет удалён!')">
            <input type="hidden" name="id" value="<?= $item['id'] ?>">
            <button type="submit" class="btn btn-danger">🗑️ Удалить</button>
        </form>
    </div>
</div>
