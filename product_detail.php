<?php
$pageTitle = 'Product Detail – Hudders Hub';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="View product details, reviews, and similar products at Hudders Hub Market.">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="product-detail-page">

<!-- Page-specific header matching the wireframe (Shop / Log Out instead of Login / Register) -->
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
      <a href="customer/shop.php" class="btn btn-outline">Shop</a>
      <a href="index.php" class="btn btn-dark">Log Out</a>
      <a href="customer/cart.php" class="cart-icon">🛒</a>
    </div>
  </div>
</header>

<!-- ====== MAIN PRODUCT SECTION ====== -->
<section class="product-detail-main">
  <div class="product-detail-container">

    <!-- Left: Product Image -->
    <div class="product-detail-image">
      <img src="assets/css/image/_ (14).jpeg" alt="Product Image">
    </div>

    <!-- Right: Product Info -->
    <div class="product-detail-info">
      <h1 class="product-detail-title">Product Name</h1>
      <p class="product-detail-price">Price:<strong>$300.00</strong></p>
      <div class="product-detail-stars">★★</div>
      <p class="product-detail-desc">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed malesuada nulla nec augue rhoncus, eget ullamcorper nulla ultricies. Fusce vulputate scelerisque est, ac venenatis nisi facilisis id. Vivamus vel massa eget velit sagittis blandit. Nullam condimentum ipsum nec purus fringilla blandit. Nullam condimentum ipsum nec purus finibus, ac mattis mauris malesuada. Fusce dignissim diam ut ligula tincidunt euismod. Proin ut mauris malesuada, placerat nulla sed, faucibus augue. Donec eget risus tellus. Phasellus euismod dui et lacus mollis ultricies. Mauris fringilla mauris libero, id pretium quam consequat nec. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.
      </p>
      <p class="product-detail-allergy">
        <strong>Allergy Information :</strong> Proin ut mauris malesuada, placerat nulla sed, faucibus augue.
      </p>
      <div class="product-detail-actions">
        <button class="product-detail-btn-cart">ADD TO CART</button>
        <button class="product-detail-btn-wishlist">ADD TO WISH LIST</button>
      </div>
    </div>

  </div>
</section>

<!-- ====== SIMILAR PRODUCTS ====== -->
<section class="product-detail-similar">
  <div class="product-detail-similar-inner">
    <h2 class="product-detail-section-heading">Similar Products</h2>

    <div class="product-detail-similar-grid">

      <!-- Card 1 -->
      <div class="product-detail-sim-card">
        <div class="product-detail-sim-img">
          <img src="assets/css/image/Mitho✨ - Yourartsyhub Photography_preview_rev_1.png" alt="Product">
        </div>
        <div class="product-detail-sim-body">
          <h3>Product name</h3>
          <p class="product-detail-sim-price">Price:<strong>$200</strong></p>
          <p class="product-detail-sim-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent interdum odio in massa sollicitudin, eu molestie risus faucibus…</p>
          <button class="product-detail-sim-cart-btn">🛒 ADD TO CART</button>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="product-detail-sim-card">
        <div class="product-detail-sim-img">
          <img src="assets/css/image/Please provide the original Pinterest title you would like me to reformat__preview_rev_1.png" alt="Product">
        </div>
        <div class="product-detail-sim-body">
          <p class="product-detail-sim-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent interdum odio in massa sollicitudin, eu molestie risus faucibus…</p>
          <button class="product-detail-sim-cart-btn">🛒 ADD TO CART</button>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="product-detail-sim-card">
        <div class="product-detail-sim-img">
          <img src="assets/css/image/___preview_rev_1.png" alt="Product">
        </div>
        <div class="product-detail-sim-body">
          <p class="product-detail-sim-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent interdum odio in massa sollicitudin, eu molestie risus faucibus…</p>
          <button class="product-detail-sim-cart-btn">🛒 ADD TO CART</button>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ====== PRODUCT REVIEWS ====== -->
<section class="product-detail-reviews">
  <div class="product-detail-reviews-inner">
    <h2 class="product-detail-section-heading">Product Reviews</h2>

    <!-- Review 1 -->
    <div class="product-detail-review-card">
      <div class="product-detail-review-header">
        <div>
          <h4 class="product-detail-reviewer">Rachana Aryal</h4>
          <div class="product-detail-review-stars">★★★</div>
        </div>
        <span class="product-detail-review-date">Date of review</span>
      </div>
      <p class="product-detail-review-text">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed malesuada nulla nec augue rhoncus, eget ullamcorper nulla ultricies. Fusce vulputate scelerisque est, ac venenatis nisi facilisis id. Vivamus vel massa eget velit sagittis blandit. Nullam condimentum ipsum nec purus finibus, ac mattis mauris malesuada. Fusce dignissim diam ut ligula tincidunt euismod. Proin ut mauris malesuada, placerat nulla sed, faucibus augue. Donec eget risus tellus. Phasellus euismod dui et lacus mollis ultricies.
      </p>
    </div>

    <!-- Review 2 -->
    <div class="product-detail-review-card">
      <div class="product-detail-review-header">
        <div>
          <h4 class="product-detail-reviewer">Smriti Shrestha</h4>
          <div class="product-detail-review-stars">★★★</div>
        </div>
        <span class="product-detail-review-date">Date of review</span>
      </div>
      <p class="product-detail-review-text">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed malesuada nulla nec augue rhoncus, eget ullamcorper nulla ultricies. Fusce vulputate scelerisque est, ac venenatis nisi facilisis id. Vivamus vel massa eget velit sagittis blandit. Nullam condimentum ipsum nec purus finibus, ac mattis mauris malesuada. Fusce dignissim diam ut ligula tincidunt euismod. Proin ut mauris malesuada, placerat nulla sed. Donec eget risus tellus. Phasellus euismod dui et lacus mollis ultricies.
      </p>
    </div>

  </div>
</section>

<?php include 'include/footer.php'; ?>
