<?php

class Validator
{
    public function validateProduct(array $data): array
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors[] = 'Название товара обязательно';
        }

        if (mb_strlen($data['name']) > 255) {
            $errors[] = 'Название не может быть длиннее 255 символов';
        }

        if ($data['price'] < 0) {
            $errors[] = 'Цена не может быть отрицательной';
        }

        if ($data['quantity'] < 0) {
            $errors[] = 'Количество не может быть отрицательным';
        }

        return $errors;
    }

    public function validateRegistration(array $data): array
    {
        $errors = [];

        // --- Логин ---
        if (empty($data['username'])) {
            $errors[] = 'Логин обязателен';
        } elseif (mb_strlen($data['username']) < 3) {
            $errors[] = 'Логин должен быть не менее 3 символов';
        } elseif (mb_strlen($data['username']) > 100) {
            $errors[] = 'Логин не может быть длиннее 100 символов';
        }

        // --- Email ---
        if (empty($data['email'])) {
            $errors[] = 'Email обязателен';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Некорректный формат email';
        }

        // --- Пароль ---
        if (empty($data['password'])) {
            $errors[] = 'Пароль обязателен';
        } elseif (mb_strlen($data['password']) < 6) {
            $errors[] = 'Пароль должен быть не короче 6 символов';
        }

        // --- Подтверждение пароля ---
        if ($data['password'] !== $data['password_confirm']) {
            $errors[] = 'Пароли не совпадают';
        }

        return $errors;
    }
}
