<?php
require_once __DIR__ . '/model/db.php';
require_once __DIR__ . '/model/category_db.php';

initialize_database();
$categories = (new CategoryDB(get_db()))->getCategories();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #d9d9d9;
            margin: 0;
        }
        .page {
            width: 760px;
            margin: 40px auto;
            background: #f5f5f5;
            border: 1px solid #666;
            padding: 0;
        }
        .header {
            background: #cfcfcf;
            padding: 16px 20px 10px;
            border-bottom: 2px solid #444;
        }
        h1 {
            margin: 0;
            font-size: 2.1rem;
        }
        .content {
            padding: 20px;
        }
        form {
            max-width: 500px;
        }
        .field {
            margin: 10px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        label {
            width: 120px;
            font-weight: bold;
        }
        input, select, textarea {
            padding: 6px 8px;
            border: 1px solid #888;
            width: 100%;
            box-sizing: border-box;
        }
        textarea {
            height: 90px;
        }
        .actions {
            margin-top: 12px;
            display: flex;
            gap: 10px;
            align-items: center;
        }
        button {
            padding: 8px 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            <h1>Product Manager</h1>
        </div>
        <div class="content">
            <h2>Add Product</h2>
            <form method="post" action="add_product.php">
                <div class="field">
                    <label for="category_id">Category</label>
                    <select id="category_id" name="category_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo (int) $category->getCategoryId(); ?>"><?php echo htmlspecialchars($category->getCategoryName()); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="field">
                    <label for="code">Code</label>
                    <input id="code" name="code" type="text" required>
                </div>
                <div class="field">
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text" required>
                </div>
                <div class="field">
                    <label for="price">Price</label>
                    <input id="price" name="price" type="number" step="0.01" min="0" required>
                </div>
                <div class="field">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"></textarea>
                </div>
                <div class="actions">
                    <button type="submit">Add</button>
                    <a href="index.php">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
