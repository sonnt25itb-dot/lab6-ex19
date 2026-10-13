<?php

require_once __DIR__ . '/db.php';

class Product
{
    private int $product_id = 0;
    private int $category_id = 0;
    private string $product_code = '';
    private string $product_name = '';
    private float $product_price = 0.0;
    private string $description = '';

    public function __construct()
    {
        $this->product_id = 0;
        $this->category_id = 0;
        $this->product_code = '';
        $this->product_name = '';
        $this->product_price = 0.0;
        $this->description = '';
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function setProductId(int $product_id): void
    {
        $this->product_id = $product_id;
    }

    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    public function setCategoryId(int $category_id): void
    {
        $this->category_id = $category_id;
    }

    public function getProductCode(): string
    {
        return $this->product_code;
    }

    public function setProductCode(string $product_code): void
    {
        $this->product_code = trim($product_code);
    }

    public function getProductName(): string
    {
        return $this->product_name;
    }

    public function setProductName(string $product_name): void
    {
        $this->product_name = trim($product_name);
    }

    public function getProductPrice(): float
    {
        return $this->product_price;
    }

    public function setProductPrice(float $product_price): void
    {
        $this->product_price = $product_price;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = trim($description);
    }
}

class ProductDB
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getProductsByCategory(): array
    {
        $query = '
            SELECT p.*, c.category_name
            FROM products p
            INNER JOIN categories c ON c.category_id = p.category_id
            ORDER BY c.category_name, p.product_name';

        return $this->db->query($query)->fetchAll();
    }

    public function getProductsForCategory(int $categoryId): array
    {
        $query = '
            SELECT p.*
            FROM products p
            WHERE p.category_id = :category_id
            ORDER BY p.product_name';
        $stmt = $this->db->prepare($query);
        $stmt->execute([':category_id' => $categoryId]);
        return $stmt->fetchAll();
    }

    public function addProduct(Product $product): void
    {
        $query = '
            INSERT INTO products (category_id, product_code, product_name, product_price, description)
            VALUES (:category_id, :code, :name, :price, :description)';
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':category_id' => $product->getCategoryId(),
            ':code' => $product->getProductCode(),
            ':name' => $product->getProductName(),
            ':price' => number_format($product->getProductPrice(), 2, '.', ''),
            ':description' => $product->getDescription(),
        ]);
    }

    public function deleteProduct(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM products WHERE product_id = :id');
        $stmt->execute([':id' => $id]);
    }
}

function get_products_by_category(): array
{
    return (new ProductDB(get_db()))->getProductsByCategory();
}

function get_products_for_category(int $categoryId): array
{
    return (new ProductDB(get_db()))->getProductsForCategory($categoryId);
}

function add_product(int $categoryId, string $code, string $name, float $price, string $description = ''): void
{
    $product = new Product();
    $product->setCategoryId($categoryId);
    $product->setProductCode($code);
    $product->setProductName($name);
    $product->setProductPrice($price);
    $product->setDescription($description);

    (new ProductDB(get_db()))->addProduct($product);
}

function delete_product(int $id): void
{
    (new ProductDB(get_db()))->deleteProduct($id);
}
