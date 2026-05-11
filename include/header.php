<?php
$pageTitle = $pageTitle ?? 'Hudders Hub Market';
if (session_status() === PHP_SESSION_NONE) session_start();
$cart_count = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<header class="site-header">
  <div class="header-inner">

    <!-- Logo — links to home -->
    <div class="logo">
      <a href="index.php" title="Go to Homepage">
        <img src="assets/css/image/logo.png" alt="Hudders Hub Logo">
      </a>
    </div>

    <!-- Search — submits to shop.php -->
    <form class="search-form" action="shop.php" method="get">
      <input type="text" name="q" placeholder="Search Product" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
      <button type="submit"><i class="fas fa-search"></i></button>
    </form>

    <!-- Header Actions -->
    <div class="header-actions">
      <a href="user_profile.php" class="header-user-link" title="Your Profile">
        <i class="fas fa-user-circle"></i>
        <span><?= isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'USER' ?></span>
      </a>
      <a href="shop.php" class="btn btn-header">Shop</a>
      <a href="Login.php" class="btn btn-header">Log Out</a>
      <a href="cart.php" class="cart-icon" title="Your Cart">
        <i class="fas fa-shopping-cart"></i>
        <?php if ($cart_count > 0): ?>
          <span class="cart-badge" id="cartBadge"><?= $cart_count ?></span>
        <?php else: ?>
          <span class="cart-badge" id="cartBadge" style="display:none;">0</span>
        <?php endif; ?>
      </a>
    </div>

  </div>
</header>
