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

CREATE TABLE IF NOT EXISTS users
(
    id
    INT
    AUTO_INCREMENT
    PRIMARY
    KEY,

    -- Логин (уникальный — два юзера с одним логином невозможны)
    username
    VARCHAR
(
    100
) NOT NULL UNIQUE,

    -- Email (тоже уникальный)
    email VARCHAR
(
    255
) NOT NULL UNIQUE,

    -- Хеш пароля (НЕ сам пароль!)
    -- VARCHAR(255) — потому что хеш bcrypt длинный
    -- Мы НИКОГДА не храним пароли в открытом виде!
    password VARCHAR
(
    255
) NOT NULL,

    -- Роль: admin или user
    role ENUM
(
    'admin',
    'user'
) NOT NULL DEFAULT 'user',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;

-- ── Тестовые товары ──
INSERT INTO products (name, description, price, quantity)
VALUES ('Ноутбук Lenovo ThinkPad', 'Надёжный ноутбук, 16GB RAM, 512GB SSD', 75990.00, 15),
       ('Монитор Samsung 27"', '4K UHD, IPS-матрица, 60Hz', 32500.00, 8),
       ('Клавиатура Logitech K380', 'Беспроводная, Bluetooth, компактная', 3490.00, 45),
       ('Мышь Razer DeathAdder', 'Игровая мышь, 20000 DPI, RGB', 4990.00, 30),
       ('Наушники Sony WH-1000XM5', 'Беспроводные, шумоподавление', 29990.00, 12);

-- ── Тестовый администратор ──
-- Хеш для пароля 'admin123', сгенерированный через:
-- php -r "echo password_hash('admin123', PASSWORD_BCRYPT);"
INSERT INTO users (username, email, password, role)
VALUES ('admin', 'admin@store.ru',
        '$2y$10$WK7GSqmxRHVsDTR3P2pEEuglqHGrz0Eub9sISLaCFWABu9vRgfvTm',
        'admin');