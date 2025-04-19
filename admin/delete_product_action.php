<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

require 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // First, delete the image file if needed (optional but recommended)
    $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();
    if ($product && file_exists("uploads/" . $product['image'])) {
        unlink("uploads/" . $product['image']);
    }

    // Now delete the product from the database
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: manage_products.php");
exit();
?>
