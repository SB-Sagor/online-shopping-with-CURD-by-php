<?php
require 'config.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['category_name'];
    $description = $_POST['category_description'];

    // Insert the category into the database
    $stmt = $pdo->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
    if ($stmt->execute([$name, $description])) {
        echo "✅ Category added successfully!";
    } else {
        echo "❌ Failed to add category!";
    }

    // Redirect back to the category management page (optional)
    header("Location: category_management.php");
    exit();
}
?>
