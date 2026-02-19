<?php

declare(strict_types=1);

class Product
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM products ORDER BY created_at DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false
    {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create(array $data): int
    {
        $sql = "INSERT INTO products (name, description, price, quantity)
                VALUES (:name, :description, :price, :quantity)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE products
                SET name = :name,
                    description = :description,
                    price = :price,
                    quantity = :quantity
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
        ]);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Поиск товаров по названию и описанию
     */
    public function search(string $query): array
    {

        $sql = "SELECT * FROM products 
                WHERE name LIKE :query1 
                   OR description LIKE :query2 
                ORDER BY created_at DESC";

        $stmt = $this->pdo->prepare($sql);

        $searchTerm = '%' . $query . '%';

        // Передаём одно и то же значение, но под разными именами
        $stmt->execute([
            'query1' => $searchTerm,
            'query2' => $searchTerm,
        ]);

        return $stmt->fetchAll();
    }
}
