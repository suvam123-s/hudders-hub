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

<?php if (!empty($isAuthPage)): ?>
      <!-- Auth page: show only Contact Us -->
      <a href="contactus.php" class="btn btn-header">Contact Us</a>

<?php else: ?>
      <!-- Normal pages: USER dropdown + Shop + Cart -->
      <div class="user-dropdown-wrap" id="userDropdownWrap">
        <button class="user-dropdown-trigger" id="userDropdownBtn" onclick="toggleUserDropdown()" aria-expanded="false">
          <i class="fas fa-user-circle"></i>
          <span><?= isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'USER' ?></span>
          <i class="fas fa-chevron-down dropdown-arrow"></i>
        </button>
        <div class="user-dropdown-menu" id="userDropdownMenu">
          <a href="user_profile.php" class="user-dropdown-item">
            <i class="fas fa-user-edit"></i>
            <span>Update Profile</span>
          </a>
          <div class="user-dropdown-divider"></div>
          <a href="logout.php" class="user-dropdown-item user-dropdown-logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
          </a>
        </div>
      </div>

      <a href="shop.php" class="btn btn-header">Shop</a>
      <a href="cart.php" class="cart-icon" title="Your Cart">
        <i class="fas fa-shopping-cart"></i>
        <?php if ($cart_count > 0): ?>
          <span class="cart-badge" id="cartBadge"><?= $cart_count ?></span>
        <?php else: ?>
          <span class="cart-badge" id="cartBadge" style="display:none;">0</span>
        <?php endif; ?>
      </a>

      <script>
      function toggleUserDropdown() {
        const wrap = document.getElementById('userDropdownWrap');
        const btn  = document.getElementById('userDropdownBtn');
        const open = wrap.classList.toggle('open');
        btn.setAttribute('aria-expanded', open);
      }
      document.addEventListener('click', function(e) {
        const wrap = document.getElementById('userDropdownWrap');
        if (wrap && !wrap.contains(e.target)) {
          wrap.classList.remove('open');
          document.getElementById('userDropdownBtn').setAttribute('aria-expanded', 'false');
        }
      });
      </script>

<?php endif; ?>

    </div>

  </div>
</header>
