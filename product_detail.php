<?php
session_start();

if (!isset($_SESSION['cart']))
  $_SESSION['cart'] = [];
if (!isset($_SESSION['wishlist']))
  $_SESSION['wishlist'] = [];

// ── Product Data (same master catalog as shop) ──
$products = [
  1 => [
    'name' => 'Orange',
    'price' => 1.49,
    'image' => 'assets/css/image/orange.jpg',
    'rating' => 3.5,
    'desc' => 'Fresh organic oranges sourced from local farms in Cleckhudderfax. Rich in Vitamin C and perfect for juicing, snacking, or cooking. Our oranges are hand-picked at peak ripeness to ensure the best taste and nutritional value. Each orange is carefully inspected for quality before making it to our shelves.',
    'allergy' => 'No known allergens. However, please wash thoroughly before consumption.',
    'category' => 'grocery',
    'old_price' => null,
  ],
  2 => [
    'name' => 'Banana',
    'price' => 1.29,
    'image' => 'assets/css/image/bannan.png',
    'rating' => 4.5,
    'desc' => 'Ripe, sweet bananas sourced from sustainable farms. Perfect for snacking, smoothies, or baking. Rich in potassium and natural energy. Our bananas are harvested at the perfect stage and ripened naturally for optimum sweetness and texture.',
    'allergy' => 'No known allergens.',
    'category' => 'grocery',
    'old_price' => null,
  ],
  3 => [
    'name' => 'Pineapple',
    'price' => 2.50,
    'image' => 'assets/css/image/pineapple.jpg',
    'rating' => 5.0,
    'desc' => 'Tropical pineapple bursting with sweet, tangy flavour. Perfect for desserts, juices, or grilling. Our pineapples are hand-selected for peak ripeness and shipped fresh. Each fruit is rich in bromelain and Vitamin C, making it a delicious and healthy choice.',
    'allergy' => 'No known allergens. May cause mild irritation for those sensitive to bromelain.',
    'category' => 'grocery',
    'old_price' => 3.20,
  ],
  4 => [
    'name' => 'Pomegranate',
    'price' => 2.99,
    'image' => 'assets/css/image/fomegranate.jpg',
    'rating' => 3.5,
    'desc' => 'Rich, ruby-red pomegranate seeds bursting with antioxidants and sweet-tart flavour. Perfect for salads, juices, smoothie bowls, or as a garnish. Our pomegranates are sourced from the finest orchards and selected for maximum seed density and juice content.',
    'allergy' => 'No known allergens.',
    'category' => 'grocery',
    'old_price' => 3.50,
  ],
  5 => [
    'name' => 'Broccoli',
    'price' => 1.20,
    'image' => 'assets/css/image/broccoli.png',
    'rating' => 4.5,
    'desc' => 'Fresh organic broccoli sourced from local farms in Cleckhudderfax. Rich in vitamins C and K, this vibrant green vegetable is perfect for stir-fries, steaming, or roasting. Our broccoli is hand-picked at peak freshness to ensure the best taste and nutritional value.',
    'allergy' => 'No known allergens. However, please wash thoroughly before consumption.',
    'category' => 'grocery',
    'old_price' => null,
  ],
  6 => [
    'name' => 'Cauliflower',
    'price' => 1.50,
    'image' => 'assets/css/image/cauliflower.png',
    'rating' => 4.5,
    'desc' => 'Fresh organic cauliflower, versatile and nutritious. Perfect for roasting, mashing, making cauliflower rice, or as a pizza base alternative. Our cauliflowers are sourced from Yorkshire farms and hand-picked for optimal size and freshness.',
    'allergy' => 'No known allergens.',
    'category' => 'grocery',
    'old_price' => 1.99,
  ],
  7 => [
    'name' => 'Salmon',
    'price' => 6.90,
    'image' => 'assets/css/image/salmon.png',
    'rating' => 5.0,
    'desc' => 'Premium Atlantic salmon fillet delivered fresh daily from The Harbour Fish Co. Rich in omega-3 fatty acids and high-quality protein. Our salmon is sustainably sourced and perfect for grilling, baking, or pan-searing. Each fillet is carefully trimmed and deboned for your convenience.',
    'allergy' => 'Contains: Fish. May contain traces of crustaceans and molluscs. Not suitable for those with fish allergies.',
    'category' => 'fish',
    'old_price' => 7.99,
  ],
  8 => [
    'name' => 'Steak',
    'price' => 8.50,
    'image' => 'assets/css/image/steak.png',
    'rating' => 4.0,
    'desc' => 'Premium 28-day aged sirloin steak from Hendersons Butchers. Our beef is sourced from grass-fed cattle raised on local Yorkshire farms. Each cut is hand-selected by our master butcher for optimal marbling and tenderness. Perfect for grilling or pan-frying to your preferred doneness.',
    'allergy' => 'No known allergens. Suitable for most diets. Please note this product is processed in a facility that also handles other meats.',
    'category' => 'frozen_meat',
    'old_price' => null,
  ],
  9 => [
    'name' => 'Sourdough',
    'price' => 3.50,
    'image' => 'assets/css/image/sourdough.png',
    'rating' => 3.5,
    'desc' => 'Artisan sourdough bread baked fresh each morning at The Old Mill Bakery. Made using a traditional 48-hour fermentation process with our 25-year-old starter culture. The result is a beautifully crusty loaf with a soft, tangy interior. Perfect for sandwiches, toast, or simply enjoyed with butter.',
    'allergy' => 'Contains: Wheat (Gluten). May contain traces of milk, eggs, sesame, and nuts. Produced in a bakery that handles multiple allergens.',
    'category' => 'bakery',
    'old_price' => null,
  ],
];

