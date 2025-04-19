<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}

require 'config.php';

// Fetch all categories for dropdown
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

// Initialize sorting filters
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'all';
$selectedRange = isset($_GET['range']) ? $_GET['range'] : 'default';

// Construct query with dynamic filters
$query = "SELECT products.*, categories.name AS category_name FROM products LEFT JOIN categories ON products.category_id = categories.id WHERE 1=1";

if ($selectedCategory !== 'all') {
  $query .= " AND categories.id = :category_id";
}

if ($selectedRange === 'lowToHigh') {
  $query .= " ORDER BY products.price ASC";
} elseif ($selectedRange === 'highToLow') {
  $query .= " ORDER BY products.price DESC";
}

$stmt = $pdo->prepare($query);

// Bind the category parameter if selected
if ($selectedCategory !== 'all') {
  $stmt->bindParam(':category_id', $selectedCategory, PDO::PARAM_INT);
}

$stmt->execute();
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Certainmen</title>

  <link rel="stylesheet" href="style.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />
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

  <!-- Banner Section -->
  <section id="page-header">
    <h2>#Stayhome</h2>
    <p>Your satisfaction is our priority</p>
  </section>
  <!-- Filter Section -->
  <section class="filter section-p1">
    <form method="GET" action="shop.php">
      <!-- category section -->
      <div class="filter-group">
        <label for="category">Category:</label>
        <select id="category" name="category">
          <option value="all" <?= $selectedCategory === 'all' ? 'selected' : '' ?>>All</option>
          <?php foreach ($categories as $category): ?>
            <option value="<?= $category['id'] ?>" <?= $selectedCategory == $category['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($category['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
        <!-- sort by price settion -->
        <div class="filter-group">
          <label for="range">Sort by Price:</label>
          <select id="range" name="range">
            <option value="default" <?= $selectedRange === 'default' ? 'selected' : '' ?>>Default</option>
            <option value="lowToHigh" <?= $selectedRange === 'lowToHigh' ? 'selected' : '' ?>>Low to High</option>
            <option value="highToLow" <?= $selectedRange === 'highToLow' ? 'selected' : '' ?>>High to Low</option>
          </select>
        </div>
        <!-- button section -->
        <button type="submit" class="normal">Apply Filters</button>

      </div>
    </form>
  </section>
  <!-- Product Section -->
  <section id="product1" class="section-p1">
    <h2>All Products</h2>
    <div class="pro-container">
      <?php if (count($products) > 0): ?>
        <?php foreach ($products as $product): ?>

          <div class="pro">
            <img src="admin/uploads/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" />

            <div class="des">
              <span><?= htmlspecialchars($product['category_name'] ?? 'No Category') ?></span>
              <h5><?= htmlspecialchars($product['name']) ?></h5>
              <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
              <h4><?= htmlspecialchars($product['price']) ?> Taka</h4>
            </div>
            <a href="sproduct.php?product_id=<?= $product['id'] ?>">
              <i class="fa-solid fa-cart-shopping"></i>
            </a>
          </div>

        <?php endforeach; ?>
      <?php else: ?>
        <p>No products found for the selected filters.</p>
      <?php endif; ?>
    </div>
  </section>
  <!-- Newsletter Section -->
  <section id="newsletter" class="section-p1 section-m1">
    <div class="newstext">
      <h4>Sign Up For Newsletters</h4>
      <p>
        Get E-mail updates about letest shop and <span>spacial offers.</span>
      </p>
    </div>
    <div class="form">
      <input type="text" placeholder="Your email address" />
      <button class="normal">Sign Up</button>
    </div>
  </section>
  <!-- Footer Section -->
  <footer class="section-p1">
    <div class="col">
      <img class="logo" src="img/logo.png" alt="" />
      <h4>Contact</h4>
      <p><strong>Address:</strong> Road:06,Sector:09,Uttara Dhaka-1230</p>
      <p><strong>Phone:</strong> xxxxxxxxxxx</p>
      <p><strong>Hours:</strong> 10:00-18:00,Mon - Sat</p>
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
      <a href="#">Delivary Information</a>
      <a href="#">Privacy Policy</a>
      <a href="#">Terms & Condition</a>
      <a href="#">Contact Us</a>
    </div>
    <div class="col">
      <h4>My Account</h4>
      <a href="#">Sign in</a>
      <a href="#">view cart</a>
      <a href="#">My wishlist</a>
      <a href="#">Track My Order</a>
      <a href="#">Help</a>
    </div>
  </footer>
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