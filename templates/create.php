<?php
// ============================================
// ШАБЛОН: Форма создания нового товара
// ============================================
// Переменные:
//   $errors — массив ошибок валидации (может быть пустым)
?>

<h1>➕ Добавить новый товар</h1>
<br>

<!-- Показываем ошибки, если есть -->
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
    <!-- method="POST" — данные отправляются в теле запроса (безопасно) -->
    <!-- action="" — отправка на ту же страницу (index.php?action=create) -->
    <form method="POST" action="index.php?action=create">

        <div class="form-group">
            <label for="name">Название товара *</label>
            <!-- value="..." — сохраняем введённое значение при ошибке -->
            <!-- ?? '' — если переменной нет, подставить пустую строку -->
            <input type="text"
                   id="name"
                   name="name"
                   value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                   placeholder="Например: Ноутбук Lenovo"
                   required>
        </div>

        <div class="form-group">
            <label for="description">Описание</label>
            <textarea id="description"
                      name="description"
                      placeholder="Подробное описание товара..."
            ><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label for="category_id">Категория</label>
            <select id="category_id" name="category_id"
                    style="width:100%; padding:10px; border:1px solid #ddd; border-radius:4px; font-size:16px;">
                <option value="0">-- Без категории --</option>
                <?php
                foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"
                            <?= (int)($_POST['category_id'] ?? 0) === $cat['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php
                endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="price">Цена (₽) *</label>
            <input type="number"
                   id="price"
                   name="price"
                   value="<?= htmlspecialchars($_POST['price'] ?? '0') ?>"
                   step="0.01"
                   min="0"
                   required>
        </div>

        <div class="form-group">
            <label for="quantity">Количество *</label>
            <input type="number"
                   id="quantity"
                   name="quantity"
                   value="<?= htmlspecialchars($_POST['quantity'] ?? '0') ?>"
                   min="0"
                   required>
        </div>

        <button type="submit" class="btn btn-success">💾 Сохранить</button>
        <a href="index.php" class="btn btn-primary">← Назад</a>
    </form>
</div>
