<?php
// ============================================
// ШАБЛОН: Форма регистрации
// ============================================
// Переменные:
//   $errors — массив ошибок валидации
?>

<h1>📝 Регистрация</h1>
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
    <form method="POST" action="index.php?action=register">

        <div class="form-group">
            <label for="username">Логин *</label>
            <input type="text"
                   id="username"
                   name="username"
                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                   placeholder="Минимум 3 символа"
                   required>
        </div>

        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email"
                   id="email"
                   name="email"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                   placeholder="example@mail.ru"
                   required>
        </div>

        <div class="form-group">
            <label for="password">Пароль *</label>
            <input type="password"
                   id="password"
                   name="password"
                   placeholder="Минимум 6 символов"
                   required>
        </div>

        <div class="form-group">
            <label for="password_confirm">Повторите пароль *</label>
            <input type="password"
                   id="password_confirm"
                   name="password_confirm"
                   placeholder="Введите пароль ещё раз"
                   required>
        </div>

        <button type="submit" class="btn btn-success">✅ Зарегистрироваться</button>
        <a href="index.php?action=login" class="btn btn-primary">← Уже есть аккаунт</a>
    </form>
</div>
