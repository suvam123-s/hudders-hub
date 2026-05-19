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

<!-- Mobile nav overlay -->
<div class="mobile-nav-overlay" id="mobileNavOverlay" onclick="closeMobileNav()" aria-hidden="true"></div>
<nav class="mobile-nav" id="mobileNav" aria-label="Mobile navigation">
  <div class="mobile-nav-inner">
    <a href="index.php" class="mobile-nav-item"><i class="fas fa-home"></i> Home</a>
    <a href="shop.php" class="mobile-nav-item"><i class="fas fa-store"></i> Shop</a>
    <a href="aboutus.php" class="mobile-nav-item"><i class="fas fa-info-circle"></i> About Us</a>
    <a href="contactus.php" class="mobile-nav-item"><i class="fas fa-envelope"></i> Contact</a>
    <?php if (isset($_SESSION['user_id'])): ?>
    <a href="user_profile.php" class="mobile-nav-item"><i class="fas fa-user"></i> Profile</a>
    <a href="cart.php" class="mobile-nav-item"><i class="fas fa-shopping-cart"></i> Cart <?php if($cart_count > 0): ?><span class="mobile-cart-badge"><?= $cart_count ?></span><?php endif; ?></a>
    <a href="logout.php" class="mobile-nav-item mobile-nav-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    <?php else: ?>
    <a href="Login.php" class="mobile-nav-item"><i class="fas fa-sign-in-alt"></i> Login</a>
    <a href="Register.php" class="mobile-nav-item"><i class="fas fa-user-plus"></i> Register</a>
    <?php endif; ?>
  </div>
</nav>

<header class="site-header">
  <div class="header-inner">

    <!-- Logo — links to home -->
    <div class="logo">
      <a href="index.php" title="Go to Homepage">
        <img src="assets/css/image/logo.png" alt="Hudders Hub Logo">
      </a>
    </div>

    <!-- Right side: Search + Actions grouped together -->
    <div class="header-right">

      <!-- Header Actions (search moved inside to sit beside Login/Register) -->
      <div class="header-actions">

        <!-- Search — submits to shop.php -->
        <form class="search-form" action="shop.php" method="get">
          <input type="text" name="q" placeholder="Search Product" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
          <button type="submit"><i class="fas fa-search"></i></button>
        </form>

<?php if (!empty($isAuthPage)): ?>
        <!-- Auth page: show only Contact Us -->
        <a href="contactus.php" class="btn btn-header">Contact Us</a>

<?php elseif (isset($_SESSION['user_id'])): ?>
        <!-- Logged-in: show user dropdown + Cart -->
        <div class="user-dropdown-wrap" id="userDropdownWrap">
          <button class="user-dropdown-trigger" id="userDropdownBtn" onclick="toggleUserDropdown()" aria-expanded="false">
            <i class="fas fa-user-circle"></i>
            <span><?= htmlspecialchars($_SESSION['user_name'] ?? 'Account') ?></span>
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

        <a href="wishlist.php" class="cart-icon" title="Your Wishlist" style="margin-right: 15px;">
          <i class="fas fa-heart"></i>
        </a>
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

<?php else: ?>
        <!-- Guest: show Login + Register + Cart -->
        <a href="Login.php" class="btn btn-header btn-login">Login</a>
        <a href="Register.php" class="btn btn-header btn-register">Register</a>

        <a href="wishlist.php" class="cart-icon" title="Your Wishlist" style="margin-right: 15px;">
          <i class="fas fa-heart"></i>
        </a>
        <a href="cart.php" class="cart-icon" title="Your Cart">
          <i class="fas fa-shopping-cart"></i>
          <?php if ($cart_count > 0): ?>
            <span class="cart-badge" id="cartBadge"><?= $cart_count ?></span>
          <?php else: ?>
            <span class="cart-badge" id="cartBadge" style="display:none;">0</span>
          <?php endif; ?>
        </a>

<?php endif; ?>

      </div>

    </div>

    <!-- Hamburger button (mobile only) -->
    <button class="hamburger" id="hamburgerBtn" onclick="toggleMobileNav()" aria-label="Open menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>

  </div>
</header>

<script>
function toggleMobileNav() {
  const nav     = document.getElementById('mobileNav');
  const overlay = document.getElementById('mobileNavOverlay');
  const btn     = document.getElementById('hamburgerBtn');
  const open    = nav.classList.toggle('open');
  overlay.classList.toggle('open', open);
  btn.classList.toggle('is-open', open);
  btn.setAttribute('aria-expanded', open);
  document.body.style.overflow = open ? 'hidden' : '';
}
function closeMobileNav() {
  const nav     = document.getElementById('mobileNav');
  const overlay = document.getElementById('mobileNavOverlay');
  const btn     = document.getElementById('hamburgerBtn');
  nav.classList.remove('open');
  overlay.classList.remove('open');
  btn.classList.remove('is-open');
  btn.setAttribute('aria-expanded', 'false');
  document.body.style.overflow = '';
}
</script>