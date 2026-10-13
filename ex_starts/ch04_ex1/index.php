<?php
require_once __DIR__ . '/model/db.php';
require_once __DIR__ . '/model/product_db.php';
require_once __DIR__ . '/model/category_db.php';

initialize_database();
$productDB = new ProductDB(get_db());
$categoryDB = new CategoryDB(get_db());
$categories = $categoryDB->getCategories();
$successMessage = '';

if (isset($_GET['message'])) {
    $successMessage = htmlspecialchars($_GET['message']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #d9d9d9;
        }
        .page {
            width: 960px;
            margin: 40px auto;
            background: #f5f5f5;
            border: 1px solid #666;
            padding: 0;
            box-sizing: border-box;
        }
        .header {
            background: #cfcfcf;
            padding: 18px 24px 12px;
            border-bottom: 2px solid #444;
            margin-bottom: 18px;
        }
        h1 {
            margin: 0;
            font-size: 2.3rem;
            font-weight: 700;
        }
        h2 {
            margin: 0 0 10px;
            font-size: 1.7rem;
        }
        .content {
            padding: 0 24px 24px;
        }
        .category {
            margin-bottom: 30px;
        }
        .category table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .category th, .category td {
            border: 1px solid #666;
            padding: 8px 10px;
            text-align: left;
        }
        .category th {
            background: #ededed;
        }
        .category .right {
            text-align: right;
        }
        .category a, .nav a, .link-button {
            color: #0059a6;
            text-decoration: none;
        }
        .nav {
            margin-top: 15px;
        }
        .footer {
            border-top: 1px solid #555;
            margin-top: 15px;
            padding-top: 10px;
            font-size: 0.8rem;
            color: #444;
        }
        .message {
            margin: 10px 0;
            color: #0e6b1a;
            font-weight: bold;
        }
        .errors {
            color: #a00;
            margin: 10px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            <h1>Product Manager</h1>
        </div>
        <div class="content">
            <?php if ($successMessage): ?>
                <div class="message"><?php echo $successMessage; ?></div>
            <?php endif; ?>

            <?php foreach ($categories as $category): ?>
                <div class="category">
                    <h2><?php echo htmlspecialchars($category->getCategoryName()); ?></h2>
                    <?php $products = $productDB->getProductsForCategory($category->getCategoryId()); ?>
                    <?php if (count($products) > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th class="right">Price</th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($product['product_code']); ?></td>
                                        <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                                        <td class="right"><?php echo '$' . number_format((float) $product['product_price'], 2); ?></td>
                                        <td>
                                            <a href="delete_product.php?id=<?php echo (int) $product['product_id']; ?>">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No products in this category.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <div class="nav">
                <a href="add_product_form.php">Add Product</a>
            </div>
            <div class="nav">
                <a href="list_categories.php">List Categories</a>
            </div>

            <div class="footer">© 2014 My Guitar Shop, Inc.</div>
        </div>
    </div>
</body>
</html>
