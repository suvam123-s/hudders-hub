<?php
$pageTitle = 'User Profile – Hudders Hub';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Manage your Hudders Hub profile, view recent purchases, and update your account.">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="profile-page">

  <!-- Page-specific header matching the wireframe (USER icon, Shop, Log Out) -->
  <header class="site-header">
    <div class="header-inner">
      <!-- Logo -->
      <div class="logo">
        <a href="index.php">
          <img src="assets/css/image/logo.png" alt="Hudders Hub Logo">
        </a>
      </div>

      <!-- Search -->
      <form class="search-form" action="customer/shop.php" method="get">
        <input type="text" name="q" placeholder="Search Product">
        <button type="submit">🔍</button>
      </form>

      <!-- Header Actions -->
      <div class="header-actions">
        <a href="user_profile.php" class="profile-header-user">
          <span class="profile-header-user-icon">👤</span>
          <span class="profile-header-user-label">USER</span>
        </a>
        <a href="customer/shop.php" class="btn btn-outline">Shop</a>
        <a href="index.php" class="btn btn-dark">Log Out</a>
        <a href="customer/cart.php" class="cart-icon">🛒</a>
      </div>
    </div>
  </header>

  <!-- ====== PROFILE SECTION ====== -->
  <section class="profile-section">

    <!-- Decorative leaves on the right -->
    <div class="profile-leaves">
      <img src="assets/css/image/leaves.g" alt="Decorative leaves">
    </div>

    <div class="profile-content">

      <!-- Avatar -->
      <div class="profile-avatar">
        <div class="profile-avatar-circle"></div>
      </div>

      <!-- User Info -->
      <p class="profile-email">username123@gmail.com</p>
      <p class="profile-phone">+977-9823123456</p>

      <!-- Action Buttons -->
      <div class="profile-buttons">
        <button class="profile-btn-update">UPDATE</button>
        <button class="profile-btn-logout">LOG OUT</button>
      </div>
    </div>
  </section>

  <!-- ====== RECENT PURCHASES ====== -->
  <section class="profile-purchases">
    <div class="profile-purchases-inner">
      <h2 class="profile-section-heading">Recent Purchases</h2>

      <!-- Purchase Card 1 -->
      <div class="profile-purchase-card">
        <div class="profile-purchase-img">
          <div class="profile-purchase-img-placeholder"></div>
        </div>
        <div class="profile-purchase-info">
          <h3 class="profile-purchase-name">Product name</h3>
          <p class="profile-purchase-price">Price:<strong>$200</strong></p>
          <p class="profile-purchase-desc">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed malesuada nulla nec augue rhoncus, eget
            ullamcorper nulla ultricies. Fusce vulputate scelerisque est, ac venenatis nisi facilisis id. Vivamus vel
            massa eget velit sagittis blandit. Nullam condimentum ipsum nec purus finibus, ac mattis mauris malesuada.
            Fusce dignissim diam ut ligula tincidunt euismod. Proin ut mauris malesuada, placerat nulla sed, faucibus
            augue. Donec eget risus tellus. Phasellus euismod dui et lacus mollis ultricies.
          </p>
          <div class="profile-purchase-meta">
            <span>012-345-678-901-23</span>
            <span>Quantity : 12</span>
          </div>
        </div>
        <div class="profile-purchase-action">
          <button class="profile-review-btn">REVIEW</button>
        </div>
      </div>

      <!-- Purchase Card 2 -->
      <div class="profile-purchase-card">
        <div class="profile-purchase-img">
          <div class="profile-purchase-img-placeholder"></div>
        </div>
        <div class="profile-purchase-info">
          <h3 class="profile-purchase-name">Product name</h3>
          <p class="profile-purchase-price">Price:<strong>$200</strong></p>
          <p class="profile-purchase-desc">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed malesuada nulla nec augue rhoncus, eget
            ullamcorper nulla ultricies. Fusce vulputate scelerisque est, ac venenatis nisi facilisis id. Vivamus vel
            massa eget velit sagittis blandit. Nullam condimentum ipsum nec purus finibus, ac mattis mauris malesuada.
            Fusce dignissim diam ut ligula tincidunt euismod. Proin ut mauris malesuada, placerat nulla sed, faucibus
            augue. Donec eget risus tellus. Phasellus euismod dui et lacus mollis ultricies.
          </p>
          <div class="profile-purchase-meta">
            <span>012-345-678-901-23</span>
            <span>Quantity : 12</span>
          </div>
        </div>
        <div class="profile-purchase-action">
          <button class="profile-review-btn">REVIEW</button>
        </div>
      </div>

      <!-- Purchase Card 3 -->
      <div class="profile-purchase-card">
        <div class="profile-purchase-img">
          <div class="profile-purchase-img-placeholder"></div>
        </div>
        <div class="profile-purchase-info">
          <h3 class="profile-purchase-name">Product name</h3>
          <p class="profile-purchase-price">Price:<strong>$200</strong></p>
          <p class="profile-purchase-desc">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed malesuada nulla nec augue rhoncus, eget
            ullamcorper nulla ultricies. Fusce vulputate scelerisque est, ac venenatis nisi facilisis id. Vivamus vel
            massa eget velit sagittis blandit. Nullam condimentum ipsum nec purus finibus, ac mattis mauris malesuada.
            Fusce dignissim diam ut ligula tincidunt euismod. Proin ut mauris malesuada, placerat nulla sed, faucibus
            augue. Donec eget risus tellus. Phasellus euismod dui et lacus mollis ultricies.
          </p>
          <div class="profile-purchase-meta">
            <span>012-345-678-901-23</span>
            <span>Quantity : 12</span>
          </div>
        </div>
        <div class="profile-purchase-action">
          <button class="profile-review-btn">REVIEW</button>
        </div>
      </div>

    </div>
  </section>

  <?php include 'include/footer.php'; ?>