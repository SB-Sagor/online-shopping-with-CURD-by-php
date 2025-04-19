<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

require 'config.php';

$name = $_POST['product_name'];
$price = $_POST['product_price'];
$category_id = $_POST['category_id'];
$description = $_POST['product_description'];

$image = $_FILES['product_image'];

// Sanitize file name
$originalName = preg_replace("/[^A-Za-z0-9.\-_]/", "", $image['name']);
$imageName = time() . '_' . basename($originalName);

$uploadDir = 'uploads/';
$targetPath = $uploadDir . $imageName;

// Create uploads folder if not exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (move_uploaded_file($image['tmp_name'], $targetPath)) {
    $stmt = $pdo->prepare("INSERT INTO products (name, price, category_id, image, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $price, $category_id, $imageName, $description]);
    echo "✅ Product added successfully. <a href='dashboard.php'>🔙 Go Back</a>";
} else {
    echo "❌ Failed to upload image.";
}
?>
