<?php
require 'config.php';

if (isset($_GET['product_id'])) {
  $productId = intval($_GET['product_id']);

  // Get current product info with category
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

  // ✅ Add this block to fetch other products for "Featured Products" section
  $featuredStmt = $pdo->prepare(
    "
    SELECT * FROM products 
    WHERE id != ? 
    LIMIT 4"
  );

  $featuredStmt->execute([$productId]);
  $products = $featuredStmt->fetchAll();

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
  <style>
    /* Responsive navbar */
    .hamburger {
      display: none;
      font-size: 24px;
      cursor: pointer;
    }

    .drawer {
      display: none;
      position: fixed;
      top: 0;
      right: -250px;
      height: 100%;
      width: 250px;
      background-color: #fff;
      box-shadow: -2px 0 5px rgba(0, 0, 0, 0.3);
      transition: right 0.3s ease;
      z-index: 1000;
      padding: 20px;
    }

    .drawer ul {
      list-style: none;
      padding: 0;
    }

    .drawer ul li {
      margin: 20px 0;
    }

    .drawer ul li a {
      text-decoration: none;
      color: #333;
      font-size: 18px;
    }

    .drawer.open {
      right: 0;
    }

    /* Responsive rules */
    @media (max-width: 768px) {
      .filter {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1rem;
        border-radius: 8px;
      }

      .filter-group {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 0.3rem;
      }

      .filter-group label {
        font-weight: bold;
        font-size: 12px;
        color: #333;
      }

      .filter-group select {
        padding: 0.2rem;
        font-size: 12px;
        border-radius: 5px;
        border: 1px solid #ccc;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: border-color 0.3s ease;
      }

      .filter-group select:hover {
        border-color: rgb(11, 207, 4);
      }

      button.normal {
        background-color: rgb(8, 147, 27);
        color: white;
        border: none;
        padding: 0.3rem 0.5rem;
        border-radius: 5px;
        font-size: 12px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
      }

      button.normal:hover {
        background-color: rgb(10, 204, 42);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
      }

      #navbar {
        display: none;
      }

      .hamburger {
        display: block;
      }

      .drawer {
        display: block;
      }
    }
  </style>
</head>

<body>
  <!-- Header Section -->
  <section id="header">
    <a href="#"><img src="img/logo.png" class="logo" alt="Certainmen Logo" height="60" width="100" /></a>

    <!-- Hamburger menu for small screens -->
    <div class="hamburger" onclick="toggleDrawer()">
      <i class="fas fa-bars"></i>
    </div>

    <!-- Normal navbar for large screens -->
    <ul id="navbar">
      <li><a href="index.php">Home</a></li>
      <li><a class="active" href="shop.php">Shop</a></li>
      <li><a href="#"><i class="fa-solid fa-bag-shopping"></i></a></li>
    </ul>
  </section>

  <!-- Drawer menu for mobile -->
  <div id="drawer" class="drawer">
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a class="active" href="shop.php">Shop</a></li>
      <li><a href="#">Cart</a></li>
    </ul>
  </div>


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
      <?php foreach ($products as $product): ?>
        <div class="pro">
          <img src="admin/uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
          <div class="des">
            <span>Category</span>
            <h5><?php echo htmlspecialchars($product['name']); ?></h5>
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <h4><?php echo number_format($product['price'], 2); ?> Taka</h4>
          </div>
          <a href="shop.php"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
      <?php endforeach; ?>
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
    function toggleDrawer() {
      const drawer = document.getElementById("drawer");
      drawer.classList.toggle("open");
    }

    // Close drawer when clicking outside
    window.addEventListener("click", function(e) {
      const drawer = document.getElementById("drawer");
      const hamburger = document.querySelector(".hamburger");
      if (!drawer.contains(e.target) && !hamburger.contains(e.target)) {
        drawer.classList.remove("open");
      }
    });
  </script>

  <script src="script.js"></script>
</body>

</html>