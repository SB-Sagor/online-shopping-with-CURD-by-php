<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

require 'config.php';

if (!isset($_GET['id'])) {
    header("Location: manage_products.php");
    exit();
}

$id = $_GET['id'];
$product = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$product->execute([$id]);
$product = $product->fetch();

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

if (!$product) {
    echo "Product not found.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            padding: 20px;
        }

        .form-container {
            background: white;
            padding: 20px;
            max-width: 600px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }

        button {
            padding: 10px 20px;
            background: #28a745;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Product</h2>
        <form action="update_product_action.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $product['id'] ?>">

            <label>Product Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

            <label>Price:</label>
            <input type="number" name="price" value="<?= $product['price'] ?>" required>

            <label>Category:</label>
            <select name="category_id" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Current Image:</label><br>
            <img src="uploads/<?= htmlspecialchars($product['image']) ?>" width="100"><br>

            <label>Upload New Image (optional):</label>
            <input type="file" name="image">

            <label>Description:</label>
            <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea>

            <button type="submit">Update Product</button>
        </form>
    </div>
</body>
</html>
