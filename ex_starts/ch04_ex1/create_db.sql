CREATE DATABASE IF NOT EXISTS my_guitar_shop;
USE my_guitar_shop;

DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;

CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE products (
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
) ENGINE=InnoDB;

INSERT INTO categories (category_name) VALUES
('Guitars'),
('Basses'),
('Drums');

INSERT INTO products (category_id, product_code, product_name, product_price, description) VALUES
(1, 'strat', 'Fender Stratocaster', 699.00, 'Classic electric guitar'),
(1, 'les_paul', 'Gibson Les Paul', 1199.00, 'Traditional solid-body guitar'),
(2, 'precision', 'Fender Precision', 799.00, 'Reliable bass guitar'),
(2, 'jazz', 'Gibson EB-2', 899.00, 'Warm and punchy bass'),
(3, 'drums', 'Peavey Drum Kit', 799.00, 'Complete drum set');
