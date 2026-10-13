<?php
require_once __DIR__ . '/model/db.php';
require_once __DIR__ . '/model/category_db.php';

initialize_database();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$categoryDB = new CategoryDB(get_db());

if ($id === null || $id === false) {
    header('Location: list_categories.php?message=' . urlencode('Invalid category id.'));
    exit;
}

if ($categoryDB->getCategoryProductCount($id) > 0) {
    header('Location: list_categories.php?message=' . urlencode('This category contains products and cannot be deleted.'));
    exit;
}

$categoryDB->deleteCategory($id);
header('Location: list_categories.php?message=' . urlencode('Category deleted.'));
exit;
