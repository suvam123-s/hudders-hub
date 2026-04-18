<?php
$pageTitle = $pageTitle ?? 'Hudders Hub Market';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="site-header">
  <div class="header-inner">

    <!-- Logo -->
    <div class="logo">
      <img src="assets/css/image/logo.png" alt="Hudders Hub Logo">
      <div class="logo-text">
        <span class="logo-main">HUDDERS HUB MARKET</span>
        <span class="logo-sub">Fresh Local Produce</span>
      </div>
    </div>

    <!-- Search -->
    <form class="search-form" action="customer/shop.php" method="get">
      <input type="text" name="q" placeholder="Search Product">
      <button type="submit">🔍</button>
    </form>

    <!-- Header Actions -->
    <div class="header-actions">
      <a href="login.php" class="btn btn-outline">Login</a>
      <a href="register.php" class="btn btn-dark">Register</a>
      <div class="cart-icon">🛒</div>
    </div>

  </div>
</header>
