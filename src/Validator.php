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
}