<?php
session_start();
$pageTitle = "Shop - Hudders Hub";

// Initialize session arrays
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
if (!isset($_SESSION['wishlist'])) $_SESSION['wishlist'] = [];

// ── Master product catalog ──
$products = [
    1 => [
        'name' => 'Orange', 'price' => 145, 'image' => 'assets/css/image/orange.jpg',
        'rating' => 3.5, 'category' => 'grocery', 'old_price' => null,
    ],
    2 => [
        'name' => 'Banana', 'price' => 180, 'image' => 'assets/css/image/bannan.png',
        'rating' => 4.5, 'category' => 'grocery', 'old_price' => null,
    ],
    3 => [
        'name' => 'Pineapple', 'price' => 120, 'image' => 'assets/css/image/pineapple.jpg',
        'rating' => 5.0, 'category' => 'grocery', 'old_price' => 150,
    ],
    4 => [
        'name' => 'Pomegranate', 'price' => 240, 'image' => 'assets/css/image/fomegranate.jpg',
        'rating' => 3.5, 'category' => 'grocery', 'old_price' => 260,
    ],
    5 => [
        'name' => 'Broccoli', 'price' => 180, 'image' => 'assets/css/image/broccoli.png',
        'rating' => 4.5, 'category' => 'grocery', 'old_price' => null,
    ],
    6 => [
        'name' => 'Cauliflower', 'price' => 130, 'image' => 'assets/css/image/cauliflower.png',
        'rating' => 4.5, 'category' => 'grocery', 'old_price' => 160,
    ],
    7 => [
        'name' => 'Salmon', 'price' => 212, 'image' => 'assets/css/image/salmon.png',
        'rating' => 5.0, 'category' => 'fish', 'old_price' => 232,
    ],
    8 => [
        'name' => 'Steak', 'price' => 145, 'image' => 'assets/css/image/steak.png',
        'rating' => 4.0, 'category' => 'frozen_meat', 'old_price' => null,
    ],
    9 => [
        'name' => 'Sourdough', 'price' => 80, 'image' => 'assets/css/image/sourdough.png',
        'rating' => 3.5, 'category' => 'bakery', 'old_price' => null,
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
$max_price    = isset($_GET['max_price']) ? (int)$_GET['max_price'] : 260;
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
            <input type="range" id="priceRange" name="max_price" min="5" max="260" value="<?= $max_price ?>" class="price-slider" oninput="updatePriceLabel(this.value)">
            <div class="price-labels">
              <span>$5</span>
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