// ── Get product from URL ──
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if (!isset($products[$id])) {
  header('Location: shop.php');
  exit;
}

$product = $products[$id];
$pageTitle = htmlspecialchars($product['name']) . ' – Hudders Hub';
$is_wishlisted = in_array($id, $_SESSION['wishlist']);

// Build star display
$stars_full = floor($product['rating']);
$has_half = ($product['rating'] - $stars_full) >= 0.5;
$stars_empty = 5 - $stars_full - ($has_half ? 1 : 0);
$stars = str_repeat('★', $stars_full) . ($has_half ? '★' : '') . str_repeat('☆', $stars_empty);

// Get similar products (all except current)
$similar = array_filter($products, function ($key) use ($id) {
  return $key !== $id;
}, ARRAY_FILTER_USE_KEY);

// Limit to 3 similar products
$similar = array_slice($similar, 0, 3, true);

$discount_pct = $product['old_price'] ? round((($product['old_price'] - $product['price']) / $product['old_price']) * 100) : 0;
?>
<?php include 'include/header.php'; ?>

<style>
  body {
    background: var(--beige-light);
  }
</style>

<!-- ═══ Breadcrumb ═══ -->
<div style="max-width:var(--max-width);margin:0 auto;padding:18px 2rem 0;">
  <nav class="shop-breadcrumb">
    <a href="index.php">Home</a>
    <span>&gt;</span>
    <a href="shop.php">Shop</a>
    <span>&gt;</span>
    <span class="current"><?= htmlspecialchars($product['name']) ?></span>
  </nav>
</div>

<!-- ====== MAIN PRODUCT SECTION ====== -->
<section class="product-detail-main">
  <div class="product-detail-container">

    <!-- Left: Product Image -->
    <div class="product-detail-image">
      <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
    </div>

    <!-- Right: Product Info -->
    <div class="product-detail-info">
      <h1 class="product-detail-title"><?= htmlspecialchars($product['name']) ?></h1>
      <p class="product-detail-price">
        Price: <strong>$<?= number_format($product['price'], 2) ?></strong>
        <?php if ($product['old_price']): ?>
          <span
            style="text-decoration:line-through;color:#999;font-size:0.9rem;margin-left:8px;">$<?= number_format($product['old_price'], 2) ?></span>
          <span class="discount-badge" style="margin-left:6px;">-<?= $discount_pct ?>%</span>
        <?php endif; ?>
      </p>
      <div class="product-detail-stars"><?= $stars ?> <span
          style="font-size:0.85rem;color:#6B6B6B;margin-left:6px;"><?= number_format($product['rating'], 1) ?>/5</span>
      </div>
      <p class="product-detail-desc">
        <?= htmlspecialchars($product['desc']) ?>
      </p>
      <p class="product-detail-allergy">
        <strong>Allergy Information:</strong> <?= htmlspecialchars($product['allergy']) ?>
      </p>
      <div class="product-detail-actions">
        <button class="product-detail-btn-cart" id="addToCartBtn" onclick="addToCartDetail(<?= $id ?>)">
          <i class="fas fa-cart-plus"></i> ADD TO CART
        </button>
        <button class="product-detail-btn-wishlist <?= $is_wishlisted ? 'wishlisted-detail' : '' ?>" id="wishlistBtn"
          onclick="toggleWishlistDetail(<?= $id ?>)">
          <i class="<?= $is_wishlisted ? 'fas' : 'far' ?> fa-heart"></i>
          <?= $is_wishlisted ? 'IN WISHLIST' : 'ADD TO WISH LIST' ?>
        </button>
        <button class="product-detail-btn-cart" style="background:#5C6B3A;border-color:#5C6B3A;"
          onclick="buyNow(<?= $id ?>)">
          <i class="fas fa-bolt"></i> BUY NOW
        </button>
      </div>
    </div>

  </div>
</section>

