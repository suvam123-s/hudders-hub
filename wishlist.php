<?php
session_start();
$pageTitle = "My Wishlist - Hudders Hub";

// Initialize session arrays
if (!isset($_SESSION['cart']))
  $_SESSION['cart'] = [];
if (!isset($_SESSION['wishlist']))
  $_SESSION['wishlist'] = [];

// ── Master product catalog ──
$products = [
  1 => [
    'name' => 'Orange',
    'price' => 1.49,
    'image' => 'assets/css/image/orange.jpg',
    'rating' => 3.5,
    'category' => 'grocery',
    'old_price' => null,
  ],
  2 => [
    'name' => 'Banana',
    'price' => 1.29,
    'image' => 'assets/css/image/bannan.png',
    'rating' => 4.5,
    'category' => 'grocery',
    'old_price' => null,
  ],
  3 => [
    'name' => 'Pineapple',
    'price' => 2.50,
    'image' => 'assets/css/image/pineapple.jpg',
    'rating' => 5.0,
    'category' => 'grocery',
    'old_price' => 3.20,
  ],
  4 => [
    'name' => 'Pomegranate',
    'price' => 2.99,
    'image' => 'assets/css/image/fomegranate.jpg',
    'rating' => 3.5,
    'category' => 'grocery',
    'old_price' => 3.50,
  ],
  5 => [
    'name' => 'Broccoli',
    'price' => 1.20,
    'image' => 'assets/css/image/broccoli.png',
    'rating' => 4.5,
    'category' => 'grocery',
    'old_price' => null,
  ],
  6 => [
    'name' => 'Cauliflower',
    'price' => 1.50,
    'image' => 'assets/css/image/cauliflower.png',
    'rating' => 4.5,
    'category' => 'grocery',
    'old_price' => 1.99,
  ],
  7 => [
    'name' => 'Salmon',
    'price' => 6.90,
    'image' => 'assets/css/image/salmon.png',
    'rating' => 5.0,
    'category' => 'fish',
    'old_price' => 7.99,
  ],
  8 => [
    'name' => 'Steak',
    'price' => 8.50,
    'image' => 'assets/css/image/steak.png',
    'rating' => 4.0,
    'category' => 'frozen_meat',
    'old_price' => null,
  ],
  9 => [
    'name' => 'Sourdough',
    'price' => 3.50,
    'image' => 'assets/css/image/sourdough.png',
    'rating' => 3.5,
    'category' => 'bakery',
    'old_price' => null,
  ],
  10 => [
    'name' => 'Bagels',
    'price' => 2.50,
    'image' => 'assets/css/image/bagels.jpg',
    'rating' => 4.2,
    'category' => 'bakery',
    'old_price' => null,
  ],
  11 => [
    'name' => 'Croissant',
    'price' => 1.80,
    'image' => 'assets/css/image/croissant.jpg',
    'rating' => 4.8,
    'category' => 'bakery',
    'old_price' => null,
  ],
  12 => [
    'name' => 'Cake',
    'price' => 4.50,
    'image' => 'assets/css/image/cake.jpg',
    'rating' => 4.5,
    'category' => 'bakery',
    'old_price' => 5.00,
  ],
  13 => [
    'name' => 'Donuts',
    'price' => 3.00,
    'image' => 'assets/css/image/donuts.jpg',
    'rating' => 4.6,
    'category' => 'bakery',
    'old_price' => null,
  ],
  14 => [
    'name' => 'Muffins',
    'price' => 2.20,
    'image' => 'assets/css/image/muffins.jpg',
    'rating' => 4.3,
    'category' => 'bakery',
    'old_price' => null,
  ],
  15 => [
    'name' => 'Cheese',
    'price' => 5.50,
    'image' => 'assets/css/image/cheese.jpg',
    'rating' => 4.7,
    'category' => 'deli',
    'old_price' => null,
  ],
  16 => [
    'name' => 'Ham',
    'price' => 4.20,
    'image' => 'assets/css/image/ham.jpg',
    'rating' => 4.4,
    'category' => 'deli',
    'old_price' => null,
  ],
  17 => [
    'name' => 'Prawns',
    'price' => 8.90,
    'image' => 'assets/css/image/prawns.jpg',
    'rating' => 4.9,
    'category' => 'fish',
    'old_price' => 9.50,
  ],
  18 => [
    'name' => 'Coffee',
    'price' => 6.50,
    'image' => 'assets/css/image/coffee.jpg',
    'rating' => 4.8,
    'category' => 'grocery',
    'old_price' => 7.20,
  ],
  19 => [
    'name' => 'Cooking Oil',
    'price' => 3.20,
    'image' => 'assets/css/image/cooking oil.jpg',
    'rating' => 4.0,
    'category' => 'grocery',
    'old_price' => null,
  ],
  20 => [
    'name' => 'Sugar',
    'price' => 1.50,
    'image' => 'assets/css/image/sugar.jpg',
    'rating' => 4.1,
    'category' => 'grocery',
    'old_price' => null,
  ],
  21 => [
    'name' => 'Lemon Zest',
    'price' => 1.10,
    'image' => 'assets/css/image/Lemon zest.png',
    'rating' => 4.5,
    'category' => 'grocery',
    'old_price' => null,
  ],
  22 => [
    'name' => 'Fish Fillet',
    'price' => 7.50,
    'image' => 'assets/css/image/Fish fillet.jpg',
    'rating' => 4.5,
    'category' => 'fish',
    'old_price' => null,
  ],
  23 => [
    'name' => 'Frozen Chicken',
    'price' => 5.50,
    'image' => 'assets/css/image/Frozen chicken.jpg',
    'rating' => 4.3,
    'category' => 'frozen_meat',
    'old_price' => null,
  ],
  24 => [
    'name' => 'Lobster',
    'price' => 25.00,
    'image' => 'assets/css/image/Lobster.jpg',
    'rating' => 4.9,
    'category' => 'fish',
    'old_price' => 28.00,
  ],
  25 => [
    'name' => 'Tuna',
    'price' => 12.00,
    'image' => 'assets/css/image/Tuna.jpg',
    'rating' => 4.6,
    'category' => 'fish',
    'old_price' => null,
  ],
  26 => [
    'name' => 'Bacon',
    'price' => 4.80,
    'image' => 'assets/css/image/bacon.jpg',
    'rating' => 4.7,
    'category' => 'frozen_meat',
    'old_price' => null,
  ],
  27 => [
    'name' => 'Beef Steak',
    'price' => 10.50,
    'image' => 'assets/css/image/beef steak.jpg',
    'rating' => 4.8,
    'category' => 'frozen_meat',
    'old_price' => 12.00,
  ],
  28 => [
    'name' => 'Pickle',
    'price' => 2.50,
    'image' => 'assets/css/image/pickle.jpg',
    'rating' => 4.1,
    'category' => 'deli',
    'old_price' => null,
  ],
  29 => [
    'name' => 'Salad',
    'price' => 3.50,
    'image' => 'assets/css/image/salad.jpg',
    'rating' => 4.4,
    'category' => 'deli',
    'old_price' => null,
  ],
  30 => [
    'name' => 'Sandwich',
    'price' => 4.50,
    'image' => 'assets/css/image/sandwich.jpg',
    'rating' => 4.6,
    'category' => 'deli',
    'old_price' => null,
  ],
  31 => [
    'name' => 'Cookies',
    'price' => 2.80,
    'image' => 'assets/css/image/Cookies.jpg',
    'rating' => 4.6,
    'category' => 'bakery',
    'old_price' => null,
  ],
  32 => [
    'name' => 'Frozen Mutton',
    'price' => 14.50,
    'image' => 'assets/css/image/Frozen mutton.jpg',
    'rating' => 4.3,
    'category' => 'frozen_meat',
    'old_price' => null,
  ],
  33 => [
    'name' => 'Olives',
    'price' => 3.20,
    'image' => 'assets/css/image/Olives.jpg',
    'rating' => 4.5,
    'category' => 'deli',
    'old_price' => null,
  ],
  34 => [
    'name' => 'Sausage',
    'price' => 5.00,
    'image' => 'assets/css/image/Sausage.jpg',
    'rating' => 4.4,
    'category' => 'frozen_meat',
    'old_price' => null,
  ],
  35 => [
    'name' => 'Bread',
    'price' => 2.00,
    'image' => 'assets/css/image/bread.jpg',
    'rating' => 4.2,
    'category' => 'bakery',
    'old_price' => null,
  ],
  37 => [
    'name' => 'Pastries',
    'price' => 3.50,
    'image' => 'assets/css/image/pastries.jpg',
    'rating' => 4.7,
    'category' => 'bakery',
    'old_price' => null,
  ],
  38 => [
    'name' => 'Salami',
    'price' => 4.80,
    'image' => 'assets/css/image/salami.jpg',
    'rating' => 4.5,
    'category' => 'deli',
    'old_price' => null,
  ],
  39 => [
    'name' => 'Smoked Meat',
    'price' => 6.00,
    'image' => 'assets/css/image/smoked meat.jpg',
    'rating' => 4.8,
    'category' => 'deli',
    'old_price' => null,
  ],
];

