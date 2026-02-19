SET NAMES utf8mb4;
SET
CHARACTER SET utf8mb4;

-- ══════════════════════════════════════
-- КАТЕГОРИИ (создаём ПЕРВОЙ, т.к. products ссылается на неё)
-- ═════════════════════════════════════���
CREATE TABLE IF NOT EXISTS categories
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
) NOT NULL UNIQUE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;

-- ══════════════════════════════════════
-- ТОВАРЫ
-- ══════════════════════════════════════
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
    category_id INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- FOREIGN KEY — связь с таблицей categories
    -- Если категорию удалят — у товара category_id станет NULL
    FOREIGN KEY
(
    category_id
) REFERENCES categories
(
    id
)
                                                   ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;

-- ══════════════════════════════════════
-- ПОЛЬЗОВАТЕЛИ
-- ══════════════════════════════════════
CREATE TABLE IF NOT EXISTS users
(
    id
    INT
    AUTO_INCREMENT
    PRIMARY
    KEY,
    username
    VARCHAR
(
    100
) NOT NULL UNIQUE,
    email VARCHAR
(
    255
) NOT NULL UNIQUE,
    password VARCHAR
(
    255
) NOT NULL,
    role ENUM
(
    'admin',
    'user'
) NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE =utf8mb4_unicode_ci;

-- ══════════════════════════════════════
-- ТЕСТОВЫЕ ДАННЫЕ
-- ══════════════════════════════════════
INSERT INTO categories (name)
VALUES ('Ноутбуки'),
       ('Мониторы'),
       ('Клавиатуры'),
       ('Мыши'),
       ('Наушники');

INSERT INTO products (name, description, price, quantity, category_id)
VALUES ('Ноутбук Lenovo ThinkPad', 'Надёжный ноутбук, 16GB RAM, 512GB SSD', 75990.00, 15, 1),
       ('Монитор Samsung 27"', '4K UHD, IPS-матрица, 60Hz', 32500.00, 8, 2),
       ('Клавиатура Logitech K380', 'Беспроводная, Bluetooth, компактная', 3490.00, 45, 3),
       ('Мышь Razer DeathAdder', 'Игровая мышь, 20000 DPI, RGB', 4990.00, 30, 4),
       ('Наушники Sony WH-1000XM5', 'Беспроводные, шумоподавление', 29990.00, 12, 5);

-- ── Тестовый администратор ──
-- Хеш для пароля 'admin123', сгенерированный через:
-- php -r "echo password_hash('admin123', PASSWORD_BCRYPT);"
INSERT INTO users (username, email, password, role)
VALUES ('admin', 'admin@store.ru',
        '$2y$10$WK7GSqmxRHVsDTR3P2pEEuglqHGrz0Eub9sISLaCFWABu9vRgfvTm',
        'admin');