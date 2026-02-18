<?php

declare(strict_types=1);

class User
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Найти пользователя по логину
     * Используется при входе (логине)
     */
    public function findByUsername(string $username): array|false
    {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt = execute(['username' => $username]);
        return $stmt->fetch();
    }

    /**
     * Найти пользователя по ID
     * Используется для проверки сессии
     */
    public function findById(int $id): array|false
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt = execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Создать нового пользователя (регистрация)
     */
    public function create(array $data): int
    {
        $sql = "INSERT INTO users (username, email, password, role)
                VALUES (:username, :email, :password, :role)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => $data['role'] ?? 'user',
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Проверить, существует ли логин
     */
    public function usernameExists(string $username): bool
    {
        $sql = "SELECT COUNT(*) FROM users WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        return $stmt->fetchColumn() > 0;
    }

    /**
     * Проверить, существует ли email
     */
    public function emailExists(string $email): bool
    {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn() > 0;
    }
}
