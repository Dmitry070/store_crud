<?php

declare(strict_types=1);

class AuthController
{
    private User $user;
    private Validator $validator;

    public function __construct(User $user, Validator $validator)
    {
        $this->user = $user;
        $this->validator = $validator;
    }

    /**
     * Показать форму логина + обработать отправку формы
     */
    public function login(): void
    {
        // Если уже залогинен — нечего тут делать
        if (Auth::isLoggedIn()) {
            header('Location: index.php?action=list');
            exit();
        }

        $errors = [];

        // Если форма отправлена (нажали кнопку "Войти")
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Получаем данные из формы
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            // Валидация данных - поля не должны быть пустыми
            if (empty($username) || empty($password)) {
                $errors = 'Пожалуйста, заполните все поля.';
            }

            //Если нет ошибок валидации, пробуем найти пользователя и проверить пароль
            if (empty($errors)) {
                $user = $this->user->findByUsername($username);

                // Проверяем: нашли ли пользователя И совпадает ли пароль?
                if ($user && password_verify($password, $user['password'])) {
                    // Логиним пользователя
                    Auth::start();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];

                    // Защита от "фиксации сессии" — генерируем новый ID
                    session_regenerate_id(true);

                    // Перенаправляем на список товаров
                    header('Location: index.php?action=list');
                    exit();
                } else {
                    $errors[] = 'Неверный логин или пароль';
                }
            }
        }

        // Показываем форму логина (передаем ошибки, если есть)
        $pageTitle = 'Вход в систему';
        require __DIR__ . '/../templates/header.php';
        require __DIR__ . '/../templates/login.php';
        require __DIR__ . '/../templates/footer.php';
    }

    public function register(): void
    {
        if (Auth::isLoggedIn()) {
            header('Location: index.php?action=list');
            exit();
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => trim($_POST['username'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'password' => $_POST['password'] ?? '',
                'password_confirm' => $_POST['password_confirm'] ?? '',
            ];

            // Валидация данных
            $errors = $this->validator->validateRegistration($data);

            // Проверяем уникальность логина и email в БД
            if (empty($errors)) {
                if ($this->user->usernameExists($data['username'])) {
                    $errors[] = 'Этот логин уже занят';
                }
                if ($this->user->emailExists($data['email'])) {
                    $errors[] = 'Этот email уже зарегистрирован';
                }
            }

            // Если всё ок — создаём пользователя
            if (empty($errors)) {
                $userId = $this->user->create($data);

                // Сразу логиним нового пользователя
                Auth::start();
                $_SESSION['user_id'] = $userId;
                $_SESSION['username'] = $data['username'];
                $_SESSION['role'] = 'user';  // Новые пользователи — всегда user
                session_regenerate_id(true);

                header('Location: index.php?action=list');
                exit();
            }
        }

        $pageTitle = 'Регистрация';
        require __DIR__ . '/../templates/header.php';
        require __DIR__ . '/../templates/register.php';
        require __DIR__ . '/../templates/footer.php';
    }

    /**
     * Выход из системы
     */
    public
    function logout(): void
    {
        Auth::start();
        Auth::logout();

        header('Location: index.php?action=login');
        exit();
    }
}
