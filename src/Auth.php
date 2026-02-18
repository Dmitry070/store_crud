<?php

declare(strict_types=1);

class Auth
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Залогинить пользователя
     * Сохраняем данные в сессию
     */
    public function login(array $user): void
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        session_regenerate_id(true);
    }

    /**
     * Разлогинить пользователя
     */
    public static function logout(): void
    {
        // Очищаем все данные сессии
        $_SESSION = [];

        // Удаляем cookie сессии
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        // Уничтожаем сессию
        session_destroy();
    }

    /**
     * Проверить: залогинен ли пользователь?
     */
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Проверить: является ли пользователь админом?
     */
    public static function isAdmin(): bool
    {
        return ($_SESSION['role'] ?? '') === 'admin';
    }

    /**
     * Получить имя текущего пользователя
     */
    public static function getUsername(): string
    {
        return $_SESSION['username'] ?? 'admin';
    }

    /**
     * Получить ID текущего пользователя
     */
    public static function getUserId(): int
    {
        return (int)($_SESSION['user_id'] ?? 0);
    }

    /**
     * Требовать авторизацию
     * Если не залогинен — перенаправляем на логин
     */
    public static function requireLogin(): void
    {
        if (!self::isLoggedIn()) {
            header('Location: index.php?action=login');
            exit();
        }
    }

    /**
     * Требовать роль администратора
     */
    public static function requireAdmin(): void
    {
        self::requireLogin();

        if (!self::isAdmin()) {
            http_response_code(403);
            die('⛔ Доступ запрещён. Требуется роль администратора.');
        }
    }
}
