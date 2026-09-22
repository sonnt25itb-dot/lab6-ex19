<?php

require_once __DIR__ . '/db.php';

function get_categories(): array
{
    $db = get_db();
    $query = 'SELECT * FROM categories ORDER BY category_name';
    return $db->query($query)->fetchAll();
}

function get_category_by_id(int $id): ?array
{
    $db = get_db();
    $query = 'SELECT * FROM categories WHERE category_id = :id';
    $stmt = $db->prepare($query);
    $stmt->execute([':id' => $id]);
    $category = $stmt->fetch();

    return $category ?: null;
}

function add_category(string $name): void
{
    $db = get_db();
    $query = 'INSERT INTO categories (category_name) VALUES (:name)';
    $stmt = $db->prepare($query);
    $stmt->execute([':name' => trim($name)]);
}

function get_category_product_count(int $id): int
{
    $db = get_db();
    $stmt = $db->prepare('SELECT COUNT(*) FROM products WHERE category_id = :id');
    $stmt->execute([':id' => $id]);
    return (int) $stmt->fetchColumn();
}

function delete_category(int $id): void
{
    $db = get_db();
    $stmt = $db->prepare('DELETE FROM categories WHERE category_id = :id');
    $stmt->execute([':id' => $id]);
}
