<?php
// ============================================
// ШАБЛОН: Форма редактирования товара
// ============================================
// Переменные:
//   $item   — данные текущего товара
//   $errors — массив ошибок валидации
?>

<h1>✏️ Редактировать: <?= htmlspecialchars($item['name']) ?></h1>
<br>

<?php
if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <strong>Ошибки:</strong>
        <ul>
            <?php
            foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php
            endforeach; ?>
        </ul>
    </div>
<?php
endif; ?>

<div class="card">
    <!-- Форма отправляется на edit с указанием id -->
    <form method="POST" action="index.php?action=edit&id=<?= $item['id'] ?>">

        <div class="form-group">
            <label for="name">Название товара *</label>
            <input type="text" id="name" name="name"
                   value="<?= htmlspecialchars($item['name']) ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="description">Описание</label>
            <textarea id="description"
                      name="description"
            ><?= htmlspecialchars($item['description'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label for="category_id">Категория</label>
            <select id="category_id" name="category_id"
                    style="width:100%; padding:10px; border:1px solid #ddd; border-radius:4px; font-size:16px;">
                <option value="0">-- Без категории --</option>
                <?php
                foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"
                            <?= (int)($item['category_id'] ?? 0) === $cat['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php
                endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="price">Цена (₽) *</label>
            <input type="number" id="price" name="price"
                   value="<?= htmlspecialchars($item['price']) ?>"
                   step="0.01" min="0" required>
        </div>

        <div class="form-group">
            <label for="quantity">Количество *</label>
            <input type="number" id="quantity" name="quantity"
                   value="<?= htmlspecialchars($item['quantity']) ?>"
                   min="0" required>
        </div>

        <button type="submit" class="btn btn-warning">💾 Обновить</button>
        <a href="index.php?action=show&id=<?= $item['id'] ?>" class="btn btn-primary">← Назад</a>
    </form>
</div>