<!-- ====== SIMILAR PRODUCTS ====== -->
<section class="product-detail-similar">
  <div class="product-detail-similar-inner">
    <h2 class="product-detail-section-heading">Similar Products</h2>

    <div class="product-detail-similar-grid">
      <?php foreach ($similar as $simId => $sim): ?>
        <div class="product-detail-sim-card">
          <div class="product-detail-sim-img">
            <a href="product_detail.php?id=<?= $simId ?>">
              <img src="<?= htmlspecialchars($sim['image']) ?>" alt="<?= htmlspecialchars($sim['name']) ?>">
            </a>
          </div>
          <div class="product-detail-sim-body">
            <h3><a href="product_detail.php?id=<?= $simId ?>"><?= htmlspecialchars($sim['name']) ?></a></h3>
            <p class="product-detail-sim-price">Price: <strong>$<?= number_format($sim['price'], 2) ?></strong></p>
            <p class="product-detail-sim-desc"><?= htmlspecialchars(substr($sim['desc'], 0, 120)) ?>…</p>
            <button class="product-detail-sim-cart-btn" onclick="addToCartDetail(<?= $simId ?>)">
              <i class="fas fa-cart-plus"></i> ADD TO CART
            </button>
          </div>
        </div>
      <?php endforeach; ?>
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
        <span class="product-detail-review-date">4 May 2026</span>
      </div>
      <p class="product-detail-review-text">
        Excellent quality <?= htmlspecialchars($product['name']) ?>! Very fresh and well-packaged. Arrived in perfect
        condition and tasted wonderful. Will definitely order again from Hudders Hub Market.
      </p>
    </div>

    <!-- Review 2 -->
    <div class="product-detail-review-card">
      <div class="product-detail-review-header">
        <div>
          <h4 class="product-detail-reviewer">Smriti Shrestha</h4>
          <div class="product-detail-review-stars">★★★★</div>
        </div>
        <span class="product-detail-review-date">2 May 2026</span>
      </div>
      <p class="product-detail-review-text">
        Great <?= htmlspecialchars($product['name']) ?> at a fair price. The quality is consistently good every time I
        order. Love supporting local traders through this platform. Highly recommended!
      </p>
    </div>

  </div>
</section>

<!-- ═══ Toast notification ═══ -->
<div id="toast" class="shop-toast">
  <i class="fas fa-check-circle"></i>
  <span id="toastMsg"></span>
</div>

<!-- ═══ JavaScript ═══ -->
<script>
  function showToast(msg, type = 'success') {
    const toast = document.getElementById('toast');
    const msgEl = document.getElementById('toastMsg');
    msgEl.textContent = msg;
    toast.className = 'shop-toast show ' + type;
    setTimeout(() => { toast.className = 'shop-toast'; }, 2800);
  }

  function addToCartDetail(productId) {
    const btn = document.getElementById('addToCartBtn');
    if (btn) {
      btn.disabled = true;
      btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
    }

    fetch('api/cart_action.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'action=add_to_cart&product_id=' + productId + '&qty=1'
    })
      .then(r => r.json())
      .then(data => {
        if (data.success) {
          showToast(data.message, 'success');
          // Update cart badge in header
          const badge = document.getElementById('cartBadge');
          if (badge) { badge.textContent = data.cart_count; badge.style.display = 'flex'; }
          if (btn) {
            btn.innerHTML = '<i class="fas fa-check"></i> ADDED!';
            setTimeout(() => {
              btn.innerHTML = '<i class="fas fa-cart-plus"></i> ADD TO CART';
              btn.disabled = false;
            }, 1500);
          }
        } else {
          showToast(data.message, 'error');
          if (btn) {
            btn.innerHTML = '<i class="fas fa-cart-plus"></i> ADD TO CART';
            btn.disabled = false;
          }
        }
      })
      .catch(() => {
        showToast('Failed to add to cart.', 'error');
        if (btn) {
          btn.innerHTML = '<i class="fas fa-cart-plus"></i> ADD TO CART';
          btn.disabled = false;
        }
      });
  }

  function toggleWishlistDetail(productId) {
    fetch('api/cart_action.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'action=toggle_wishlist&product_id=' + productId
    })
      .then(r => r.json())
      .then(data => {
        if (data.success) {
          const btn = document.getElementById('wishlistBtn');
          const icon = btn.querySelector('i');
          if (data.wishlisted) {
            btn.classList.add('wishlisted-detail');
            icon.className = 'fas fa-heart';
            btn.innerHTML = '<i class="fas fa-heart"></i> IN WISHLIST';
            showToast('Added to wishlist!', 'success');
          } else {
            btn.classList.remove('wishlisted-detail');
            icon.className = 'far fa-heart';
            btn.innerHTML = '<i class="far fa-heart"></i> ADD TO WISH LIST';
            showToast('Removed from wishlist.', 'info');
          }
        }
      })
      .catch(() => showToast('Wishlist error.', 'error'));
  }

  function buyNow(productId) {
    fetch('api/cart_action.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'action=add_to_cart&product_id=' + productId + '&qty=1'
    })
      .then(r => r.json())
      .then(data => {
        if (data.success) {
          window.location.href = 'cart.php';
        } else {
          showToast(data.message, 'error');
        }
      })
      .catch(() => {
        showToast('Error. Please try again.', 'error');
      });
  }
</script>

<?php include 'include/footer.php'; ?>