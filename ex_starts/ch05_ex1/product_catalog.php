<?php
require_once __DIR__ . '/../ch04_ex1/model/db.php';
require_once __DIR__ . '/../ch04_ex1/model/product_db.php';

initialize_database();
$productDB = new ProductDB(get_db());
$products = $productDB->getProductsByCategory();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog | My Guitar Shop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #d9d9d9;
        }
        .page {
            width: min(960px, calc(100% - 32px));
            margin: 40px auto;
            background: #f5f5f5;
            border: 1px solid #666;
        }
        .header {
            background: #cfcfcf;
            padding: 18px 24px 12px;
            border-bottom: 2px solid #444;
        }
        h1 {
            margin: 0;
            font-size: 2rem;
        }
        .content {
            padding: 20px 24px 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }
        th, td {
            border: 1px solid #666;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background: #ededed;
        }
        .right {
            text-align: right;
        }
        .nav {
            margin-top: 16px;
        }
        a {
            color: #0059a6;
        }
        @media (max-width: 560px) {
            .content {
                padding: 16px;
                overflow-x: auto;
            }
            table {
                min-width: 520px;
            }
        }
    </style>
</head>
<body>
    <main class="page">
        <header class="header">
            <h1>Product Catalog</h1>
        </header>
        <section class="content">
            <?php if ($products): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th class="right">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                                <td><?php echo htmlspecialchars($product['product_code']); ?></td>
                                <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                                <td class="right"><?php echo '$' . number_format((float) $product['product_price'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No products are available.</p>
            <?php endif; ?>
            <p class="nav"><a href="index.php">Back to Menu</a> | <a href="../ch04_ex1/index.php">Product Manager</a></p>
        </section>
    </main>
</body>
</html>