$wishlist_ids = $_SESSION['wishlist'];
$wishlist_products = [];
foreach ($wishlist_ids as $pid) {
  if (isset($products[$pid])) {
    $wishlist_products[$pid] = $products[$pid];
  }
}

include 'include/header.php';
?>

<section class="shop-page">
  <div class="shop-top-bar" style="justify-content:center;">
    <div class="shop-top-left" style="text-align:center;">
      <h1 class="shop-title">My Wishlist</h1>
      <p style="color:#666; margin-top:8px;">Products you have saved for later</p>
    </div>
  </div>

  <div class="shop-layout" style="display:block; max-width:1200px; margin:0 auto; padding:0 2rem;">
    <div class="shop-products" style="grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));">
      <?php if (empty($wishlist_products)): ?>
        <div class="shop-empty" style="text-align:center; padding: 4rem 0; width: 100%; grid-column: 1 / -1;">
          <i class="far fa-heart" style="font-size:3rem; color:#ccc; margin-bottom:1rem;"></i>
          <p style="font-size:1.1rem; color:#666;">Your wishlist is empty.</p>
          <a href="shop.php" class="btn-apply-filter"
            style="display:inline-block; max-width:200px; margin:20px auto 0;">Explore Products</a>
        </div>
      <?php endif; ?>

      <?php foreach ($wishlist_products as $pid => $p):
        $stars_full = floor($p['rating']);
        $has_half = ($p['rating'] - $stars_full) >= 0.5;
        $stars_empty = 5 - $stars_full - ($has_half ? 1 : 0);
        $discount_pct = $p['old_price'] ? round((($p['old_price'] - $p['price']) / $p['old_price']) * 100) : 0;
        ?>
        <div class="shop-card" data-product-id="<?= $pid ?>">
          <div class="shop-card-img">
            <a href="product_detail.php?id=<?= $pid ?>">
              <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
            </a>
            <!-- Wishlist toggle button, active state, removes from wishlist on click -->
            <button class="wishlist-btn wishlisted" data-product-id="<?= $pid ?>"
              onclick="toggleWishlist(<?= $pid ?>, this)" aria-label="Remove from wishlist">
              <i class="fas fa-heart"></i>
            </button>
          </div>
          <div class="shop-card-body">
            <h4><a href="product_detail.php?id=<?= $pid ?>"><?= htmlspecialchars($p['name']) ?></a></h4>
            <div class="shop-card-rating">
              <span class="stars-filled">
                <?= str_repeat('★', $stars_full) ?>
                <?php if ($has_half): ?><span class="star-half">★</span><?php endif; ?>
                <?= str_repeat('☆', $stars_empty) ?>
              </span>
              <span class="rating-num"><?= number_format($p['rating'], 1) ?>/5</span>
            </div>
            <div class="shop-card-price">
              <span class="current-price">$<?= $p['price'] ?></span>
              <?php if ($p['old_price']): ?>
                <span class="old-price">$<?= $p['old_price'] ?></span>
                <span class="discount-badge">-<?= $discount_pct ?>%</span>
              <?php endif; ?>
            </div>
            <div class="shop-card-actions">
              <button class="btn-add-cart" onclick="addToCart(<?= $pid ?>, this)" title="Add to Cart">
                <i class="fas fa-cart-plus"></i> Add to Cart
              </button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══ Toast notification ═══ -->
