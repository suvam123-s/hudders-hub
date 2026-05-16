<?php
session_start();
$pageTitle = "Shop - Hudders Hub";

// Initialize session arrays
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
if (!isset($_SESSION['wishlist'])) $_SESSION['wishlist'] = [];

// ── Master product catalog ──
$products = [
    1 => [
        'name' => 'Orange', 'price' => 1.49, 'image' => 'assets/css/image/orange.jpg',
        'rating' => 3.5, 'category' => 'grocery', 'old_price' => null,
    ],
    2 => [
        'name' => 'Banana', 'price' => 1.29, 'image' => 'assets/css/image/bannan.png',
        'rating' => 4.5, 'category' => 'grocery', 'old_price' => null,
    ],
    3 => [
        'name' => 'Pineapple', 'price' => 2.50, 'image' => 'assets/css/image/pineapple.jpg',
        'rating' => 5.0, 'category' => 'grocery', 'old_price' => 3.20,
    ],
    4 => [
        'name' => 'Pomegranate', 'price' => 2.99, 'image' => 'assets/css/image/fomegranate.jpg',
        'rating' => 3.5, 'category' => 'grocery', 'old_price' => 3.50,
    ],
    5 => [
        'name' => 'Broccoli', 'price' => 1.20, 'image' => 'assets/css/image/broccoli.png',
        'rating' => 4.5, 'category' => 'grocery', 'old_price' => null,
    ],
    6 => [
        'name' => 'Cauliflower', 'price' => 1.50, 'image' => 'assets/css/image/cauliflower.png',
        'rating' => 4.5, 'category' => 'grocery', 'old_price' => 1.99,
    ],
    7 => [
        'name' => 'Salmon', 'price' => 6.90, 'image' => 'assets/css/image/salmon.png',
        'rating' => 5.0, 'category' => 'fish', 'old_price' => 7.99,
    ],
    8 => [
        'name' => 'Steak', 'price' => 8.50, 'image' => 'assets/css/image/steak.png',
        'rating' => 4.0, 'category' => 'frozen_meat', 'old_price' => null,
    ],
    9 => [
        'name' => 'Sourdough', 'price' => 3.50, 'image' => 'assets/css/image/sourdough.png',
        'rating' => 3.5, 'category' => 'bakery', 'old_price' => null,
    ],
    10 => [
        'name' => 'Bagels', 'price' => 2.50, 'image' => 'assets/css/image/bagels.jpg',
        'rating' => 4.2, 'category' => 'bakery', 'old_price' => null,
    ],
    11 => [
        'name' => 'Croissant', 'price' => 1.80, 'image' => 'assets/css/image/croissant.jpg',
        'rating' => 4.8, 'category' => 'bakery', 'old_price' => null,
    ],
    12 => [
        'name' => 'Cake', 'price' => 4.50, 'image' => 'assets/css/image/cake.jpg',
        'rating' => 4.5, 'category' => 'bakery', 'old_price' => 5.00,
    ],
    13 => [
        'name' => 'Donuts', 'price' => 3.00, 'image' => 'assets/css/image/donuts.jpg',
        'rating' => 4.6, 'category' => 'bakery', 'old_price' => null,
    ],
    14 => [
        'name' => 'Muffins', 'price' => 2.20, 'image' => 'assets/css/image/muffins.jpg',
        'rating' => 4.3, 'category' => 'bakery', 'old_price' => null,
    ],
    15 => [
        'name' => 'Cheese', 'price' => 5.50, 'image' => 'assets/css/image/cheese.jpg',
        'rating' => 4.7, 'category' => 'deli', 'old_price' => null,
    ],
    16 => [
        'name' => 'Ham', 'price' => 4.20, 'image' => 'assets/css/image/ham.jpg',
        'rating' => 4.4, 'category' => 'deli', 'old_price' => null,
    ],
    17 => [
        'name' => 'Prawns', 'price' => 8.90, 'image' => 'assets/css/image/prawns.jpg',
        'rating' => 4.9, 'category' => 'fish', 'old_price' => 9.50,
    ],
    18 => [
        'name' => 'Coffee', 'price' => 6.50, 'image' => 'assets/css/image/coffee.jpg',
        'rating' => 4.8, 'category' => 'grocery', 'old_price' => 7.20,
    ],
    19 => [
        'name' => 'Cooking Oil', 'price' => 3.20, 'image' => 'assets/css/image/cooking oil.jpg',
        'rating' => 4.0, 'category' => 'grocery', 'old_price' => null,
    ],
    20 => [
        'name' => 'Sugar', 'price' => 1.50, 'image' => 'assets/css/image/sugar.jpg',
        'rating' => 4.1, 'category' => 'grocery', 'old_price' => null,
    ],
    21 => [
        'name' => 'Lemon Zest', 'price' => 1.10, 'image' => 'assets/css/image/Lemon zest.png',
        'rating' => 4.5, 'category' => 'grocery', 'old_price' => null,
    ],
    22 => [
        'name' => 'Fish Fillet', 'price' => 7.50, 'image' => 'assets/css/image/Fish fillet.jpg',
        'rating' => 4.5, 'category' => 'fish', 'old_price' => null,
    ],
    23 => [
        'name' => 'Frozen Chicken', 'price' => 5.50, 'image' => 'assets/css/image/Frozen chicken.jpg',
        'rating' => 4.3, 'category' => 'frozen_meat', 'old_price' => null,
    ],
    24 => [
        'name' => 'Lobster', 'price' => 25.00, 'image' => 'assets/css/image/Lobster.jpg',
        'rating' => 4.9, 'category' => 'fish', 'old_price' => 28.00,
    ],
    25 => [
        'name' => 'Tuna', 'price' => 12.00, 'image' => 'assets/css/image/Tuna.jpg',
        'rating' => 4.6, 'category' => 'fish', 'old_price' => null,
    ],
    26 => [
        'name' => 'Bacon', 'price' => 4.80, 'image' => 'assets/css/image/bacon.jpg',
        'rating' => 4.7, 'category' => 'frozen_meat', 'old_price' => null,
    ],
    27 => [
        'name' => 'Beef Steak', 'price' => 10.50, 'image' => 'assets/css/image/beef steak.jpg',
        'rating' => 4.8, 'category' => 'frozen_meat', 'old_price' => 12.00,
    ],
    28 => [
        'name' => 'Pickle', 'price' => 2.50, 'image' => 'assets/css/image/pickle.jpg',
        'rating' => 4.1, 'category' => 'deli', 'old_price' => null,
    ],
    29 => [
        'name' => 'Salad', 'price' => 3.50, 'image' => 'assets/css/image/salad.jpg',
        'rating' => 4.4, 'category' => 'deli', 'old_price' => null,
    ],
    30 => [
        'name' => 'Sandwich', 'price' => 4.50, 'image' => 'assets/css/image/sandwich.jpg',
        'rating' => 4.6, 'category' => 'deli', 'old_price' => null,
    ],
    31 => [
        'name' => 'Cookies', 'price' => 2.80, 'image' => 'assets/css/image/Cookies.jpg',
        'rating' => 4.6, 'category' => 'bakery', 'old_price' => null,
    ],
    32 => [
        'name' => 'Frozen Mutton', 'price' => 14.50, 'image' => 'assets/css/image/Frozen mutton.jpg',
        'rating' => 4.3, 'category' => 'frozen_meat', 'old_price' => null,
    ],
    33 => [
        'name' => 'Olives', 'price' => 3.20, 'image' => 'assets/css/image/Olives.jpg',
        'rating' => 4.5, 'category' => 'deli', 'old_price' => null,
    ],
    34 => [
        'name' => 'Sausage', 'price' => 5.00, 'image' => 'assets/css/image/Sausage.jpg',
        'rating' => 4.4, 'category' => 'frozen_meat', 'old_price' => null,
    ],
    35 => [
        'name' => 'Bread', 'price' => 2.00, 'image' => 'assets/css/image/bread.jpg',
        'rating' => 4.2, 'category' => 'bakery', 'old_price' => null,
    ],

    37 => [
        'name' => 'Pastries', 'price' => 3.50, 'image' => 'assets/css/image/pastries.jpg',
        'rating' => 4.7, 'category' => 'bakery', 'old_price' => null,
    ],
    38 => [
        'name' => 'Salami', 'price' => 4.80, 'image' => 'assets/css/image/salami.jpg',
        'rating' => 4.5, 'category' => 'deli', 'old_price' => null,
    ],
    39 => [
        'name' => 'Smoked Meat', 'price' => 6.00, 'image' => 'assets/css/image/smoked meat.jpg',
        'rating' => 4.8, 'category' => 'deli', 'old_price' => null,
    ],
];

