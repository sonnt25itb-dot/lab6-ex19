<?php
require_once __DIR__ . '/model/db.php';
require_once __DIR__ . '/model/product_db.php';

initialize_database();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$categoryId = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
$code = trim((string) ($_POST['code'] ?? ''));
$name = trim((string) ($_POST['name'] ?? ''));
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$description = trim((string) ($_POST['description'] ?? ''));

if ($categoryId === false || $categoryId === null || $code === '' || $name === '' || $price === false || $price === null) {
    header('Location: add_product_form.php?message=' . urlencode('Please enter valid product data.'));
    exit;
}

$product = new Product();
$product->setCategoryId((int) $categoryId);
$product->setProductCode($code);
$product->setProductName($name);
$product->setProductPrice((float) $price);
$product->setDescription($description);

(new ProductDB(get_db()))->addProduct($product);
header('Location: index.php?message=' . urlencode('Product added.'));
exit;
