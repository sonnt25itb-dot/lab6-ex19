<?php
require_once __DIR__ . '/model/db.php';
require_once __DIR__ . '/model/category_db.php';

initialize_database();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id === null || $id === false) {
    header('Location: list_categories.php?message=' . urlencode('Invalid category id.'));
    exit;
}

if (get_category_product_count($id) > 0) {
    header('Location: list_categories.php?message=' . urlencode('This category contains products and cannot be deleted.'));
    exit;
}

delete_category($id);
header('Location: list_categories.php?message=' . urlencode('Category deleted.'));
exit;
