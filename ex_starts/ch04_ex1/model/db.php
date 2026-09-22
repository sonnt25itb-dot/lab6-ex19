<?php

function get_db(): PDO
{
    static $db = null;

    if ($db !== null) {
        return $db;
    }

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $attempts = [];
    $attempts[] = function () use ($options) {
        $db = new PDO('mysql:host=localhost;charset=utf8mb4', 'root', '', $options);
        $db->exec('CREATE DATABASE IF NOT EXISTS my_guitar_shop');
        $db->exec('USE my_guitar_shop');
        return $db;
    };
    $attempts[] = function () use ($options) {
        $databaseFile = __DIR__ . '/../my_guitar_shop.db';
        return new PDO('sqlite:' . $databaseFile, null, null, $options);
    };

    foreach ($attempts as $attempt) {
        try {
            $db = $attempt();
            return $db;
        } catch (PDOException $e) {
            continue;
        }
    }

    throw new RuntimeException('Unable to connect to the database.');
}

function is_sqlite_database(): bool
{
    return get_db()->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite';
}

function initialize_database(): void
{
    $db = get_db();

    if (is_sqlite_database()) {
        $db->exec(
            'CREATE TABLE IF NOT EXISTS categories (
                category_id INTEGER PRIMARY KEY AUTOINCREMENT,
                category_name TEXT NOT NULL
            )'
        );

        $db->exec(
            'CREATE TABLE IF NOT EXISTS products (
                product_id INTEGER PRIMARY KEY AUTOINCREMENT,
                category_id INTEGER NOT NULL,
                product_code TEXT NOT NULL UNIQUE,
                product_name TEXT NOT NULL,
                product_price REAL NOT NULL,
                description TEXT,
                FOREIGN KEY (category_id) REFERENCES categories(category_id)
            )'
        );
    } else {
        $db->exec(
            'CREATE TABLE IF NOT EXISTS categories (
                category_id INT AUTO_INCREMENT PRIMARY KEY,
                category_name VARCHAR(255) NOT NULL
            ) ENGINE=InnoDB'
        );

        $db->exec(
            'CREATE TABLE IF NOT EXISTS products (
                product_id INT AUTO_INCREMENT PRIMARY KEY,
                category_id INT NOT NULL,
                product_code VARCHAR(10) NOT NULL UNIQUE,
                product_name VARCHAR(255) NOT NULL,
                product_price DECIMAL(10,2) NOT NULL,
                description TEXT,
                CONSTRAINT fk_products_category
                    FOREIGN KEY (category_id)
                    REFERENCES categories(category_id)
                    ON DELETE RESTRICT
            ) ENGINE=InnoDB'
        );
    }

    $categoryCount = (int) $db->query('SELECT COUNT(*) FROM categories')->fetchColumn();
    if ($categoryCount === 0) {
        $db->exec("INSERT INTO categories (category_name) VALUES ('Guitars'), ('Basses'), ('Drums')");
    }

    $productCount = (int) $db->query('SELECT COUNT(*) FROM products')->fetchColumn();
    if ($productCount === 0) {
        $db->exec(
            "INSERT INTO products (category_id, product_code, product_name, product_price, description)
             VALUES
             (1, 'strat', 'Fender Stratocaster', 699.00, 'Classic electric guitar'),
             (1, 'les_paul', 'Gibson Les Paul', 1199.00, 'Traditional solid-body guitar'),
             (2, 'precision', 'Fender Precision', 799.00, 'Reliable bass guitar'),
             (2, 'jazz', 'Gibson EB-2', 899.00, 'Warm and punchy bass'),
             (3, 'drums', 'Peavey Drum Kit', 799.00, 'Complete drum set')"
        );
    }
}
