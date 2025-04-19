<?php
// Include database connection
include 'config.php';

try {
  // Fetch products from the database using PDO
  $stmt = $pdo->query("SELECT * FROM products");

  // Fetch all products into an associative array
  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  // Handle query errors
  die('Error fetching products: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Certainmen</title>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="style.css" />
  <style>
    /* Hide drawer by default */
    .side-drawer {
      position: fixed;
      top: 0;
      right: -250px;
      width: 250px;
      height: 100vh;
      background-color: #fff;
      box-shadow: -2px 0 5px rgba(0, 0, 0, 0.3);
      transition: right 0.3s ease;
      z-index: 1000;
      padding: 20px;
    }

    .side-drawer.open {
      right: 0;
    }

    .side-drawer .close-btn {
      font-size: 30px;
      cursor: pointer;
      position: absolute;
      top: 15px;
      right: 20px;
    }

    .side-drawer ul {
      list-style: none;
      padding: 60px 0 0 0;
    }

    .side-drawer ul li {
      margin: 20px 0;
    }

    .side-drawer ul li a {
      text-decoration: none;
      color: #333;
      font-size: 18px;
    }

    .hamburger {
      display: none;
      font-size: 26px;
      cursor: pointer;
      padding: 10px;
    }

    /* Show hamburger on smaller screens */
    @media (max-width: 768px) {
      .hamburger {
        display: block;
      }

      #navbar {
        display: none;
      }
    }
  </style>
</head>

<body>

  <section id="header">
    <a href="#"><img src="img/logo.png" class="logo" alt="Certainmen Logo" height="60" width="100" /></a>

    <!-- Hamburger for small screen -->
    <div id="menu-toggle" class="hamburger">
      <i class="fa-solid fa-bars"></i>
    </div>
    <ul id="navbar">
      <li><a class="active" href="index.php">Home</a></li>
      <li><a href="shop.php">Shop</a></li>
      <li><a href="#"><i class="fa-solid fa-bag-shopping"></i></a></li>
    </ul>
    <!-- Side drawer -->
    <div id="drawer" class="side-drawer">
      <span id="close-drawer" class="close-btn">&times;</span>
      <ul>
        <li><a class="active" href="index.php">Home</a></li>
        <li><a href="shop.php">Shop</a></li>
        <li><a href="#"><i class="fa-solid fa-bag-shopping"></i> Cart</a></li>
      </ul>
    </div>
  </section>


  <section id="hero">
    <h4>Welcome to Certainmen</h4>
    <h1>Discover the Best Products</h1>
    <p>Your satisfaction is our priority</p>
    <a href="shop.php"><button id="btn">Shop Now</button></a>
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
          <a href="#"><i class="fa-solid fa-cart-shopping"></i></a>
        </div>
      <?php endforeach; ?>
    </div>
  </section>


  <section id="banner" class="section-m1">
    <h4>Welcome</h4>
    <h2>Up to <span>30% off</span></h2>
    <button id="explore" class="normal" onclick="window.location.href = 'shop.php';">Explore More</button>
  </section>

  <section id="newsletter" class="section-p1 section-m1">
    <div class="newstext">
      <h4>Follow Us For Newsletters</h4>
      <p>Our new products in Facebook <span>special offers.</span></p>
    </div>
    <div class="form">
      <input type="text" placeholder="Follow us on Facebook" />
      <button id="btn1" class="normal" onclick="window.location.href = 'https://www.facebook.com/profile.php?id=61550240033766';">Facebook</button>
    </div>
  </section>

  <footer class="section-p1">
    <div class="col">
      <img class="logo" src="img/logo.png" alt="" />
      <h4>Contact</h4>
      <p><strong>Address:</strong> Road:06,Sector:09,Uttara Dhaka-1230</p>
      <p><strong>Phone:</strong> xxxxxxxxxxx</p>
      <p><strong>Hours:</strong> 10:00-18:00, Mon - Sat</p>
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
      <a href="#">Sign in</a>
      <a href="#">View cart</a>
      <a href="#">My wishlist</a>
      <a href="#">Track My Order</a>
      <a href="#">Help</a>
    </div>
  </footer>
  <script>
    const toggle = document.getElementById('menu-toggle');
    const drawer = document.getElementById('drawer');
    const closeBtn = document.getElementById('close-drawer');

    toggle.addEventListener('click', () => {
      drawer.classList.add('open');
    });

    closeBtn.addEventListener('click', () => {
      drawer.classList.remove('open');
    });

    // Optional: Close drawer on clicking outside
    window.addEventListener('click', (e) => {
      if (!drawer.contains(e.target) && !toggle.contains(e.target)) {
        drawer.classList.remove('open');
      }
    });
  </script>

  <script src="script.js"></script>

</body>

</html>

<?php
// Close database connection
// mysqli_close($conn);
// 
?>