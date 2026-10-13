<?php

require_once __DIR__ . '/db.php';

class Category
{
    private int $category_id = 0;
    private string $category_name = '';

    public function __construct()
    {
        $this->category_id = 0;
        $this->category_name = '';
    }

    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    public function setCategoryId(int $category_id): void
    {
        $this->category_id = $category_id;
    }

    public function getCategoryName(): string
    {
        return $this->category_name;
    }

    public function setCategoryName(string $category_name): void
    {
        $this->category_name = trim($category_name);
    }
}

class CategoryDB
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getCategories(): array
    {
        $query = 'SELECT * FROM categories ORDER BY category_name';
        $stmt = $this->db->query($query);
        $categories = [];

        foreach ($stmt->fetchAll() as $row) {
            $category = new Category();
            $category->setCategoryId((int) $row['category_id']);
            $category->setCategoryName((string) $row['category_name']);
            $categories[] = $category;
        }

        return $categories;
    }

    public function getCategoryById(int $id): ?Category
    {
        $query = 'SELECT * FROM categories WHERE category_id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        $category = new Category();
        $category->setCategoryId((int) $row['category_id']);
        $category->setCategoryName((string) $row['category_name']);
        return $category;
    }

    public function addCategory(Category $category): void
    {
        $query = 'INSERT INTO categories (category_name) VALUES (:name)';
        $stmt = $this->db->prepare($query);
        $stmt->execute([':name' => $category->getCategoryName()]);
    }

    public function getCategoryProductCount(int $id): int
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM products WHERE category_id = :id');
        $stmt->execute([':id' => $id]);
        return (int) $stmt->fetchColumn();
    }

    public function deleteCategory(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM categories WHERE category_id = :id');
        $stmt->execute([':id' => $id]);
    }
}

function get_categories(): array
{
    return (new CategoryDB(get_db()))->getCategories();
}

function get_category_by_id(int $id): ?Category
{
    return (new CategoryDB(get_db()))->getCategoryById($id);
}

function add_category(string $name): void
{
    $category = new Category();
    $category->setCategoryName($name);
    (new CategoryDB(get_db()))->addCategory($category);
}

function get_category_product_count(int $id): int
{
    return (new CategoryDB(get_db()))->getCategoryProductCount($id);
}

function delete_category(int $id): void
{
    (new CategoryDB(get_db()))->deleteCategory($id);
}
