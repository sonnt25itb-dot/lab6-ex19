<?php

require_once __DIR__ . '/db.php';

function get_products_by_category(): array
{
    $db = get_db();
    $query = '
        SELECT p.*, c.category_name
        FROM products p
        INNER JOIN categories c ON c.category_id = p.category_id
        ORDER BY c.category_name, p.product_name';

    return $db->query($query)->fetchAll();
}

function get_products_for_category(int $categoryId): array
{
    $db = get_db();
    $query = '
        SELECT p.*
        FROM products p
        WHERE p.category_id = :category_id
        ORDER BY p.product_name';
    $stmt = $db->prepare($query);
    $stmt->execute([':category_id' => $categoryId]);
    return $stmt->fetchAll();
}

function add_product(int $categoryId, string $code, string $name, float $price, string $description = ''): void
{
    $db = get_db();
    $query = '
        INSERT INTO products (category_id, product_code, product_name, product_price, description)
        VALUES (:category_id, :code, :name, :price, :description)';
    $stmt = $db->prepare($query);
    $stmt->execute([
        ':category_id' => $categoryId,
        ':code' => trim($code),
        ':name' => trim($name),
        ':price' => number_format($price, 2, '.', ''),
        ':description' => trim($description),
    ]);
}

function delete_product(int $id): void
{
    $db = get_db();
    $stmt = $db->prepare('DELETE FROM products WHERE product_id = :id');
    $stmt->execute([':id' => $id]);
}