<div id="toast" class="shop-toast">
  <i class="fas fa-check-circle"></i>
  <span id="toastMsg"></span>
</div>

<script>
  function showToast(msg, type = 'success') {
    const toast = document.getElementById('toast');
    const msgEl = document.getElementById('toastMsg');
    msgEl.textContent = msg;
    toast.className = 'shop-toast show ' + type;
    setTimeout(() => { toast.className = 'shop-toast'; }, 2800);
  }

  function addToCart(productId, btn) {
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
    fetch('api/cart_action.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'action=add_to_cart&product_id=' + productId + '&qty=1'
    })
      .then(r => r.json())
      .then(data => {
        if (data.success) {
          showToast(data.message, 'success');
          btn.innerHTML = '<i class="fas fa-check"></i> Added!';
          btn.classList.add('added');
          const badge = document.getElementById('cartBadge');
          if (badge) { badge.textContent = data.cart_count; badge.style.display = 'flex'; }
          setTimeout(() => {
            btn.innerHTML = '<i class="fas fa-cart-plus"></i> Add to Cart';
            btn.classList.remove('added');
            btn.disabled = false;
          }, 1500);
        } else {
          showToast(data.message, 'error');
          btn.innerHTML = '<i class="fas fa-cart-plus"></i> Add to Cart';
          btn.disabled = false;
        }
      })
      .catch(() => {
        showToast('Failed to add to cart.', 'error');
        btn.innerHTML = '<i class="fas fa-cart-plus"></i> Add to Cart';
        btn.disabled = false;
      });
  }

  function toggleWishlist(productId, btn) {
    fetch('api/cart_action.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'action=toggle_wishlist&product_id=' + productId
    })
      .then(r => r.json())
      .then(data => {
        if (data.success) {
          if (!data.wishlisted) {
            showToast('Removed from wishlist.', 'info');
            const card = btn.closest('.shop-card');
            if (card) {
              card.style.display = 'none';
              // Optional: check if grid is empty now
              const productsGrid = document.querySelector('.shop-products');
              const visibleCards = productsGrid.querySelectorAll('.shop-card[style!="display: none;"]');
              if (visibleCards.length === 0) {
                location.reload(); // Quick way to show empty state
              }
            }
          }
        }
      })
      .catch(() => showToast('Wishlist error.', 'error'));
  }
</script>

<?php include 'include/footer.php'; ?>