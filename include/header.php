<?php
$pageTitle = $pageTitle ?? 'Hudders Hub Market';
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

    <!-- Logo -->
    <div class="logo">
      <a href="index.php">
        <img src="assets/css/image/logo.png" alt="Hudders Hub Logo">
      </a>
    </div>

    <!-- Search -->
    <form class="search-form" action="shop.php" method="get">
      <input type="text" name="q" placeholder="Search Product">
      <button type="submit"><i class="fas fa-search"></i></button>
    </form>

    <!-- Header Actions -->
    <div class="header-actions">
      <a href="shop.php" class="btn btn-header">Shop</a>
      <a href="logout.php" class="btn btn-header">Log Out</a>
      <a href="cart.php" class="cart-icon"><i class="fas fa-shopping-cart"></i></a>
    </div>

  </div>
</header>
