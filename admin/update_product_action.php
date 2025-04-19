<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $description = $_POST['description'];

    // Fetch the current product to get the old image
    $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();

    if (!$product) {
        echo "Product not found.";
        exit();
    }

    $imageName = $product['image']; // default to old image

    // Handle image upload if there's a new one
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        $imageName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $imageName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                // Delete old image file if exists
                if (!empty($product['image']) && file_exists("uploads/" . $product['image'])) {
                    unlink("uploads/" . $product['image']);
                }
            } else {
                echo "Failed to upload new image.";
                exit();
            }
        } else {
            echo "Invalid image format.";
            exit();
        }
    }

    // Update product in the database
    $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, category_id = ?, image = ?, description = ? WHERE id = ?");
    $stmt->execute([$name, $price, $category_id, $imageName, $description, $id]);

    header("Location: manage_products.php");
    exit();
} else {
    echo "Invalid request.";
}
?>