// ── Category mapping ──
$categories = [
    'bakery'      => 'Bakery Items',
    'grocery'     => 'Grocery',
    'fish'        => 'Fish Items',
    'frozen_meat' => 'Frozen Meat',
    'deli'        => 'Delicatessen',
];

// ── Filtering ──
$active_cat   = $_GET['category'] ?? '';
$max_price    = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 30;
$sort_by      = $_GET['sort'] ?? 'popular';
$search_query = trim($_GET['q'] ?? '');

$filtered = $products;

// Category filter
if ($active_cat && $active_cat !== 'all') {
    $filtered = array_filter($filtered, fn($p) => $p['category'] === $active_cat);
}

// Price filter
$filtered = array_filter($filtered, fn($p) => $p['price'] <= $max_price);

// Search filter
if ($search_query) {
    $filtered = array_filter($filtered, fn($p) =>
        stripos($p['name'], $search_query) !== false
    );
}

// Sort
switch ($sort_by) {
    case 'price-low':
        uasort($filtered, fn($a, $b) => $a['price'] - $b['price']);
        break;
    case 'price-high':
        uasort($filtered, fn($a, $b) => $b['price'] - $a['price']);
        break;
    case 'rating':
        uasort($filtered, fn($a, $b) => $b['rating'] <=> $a['rating']);
        break;
    case 'newest':
        $filtered = array_reverse($filtered, true);
        break;
    default: // popular — keep original order
        break;
}

