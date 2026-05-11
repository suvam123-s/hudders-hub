<?php
session_start();
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
if (!isset($_SESSION['wishlist'])) $_SESSION['wishlist'] = [];

$pageTitle = 'Your Local Market, Now Online';
include 'include/header.php';
?>

<section class="hero">
  <div class="hero-inner">

    <!-- Left Text -->
    <div class="hero-text">
      <span class="hero-tag">FRESH LOCAL PRODUCE</span>
      <h1>
        Your Local Market,<br>
        <span class="hero-green">Now Online</span>
      </h1>
      <p>
        Shop fresh produce from Cleckhudderfax's finest independent
        traders, Butcher, fishmonger, bakery and deli all in one basket.
      </p>
      <div class="hero-btns">
        <a href="shop.php" class="btn btn-dark">Shop Now</a>
        <a href="aboutus.php" class="btn btn-outline-dark">About Us</a>
      </div>
    </div>

    <!-- Right Image -->
    <div class="hero-image">
      <img src="assets/css/image/market-hero.png" alt="Hudders Hub Market">
    </div>

  </div>
</section>


<!-- OUR TRADERS -->
<section class="traders-section">
  <div class="container">
    <h2>OUR TRADERS</h2>
    <div class="section-divider"></div>
  </div>
  <div class="traders-grid">
    <div class="trader-card">
      <div class="trader-img"><img src="assets/css/image/greengrocer.jpg" alt="Greengrocer"></div>
      <div class="trader-info"><span class="trader-name">Greens & Roots</span>
        <p>Fresh seasonal fruit and vegetables direct from local farms.</p>
      </div>
    </div>
    <div class="trader-card">
      <div class="trader-img"><img src="assets/css/image/fishmonger.jpeg" alt="Fishmonger"></div>
      <div class="trader-info"><span class="trader-name">The Harbour Fish Co.</span>
        <p>Fresh catch delivered daily from the coast.</p>
      </div>
    </div>
    <div class="trader-card">
      <div class="trader-img"><img src="assets/css/image/bakery.jpeg" alt="Bakery"></div>
      <div class="trader-info"><span class="trader-name">The Old Mill Bakery</span>
        <p>Artisan breads baked fresh each morning.</p>
      </div>
    </div>
    <div class="trader-card">
      <div class="trader-img"><img src="assets/css/image/butcher.jpeg" alt="Butcher"></div>
      <div class="trader-info"><span class="trader-name">Hendersons Butchers</span>
        <p>Family-run butchers with 40 years tradition.</p>
      </div>
    </div>
    <div class="trader-card">
      <div class="trader-img"><img src="assets/css/image/deli.jpeg" alt="Delicatessen"></div>
      <div class="trader-info"><span class="trader-name">La Belle Delicatessen</span>
        <p>Continental cheeses and fine foods.</p>
      </div>
    </div>
  </div>
</section>

<!-- FEATURED PRODUCTS -->
<section class="featured-section">
  <div class="section-header">
    <h2><span>FEATURED</span> PRODUCTS</h2>
    <div class="section-divider"></div>
  </div>

  <div class="products-grid">

    <div class="product-card">
      <div class="product-img">
        <a href="product_detail.php?id=5"><img src="assets/css/image/broccoli.png" alt="Broccoli"></a>
      </div>
      <h3><a href="product_detail.php?id=5">Broccoli</a></h3>
      <div class="stars">
        <span>★★★★☆</span>
        <span>4.5/5</span>
      </div>
      <div style="display:flex;gap:8px;justify-content:center;flex-wrap:wrap;">
        <a href="product_detail.php?id=5" class="btn btn-green btn-sm">Buy Now</a>
        <button class="btn btn-sm btn-outline" onclick="quickAdd(5, this)">
          <i class="fas fa-cart-plus"></i> Add
        </button>
      </div>
    </div>

    <div class="product-card">
      <div class="product-img">
        <a href="product_detail.php?id=7"><img src="assets/css/image/salmon.png" alt="Salmon"></a>
      </div>
      <h3><a href="product_detail.php?id=7">Salmon</a></h3>
      <div class="stars">
        <span>★★★★★</span>
        <span>5.0/5</span>
      </div>
      <div style="display:flex;gap:8px;justify-content:center;flex-wrap:wrap;">
        <a href="product_detail.php?id=7" class="btn btn-green btn-sm">Buy Now</a>
        <button class="btn btn-sm btn-outline" onclick="quickAdd(7, this)">
          <i class="fas fa-cart-plus"></i> Add
        </button>
      </div>
    </div>

    <div class="product-card">
      <div class="product-img">
        <a href="product_detail.php?id=9"><img src="assets/css/image/sourdough.png" alt="Sourdough"></a>
      </div>
      <h3><a href="product_detail.php?id=9">Sourdough</a></h3>
      <div class="stars">
        <span>★★★☆☆</span>
        <span>3.5/5</span>
      </div>
      <div style="display:flex;gap:8px;justify-content:center;flex-wrap:wrap;">
        <a href="product_detail.php?id=9" class="btn btn-green btn-sm">Buy Now</a>
        <button class="btn btn-sm btn-outline" onclick="quickAdd(9, this)">
          <i class="fas fa-cart-plus"></i> Add
        </button>
      </div>
    </div>

    <div class="product-card">
      <div class="product-img">
        <a href="product_detail.php?id=8"><img src="assets/css/image/steak.png" alt="Steak"></a>
      </div>
      <h3><a href="product_detail.php?id=8">Steak</a></h3>
      <div class="stars">
        <span>★★★★☆</span>
        <span>4.0/5</span>
      </div>
      <div style="display:flex;gap:8px;justify-content:center;flex-wrap:wrap;">
        <a href="product_detail.php?id=8" class="btn btn-green btn-sm">Buy Now</a>
        <button class="btn btn-sm btn-outline" onclick="quickAdd(8, this)">
          <i class="fas fa-cart-plus"></i> Add
        </button>
      </div>
    </div>

  </div>
</section>

<!-- ═══ Toast ═══ -->
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

function quickAdd(productId, btn) {
  btn.disabled = true;
  const origHTML = btn.innerHTML;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

  fetch('api/cart_action.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'action=add_to_cart&product_id=' + productId + '&qty=1'
  })
  .then(r => r.json())
  .then(data => {
    if (data.success) {
      showToast(data.message, 'success');
      const badge = document.getElementById('cartBadge');
      if (badge) { badge.textContent = data.cart_count; badge.style.display = 'flex'; }
      btn.innerHTML = '<i class="fas fa-check"></i> Added';
      setTimeout(() => { btn.innerHTML = origHTML; btn.disabled = false; }, 1500);
    } else {
      showToast(data.message || 'Error', 'error');
      btn.innerHTML = origHTML; btn.disabled = false;
    }
  })
  .catch(() => {
    showToast('Network error', 'error');
    btn.innerHTML = origHTML; btn.disabled = false;
  });
}
</script>

<?php include 'include/footer.php'; ?>