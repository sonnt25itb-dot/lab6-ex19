<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Guitar Shop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #d9d9d9;
        }
        .page {
            width: min(760px, calc(100% - 32px));
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
            padding: 24px;
        }
        ul {
            padding-left: 22px;
            line-height: 2;
        }
        a {
            color: #0059a6;
        }
    </style>
</head>
<body>
    <main class="page">
        <header class="header">
            <h1>My Guitar Shop</h1>
        </header>
        <section class="content">
            <h2>Application Menu</h2>
            <ul>
                <li><a href="../ch04_ex1/index.php">Product Manager</a></li>
                <li><a href="product_catalog.php">Product Catalog</a></li>
            </ul>
        </section>
    </main>
</body>
</html>