$total_products = count($filtered);
$cart_count = array_sum(array_column($_SESSION['cart'], 'qty'));

include 'include/header.php';
?>

<section class="shop-page">

  <!-- Breadcrumb + Title Row -->
  <div class="shop-top-bar">
    <div class="shop-top-left">
      <nav class="shop-breadcrumb">
        <a href="index.php">Home</a>
        <span>&gt;</span>
        <span class="current">Shop</span>
      </nav>
      <h1 class="shop-title">Shop</h1>
    </div>
    <div class="shop-top-right">
      <span class="shop-showing">Showing 1–<?= $total_products ?> of <?= count($products) ?> Products</span>
      <div class="shop-sort">
        <label for="sortBy">Sort by:</label>
        <select id="sortBy" name="sort" onchange="applySort(this.value)">
          <option value="popular" <?= $sort_by === 'popular' ? 'selected' : '' ?>>Most Popular</option>
          <option value="newest" <?= $sort_by === 'newest' ? 'selected' : '' ?>>Newest</option>
          <option value="price-low" <?= $sort_by === 'price-low' ? 'selected' : '' ?>>Price: Low to High</option>
          <option value="price-high" <?= $sort_by === 'price-high' ? 'selected' : '' ?>>Price: High to Low</option>
          <option value="rating" <?= $sort_by === 'rating' ? 'selected' : '' ?>>Top Rated</option>
        </select>
      </div>
    </div>
  </div>

  <div class="shop-layout">

    <!-- ─── Sidebar Filters ─── -->
    <aside class="shop-sidebar">
      <div class="sidebar-header">
        <h3>Filters</h3>
        <button class="filter-toggle" aria-label="Toggle filters">
          <i class="fas fa-sliders-h"></i>
        </button>
      </div>

      <form id="filterForm" method="GET" action="shop.php">
        <!-- Preserve sort & search -->
        <input type="hidden" name="sort" value="<?= htmlspecialchars($sort_by) ?>">
        <?php if ($search_query): ?>
          <input type="hidden" name="q" value="<?= htmlspecialchars($search_query) ?>">
        <?php endif; ?>

        <div class="filter-group">
          <ul class="category-list">
            <li class="<?= $active_cat === '' || $active_cat === 'all' ? 'active-cat' : '' ?>">
              <a href="shop.php?sort=<?= $sort_by ?>" class="category-link <?= $active_cat === '' ? 'active' : '' ?>">All Items</a>
              <i class="fas fa-chevron-right"></i>
            </li>
            <?php foreach ($categories as $key => $label): ?>
            <li class="<?= $active_cat === $key ? 'active-cat' : '' ?>">
              <a href="shop.php?category=<?= $key ?>&sort=<?= $sort_by ?>" class="category-link <?= $active_cat === $key ? 'active' : '' ?>"><?= $label ?></a>
              <i class="fas fa-chevron-right"></i>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="filter-group">
          <div class="filter-group-header" id="priceToggle">
            <h4>Price</h4>
            <i class="fas fa-chevron-up"></i>
          </div>
          <div class="price-range-wrap">
            <input type="range" id="priceRange" name="max_price" min="1" max="30" value="<?= $max_price ?>" class="price-slider" step="0.50" oninput="updatePriceLabel(this.value)">
            <div class="price-labels">
              <span>$1</span>
              <span id="priceMax">$<?= $max_price ?></span>
            </div>
          </div>
          <input type="hidden" name="category" value="<?= htmlspecialchars($active_cat) ?>">
        </div>

        <button type="submit" class="btn-apply-filter">Apply Filter</button>
      </form>
    </aside>

    <!-- ─── Product Grid ─── -->
    <div class="shop-products">

      <?php if (empty($filtered)): ?>
        <div class="shop-empty">
          <i class="fas fa-search" style="font-size:2rem; color:#999; margin-bottom:12px;"></i>
          <p>No products found matching your filters.</p>
          <a href="shop.php" class="btn-apply-filter" style="max-width:200px; margin:12px auto 0; text-align:center;">Clear Filters</a>
        </div>
      <?php endif; ?>

      <?php foreach ($filtered as $pid => $p):
        $is_wishlisted = in_array($pid, $_SESSION['wishlist']);
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
          <button class="wishlist-btn <?= $is_wishlisted ? 'wishlisted' : '' ?>"
                  data-product-id="<?= $pid ?>"
                  onclick="toggleWishlist(<?= $pid ?>, this)"
                  aria-label="<?= $is_wishlisted ? 'Remove from' : 'Add to' ?> wishlist">
            <i class="<?= $is_wishlisted ? 'fas' : 'far' ?> fa-heart"></i>
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
            <a href="product_detail.php?id=<?= $pid ?>" class="btn-buy-now" title="Buy Now">
              Buy Now
            </a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

    </div><!-- /shop-products -->
  </div><!-- /shop-layout -->

  <!-- Pagination -->
  <nav class="shop-pagination" aria-label="Shop pagination">
    <a href="#" class="page-link active">1</a>
    <a href="#" class="page-link">2</a>
    <a href="#" class="page-link">3</a>
    <span class="page-dots">...</span>
    <a href="#" class="page-link">8</a>
    <a href="#" class="page-link">9</a>
    <a href="#" class="page-link">10</a>
  </nav>

