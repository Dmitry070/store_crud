-- Принудительно ставим кодировку для этой сессии
SET NAMES utf8mb4;
SET
CHARACTER SET utf8mb4;

CREATE TABLE IF NOT EXISTS products
(
    id
    INT
    AUTO_INCREMENT
    PRIMARY
    KEY,
    name
    VARCHAR
(
    255
) NOT NULL,
    description TEXT,
    price DECIMAL
(
    10,
    2
) NOT NULL DEFAULT 0.00,
    quantity INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;

INSERT INTO products (name, description, price, quantity)
VALUES ('Ноутбук Lenovo ThinkPad', 'Надёжный ноутбук, 16GB RAM, 512GB SSD', 75990.00, 15),
       ('Монитор Samsung 27"', '4K UHD, IPS-матрица, 60Hz', 32500.00, 8),
       ('Клавиатура Logitech K380', 'Беспроводная, Bluetooth, компактная', 3490.00, 45),
       ('Мышь Razer DeathAdder', 'Игровая мышь, 20000 DPI, RGB', 4990.00, 30),
       ('Наушники Sony WH-1000XM5', 'Беспроводные, шумоподавление', 29990.00, 12);