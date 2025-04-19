<?php
require 'config.php';

if (isset($_GET['product_id'])) {
    $productId = intval($_GET['product_id']);
    // Updated SQL query to fetch category_name
    $stmt = $pdo->prepare("
        SELECT products.*, categories.name AS category_name 
        FROM products 
        LEFT JOIN categories ON products.category_id = categories.id 
        WHERE products.id = ?
    ");
    $stmt->execute([$productId]);
    $product = $stmt->fetch();

    // Fetch sub-images
    $subImagesStmt = $pdo->prepare("SELECT image FROM product_images WHERE product_id = ?");
    $subImagesStmt->execute([$productId]);
    $subImages = $subImagesStmt->fetchAll();

    if (!$product) {
        die("Product not found!");
    }
} else {
    die("No product ID provided.");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($product['name']) ?> - Certainmen</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

</head>

<body>
  <!-- Header -->
  <section id="header">
    <a href="#"><img src="img/logo.png" class="logo" alt="Logo" height="60" width="100" /></a>
    <div>
      <ul id="navbar">
        <li><a href="index.html">Home</a></li>
        <li><a class="active" href="shop.php">Shop</a></li>
        <li><a href="category.html">Category</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="contact.html">Contact</a></li>
        <li><a href="cart.html"><i class="fa-solid fa-bag-shopping"></i></a></li>
      </ul>
    </div>
  </section>

  <!-- Product Details -->
  <section id="prodetails" class="section-p1">
    <div class="single-pro-image">
      <img src="admin/uploads/<?= htmlspecialchars($product['image']) ?>" width="100%" id="MainImg" alt="Main Image" />
      <div class="small-image-group">
        <?php for ($i = 0; $i < 4; $i++): ?>
          <div class="small-img-col">
            <img src="admin/uploads/<?= htmlspecialchars($product['image']) ?>" width="100%" class="small-img" alt="" />
          </div>
        <?php endfor; ?>
      </div>
    </div>

    <div class="single-pro-details">
      <h6>Home / <?= htmlspecialchars($product['category_name']) ?></h6>
      <h4><?= htmlspecialchars($product['name']) ?></h4>
      <h2><?= htmlspecialchars($product['price']) ?> Taka</h2>
      <select>
        <option>Select Size</option>
        <option>S</option>
        <option>M</option>
        <option>L</option>
        <option>XL</option>
        <option>XXL</option>
      </select>
      <input type="number" value="1" min="1" />
      <button class="normal">Add To Cart</button>
      <h4>Product Details</h4>
      <span><?= htmlspecialchars($product['description']) ?></span>
    </div>
  </section>
  <!-- Featured Products Section -->
  <section id="product1" class="section-p1">
    <h2>Featured Products</h2>
    <p>Summer Collection New Modern Design</p>
    <div class="pro-container">
      <?php
      $stmt = $pdo->query("SELECT * FROM products WHERE featured = 1 LIMIT 4");
      while ($fp = $stmt->fetch()):
      ?>
        <div class="pro">
          <img src="admin/uploads/<?= htmlspecialchars($fp['image']) ?>" alt="<?= htmlspecialchars($fp['name']) ?>" />
          <div class="des">
            <span><?= htmlspecialchars($fp['brand'] ?? 'Brand') ?></span>
            <h5><?= htmlspecialchars($fp['name']) ?></h5>
            <div class="star">
              <i class="fas fa-star"></i><i class="fas fa-star"></i>
              <i class="fas fa-star"></i><i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h4><?= htmlspecialchars($fp['price']) ?> Taka</h4>
          </div>
          <a href="sproduct.php?product_id=<?= $fp['id'] ?>"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
      <?php endwhile; ?>
    </div>
  </section>
  <!-- newsletter section -->
  <section id="newsletter" class="section-p1 section-m1">
    <div class="newstext">
      <h4>Sign Up For Newsletters</h4>
      <p>
        Get E-mail updates about latest shop and <span>special offers</span>
      </p>
    </div>
    <div class="form">
      <input type="text" placeholder="Your email address" />
      <button class="normal">Sign Up</button>
    </div>
  </section>

  <!-- footer section -->
  <footer class="section-p1">
    <div class="col">
      <img class="logo" src="img/logo.png" alt="Certainmen Logo" />
      <h4>Contact</h4>
      <p><strong>Address:</strong> Road:06, Sector:09, Uttara Dhaka-1230</p>
      <p><strong>Phone:</strong> xxxxxxxxxxx</p>
      <p><strong>Hours:</strong> 10:00 - 18:00, Mon - Sat</p>
      <div class="follow">
        <h4>Follow Us</h4>
        <div class="icon">
          <i class="fa-brands fa-facebook"></i>
          <i class="fa-brands fa-twitter"></i>
          <i class="fa-brands fa-instagram"></i>
          <i class="fa-brands fa-youtube"></i>
          <i class="fa-brands fa-linkedin"></i>
        </div>
      </div>
    </div>

    <div class="col">
      <h4>About</h4>
      <a href="#">About Us</a>
      <a href="#">Delivery Information</a>
      <a href="#">Privacy Policy</a>
      <a href="#">Terms & Conditions</a>
      <a href="#">Contact Us</a>
    </div>

    <div class="col">
      <h4>My Account</h4>
      <a href="#">Sign In</a>
      <a href="#">View Cart</a>
      <a href="#">My Wishlist</a>
      <a href="#">Track My Order</a>
      <a href="#">Help</a>
    </div>
  </footer>

  <!-- Optional: Related Products -->
  <!-- Same HTML from your static page -->
  <script>
    // Replace main image with small image on click
    document.addEventListener("DOMContentLoaded", () => {
      const mainImg = document.getElementById("MainImg");
      const smallImgs = document.querySelectorAll(".small-img");

      smallImgs.forEach(img => {
        img.addEventListener("click", () => {
          mainImg.src = img.src;
        });
      });
    });
  </script>
  <script src="script.js"></script>
</body>

</html>