</section>

<!-- ═══ Toast notification ═══ -->
<div id="toast" class="shop-toast">
  <i class="fas fa-check-circle"></i>
  <span id="toastMsg"></span>
</div>

<!-- ═══ JavaScript: Cart, Wishlist, Filters ═══ -->
<script>
// ── Toast notification ──
function showToast(msg, type = 'success') {
  const toast = document.getElementById('toast');
  const msgEl = document.getElementById('toastMsg');
  msgEl.textContent = msg;
  toast.className = 'shop-toast show ' + type;
  setTimeout(() => { toast.className = 'shop-toast'; }, 2800);
}

// ── Add to Cart (AJAX) ──
function addToCart(productId, btn) {
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';

  fetch('api/cart_action.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'action=add_to_cart&product_id=' + productId + '&qty=1'
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      showToast(data.message, 'success');
      btn.innerHTML = '<i class="fas fa-check"></i> Added!';
      btn.classList.add('added');
      // Update cart count badge if exists
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

// ── Toggle Wishlist (AJAX) ──
function toggleWishlist(productId, btn) {
  fetch('api/cart_action.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'action=toggle_wishlist&product_id=' + productId
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      const icon = btn.querySelector('i');
      if (data.wishlisted) {
        btn.classList.add('wishlisted');
        icon.className = 'fas fa-heart';
        showToast(data.message, 'success');
      } else {
        btn.classList.remove('wishlisted');
        icon.className = 'far fa-heart';
        showToast(data.message, 'info');
      }
    }
  })
  .catch(() => showToast('Wishlist error.', 'error'));
}

// ── Sort ──
function applySort(val) {
  const url = new URL(window.location.href);
  url.searchParams.set('sort', val);
  window.location.href = url.toString();
}

// ── Price slider label ──
function updatePriceLabel(val) {
  document.getElementById('priceMax').textContent = '$' + val;
}
</script>

<?php include 'include/footer.php'; ?>