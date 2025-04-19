<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

require 'config.php';

// Fetch products with category name
$sql = "SELECT p.id, p.name, p.price, p.image, c.name AS category 
        FROM products p 
        JOIN categories c ON p.category_id = c.id 
        ORDER BY p.id DESC";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            padding: 20px;
        }

        .header {
            background: #2c3e50;
            color: white;
            padding: 15px;
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background:rgb(3, 171, 31);
            color: white;
        }

        img {
            max-width: 80px;
            height: auto;
            border-radius: 5px;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            color: white;
            transition: background 0.3s ease;
        }

        .btn-edit {
            background: #28a745;
        }

        .btn-edit:hover {
            background: #218838;
        }

        .btn-delete {
            background: #dc3545;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color:rgb(27, 161, 6);
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Manage Products</h2>
    </div>

    <a class="back-link" href="dashboard.php">← Back to Dashboard</a>

    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price ($)</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><img src="uploads/<?= htmlspecialchars($product['image']) ?>" alt="Image"></td>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['price']) ?></td>
                        <td><?= htmlspecialchars($product['category']) ?></td>
                        <td>
                            <a class="btn btn-edit" href="edit_product.php?id=<?= $product['id'] ?>">✏️ Edit</a>
                            <a class="btn btn-delete" href="delete_product_action.php?id=<?= $product['id'] ?>" onclick="return confirm('Are you sure you want to delete this product?');">🗑️ Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="5">No products found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
