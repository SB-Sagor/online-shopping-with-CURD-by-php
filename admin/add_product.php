<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
require 'config.php';

// Fetch categories from DB
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
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
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 10px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input, select, textarea, button {
            font-size: 16px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 80%;
        }

        textarea {
            resize: none;
        }

        button {
            padding: 10px 30px;
            background: linear-gradient(135deg, #00c853, #2e7d32);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        button:hover {
            background: linear-gradient(135deg, #2e7d32, #00c853);
            transform: scale(1.01);
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        label {
            font-weight: bold;
            color: #555;
        }

        .header {
            background: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-bottom: 40px;
        }

        .header h1 {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
    </div>
    <div class="container">
        <h2>Add New Product</h2>
        <form action="add_product_action.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" name="name" id="name" placeholder="Enter product name" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" placeholder="Enter product price" required>
            </div>
            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" name="image" id="image" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="4" placeholder="Enter product description"></textarea>
            </div>
            <button type="submit">Add Product</button>
        </form>
    </div>
</body>
</html>
