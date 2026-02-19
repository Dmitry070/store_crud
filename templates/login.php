<?php
// ============================================
// ШАБЛОН: Форма входа (логин)
// ============================================
?>

<h1>🔑 Вход в систему</h1>
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
    <!-- method="POST" — пароль отправляется безопасно, в теле запроса -->
    <!-- НЕ через GET! Иначе пароль будет виден в URL -->
    <form method="POST" action="index.php?action=login">

        <div class="form-group">
            <label for="username">Логин</label>
            <input type="text"
                   id="username"
                   name="username"
                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                   placeholder="Введите логин"
                   required>
        </div>

        <div class="form-group">
            <label for="password">Пароль</label>
            <!-- type="password" — скрывает символы точками -->
            <!-- value НЕ заполняем! Пароль не нужно "запоминать" в форме -->
            <input type="password"
                   id="password"
                   name="password"
                   placeholder="Введите пароль"
                   required>
        </div>

        <button type="submit" class="btn btn-success">🔓 Войти</button>
        <a href="index.php" class="btn btn-primary">← К товарам</a>
        <a href="index.php?action=register" class="btn btn-warning">📝 Регистрация</a>
    </form>
</div>
