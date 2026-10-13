<?php
require_once __DIR__ . '/model/db.php';
require_once __DIR__ . '/model/category_db.php';

initialize_database();
$categories = (new CategoryDB(get_db()))->getCategories();
$message = '';

if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #d9d9d9;
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
        h2 {
            margin: 0 0 10px;
            font-size: 1.7rem;
        }
        .content {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #666;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background: #eee;
        }
        .delete-link {
            font-size: 0.9rem;
        }
        .form-row {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-top: 10px;
        }
        .nav {
            margin-top: 20px;
        }
        .message {
            color: #0e6b1a;
            font-weight: bold;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            <h1>Product Manager</h1>
        </div>
        <div class="content">
            <h2>Category List</h2>

            <?php if ($message): ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>

            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($category->getCategoryName()); ?></td>
                            <td class="delete-link">
                                <a href="delete_category.php?id=<?php echo (int) $category->getCategoryId(); ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h3>Add Category</h3>
            <form method="post" action="add_category.php">
                <div class="form-row">
                    <label for="category_name">Name</label>
                    <input type="text" id="category_name" name="category_name" required>
                    <button type="submit">Add</button>
                </div>
            </form>

            <div class="nav">
                <a href="index.php">List Products</a>
            </div>
        </div>
    </div>
</body>
</html>
