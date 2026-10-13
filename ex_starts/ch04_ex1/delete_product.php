<?php
require_once __DIR__ . '/model/db.php';
require_once __DIR__ . '/model/product_db.php';

initialize_database();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id === null || $id === false) {
    header('Location: index.php?message=' . urlencode('Invalid product id.'));
    exit;
}

(new ProductDB(get_db()))->deleteProduct($id);
header('Location: index.php?message=' . urlencode('Product deleted.'));
exit;
