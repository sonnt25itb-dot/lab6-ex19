<?php
require_once __DIR__ . '/model/db.php';
require_once __DIR__ . '/model/category_db.php';

initialize_database();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list_categories.php');
    exit;
}

$name = trim($_POST['category_name'] ?? '');

if ($name === '') {
    header('Location: list_categories.php?message=' . urlencode('Category name is required.'));
    exit;
}

add_category($name);
header('Location: list_categories.php?message=' . urlencode('Category added.'));
exit;
