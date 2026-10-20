<?php
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/product_db.php';
require_once __DIR__ . '/../ch04_ex1/model/category_db.php';

initialize_database();

$guitarCategory = null;
foreach (get_categories() as $category) {
    if ($category->getCategoryName() === 'Guitars') {
        $guitarCategory = $category;
        break;
    }
}

if ($guitarCategory === null) {
    throw new RuntimeException('The Guitars category does not exist.');
}

$inserted = add_product(
    $guitarCategory->getCategoryId(),
    'ex19gtr',
    'Exercise 19 Guitar',
    699.99,
    'Product added by Exercise 19-1'
);
$message = $inserted
    ? 'The sample product was inserted.'
    : 'The sample product was not inserted because its product code already exists.';
$products = get_products_for_category($guitarCategory->getCategoryId());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise 19-1 | My Guitar Shop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #d9d9d9;
        }
        .page {
            width: min(900px, calc(100% - 32px));
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
        .message {
            font-weight: bold;
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
    </style>
</head>
<body>
    <main class="page">
        <header class="header">
            <h1>Guitars</h1>
        </header>
        <section class="content">
            <p class="message"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php if ($products): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['product_code'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>$<?php echo number_format((float) $product['product_price'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No products are available in this category.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
