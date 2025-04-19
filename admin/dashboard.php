<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

require 'config.php'; // Include database connection

// Fetch categories from the database
$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .header {
            background: #2c3e50;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin: 0 0 20px;
            text-align: center;
            color: #333;
        }

        .menu {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
        }

        .menu a {
            text-decoration: none;
            padding: 10px 20px;
            color: white;
            background: #28a745;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-weight: bold;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .menu a:hover {
            background: #218838;
            transform: scale(1.05);
        }

        .logout {
            text-align: center;
            margin-top: 20px;
        }

        .logout a {
            text-decoration: none;
            color: rgb(24, 183, 0);
            font-weight: bold;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .logout a:hover {
            color: #bd2130;
        }

        .form-section {
            margin-top: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input,
        select,
        textarea {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 96%;
        }

        button {
            padding: 10px 20px;
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
        .back-link {
            display: inline-block;
            padding: 5px 20px;
            text-decoration: none;
            color: rgb(27, 161, 6);
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
    </div>
    <a class="back-link" href="../shop.php">← Back to Shop</a>
    <div class="container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?>!</h2>
        <div class="menu">

            <a href="manage_products.php">📋 Manage Products</a>
        </div>
        <div class="logout">
            <a href="logout.php">🔑 Logout</a>
        </div>
        <div class="form-section">
            <h3>Add New Item</h3>
            <form action="add_product_action.php" method="POST" enctype="multipart/form-data">

                <input type="text" name="product_name" placeholder="Product Name" required />

                <input type="number" name="product_price" placeholder="Price (e.g., 99)" required />

                <select name="category_id" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="file" name="product_image" accept="image/*" required />

                <textarea name="product_description" placeholder="Product Description" rows="4"></textarea>

                <button type="submit">➕ Add Product</button>
            </form>
        </div>
    </div>
</body>

</html>