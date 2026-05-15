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
    <div class="traders-section-header">
      <h2>OUR TRADERS</h2>
    </div>
  </div>
  <div class="traders-grid-custom">
    <div class="trader-card-custom">
      <div class="trader-custom-bg"></div>
      <div class="trader-custom-img">
        <img src="assets/css/image/greengrocer.jpg" alt="Greens & Roots">
      </div>
      <div class="trader-custom-content">
        <div class="trader-custom-badge">VEGETABLES</div>
        <div class="trader-custom-text">
          <strong>Greens & Roots</strong><br>
          Fresh seasonal fruit and vegetables direct from local farms. Ensuring the highest quality produce for your family.
        </div>
        <a href="shop.php" class="trader-custom-arrow"><i class="fas fa-arrow-right"></i></a>
      </div>
    </div>
    
    <div class="trader-card-custom">
      <div class="trader-custom-bg"></div>
      <div class="trader-custom-img">
        <img src="assets/css/image/fishmonger.jpeg" alt="The Harbour Fish Co.">
      </div>
      <div class="trader-custom-content">
        <div class="trader-custom-badge">SEAFOOD</div>
        <div class="trader-custom-text">
          <strong>The Harbour Fish Co.</strong><br>
          Fresh catch delivered daily from the coast. A fine selection of locally sourced fish and seafood prepared daily.
        </div>
        <a href="shop.php" class="trader-custom-arrow"><i class="fas fa-arrow-right"></i></a>
      </div>
    </div>

    <div class="trader-card-custom">
      <div class="trader-custom-bg"></div>
      <div class="trader-custom-img">
        <img src="assets/css/image/bakery.jpeg" alt="The Old Mill Bakery">
      </div>
      <div class="trader-custom-content">
        <div class="trader-custom-badge">BAKERY</div>
        <div class="trader-custom-text">
          <strong>The Old Mill Bakery</strong><br>
          Artisan breads baked fresh each morning. Speciality sourdoughs, pastries, and sweet treats crafted with care.
        </div>
        <a href="shop.php" class="trader-custom-arrow"><i class="fas fa-arrow-right"></i></a>
      </div>
    </div>

    <div class="trader-card-custom">
      <div class="trader-custom-bg"></div>
      <div class="trader-custom-img">
        <img src="assets/css/image/butcher.jpeg" alt="Hendersons Butchers">
      </div>
      <div class="trader-custom-content">
        <div class="trader-custom-badge">MEAT</div>
        <div class="trader-custom-text">
          <strong>Hendersons Butchers</strong><br>
          Family-run butchers with 40 years tradition. Providing premium cuts of locally reared, free-range meats.
        </div>
        <a href="shop.php" class="trader-custom-arrow"><i class="fas fa-arrow-right"></i></a>
      </div>
    </div>

    <div class="trader-card-custom">
      <div class="trader-custom-bg"></div>
      <div class="trader-custom-img">
        <img src="assets/css/image/deli.jpeg" alt="La Belle Delicatessen">
      </div>
      <div class="trader-custom-content">
        <div class="trader-custom-badge">DELICATESSEN</div>
        <div class="trader-custom-text">
          <strong>La Belle Delicatessen</strong><br>
          Continental cheeses and fine foods. Discover our curated collection of gourmet charcuterie and luxury hampers.
        </div>
        <a href="shop.php" class="trader-custom-arrow"><i class="fas fa-arrow-right"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- FEATURED PRODUCTS -->
<section class="featured-section">
  <div class="container">
    <div class="traders-section-header featured-header">
      <h2><span>FEATURED</span> PRODUCTS</h2>
    </div>
  </div>

  <div class="products-grid">

    <div class="product-card">
      <div class="product-img">
        <a href="product_detail.php?id=5"><img src="assets/css/image/broccoli.png" alt="Broccoli"></a>
      </div>
      <h3><a href="product_detail.php?id=5">Broccoli</a></h3>
      <div class="stars">
        <span style="color:#D4A017;">★★★★☆</span>
        <span style="font-size:0.8rem;color:#333;">4.5/5</span>
      </div>
      <div style="display:flex;justify-content:center;margin-top:0.5rem;">
        <a href="product_detail.php?id=5" class="btn btn-green">Buy Now</a>
      </div>
    </div>

    <div class="product-card">
      <div class="product-img">
        <a href="product_detail.php?id=7"><img src="assets/css/image/salmon.png" alt="Salmon"></a>
      </div>
      <h3><a href="product_detail.php?id=7">Salmon</a></h3>
      <div class="stars">
        <span style="color:#D4A017;">★★★★★</span>
        <span style="font-size:0.8rem;color:#333;">5.0/5</span>
      </div>
      <div style="display:flex;justify-content:center;margin-top:0.5rem;">
        <a href="product_detail.php?id=7" class="btn btn-green">Buy Now</a>
      </div>
    </div>

    <div class="product-card">
      <div class="product-img">
        <a href="product_detail.php?id=9"><img src="assets/css/image/sourdough.png" alt="Sourdough"></a>
      </div>
      <h3><a href="product_detail.php?id=9">Sourdough</a></h3>
      <div class="stars">
        <span style="color:#D4A017;">★★★☆☆</span>
        <span style="font-size:0.8rem;color:#333;">3.5/5</span>
      </div>
      <div style="display:flex;justify-content:center;margin-top:0.5rem;">
        <a href="product_detail.php?id=9" class="btn btn-green">Buy Now</a>
      </div>
    </div>

    <div class="product-card">
      <div class="product-img">
        <a href="product_detail.php?id=8"><img src="assets/css/image/steak.png" alt="Steak"></a>
      </div>
      <h3><a href="product_detail.php?id=8">Steak</a></h3>
      <div class="stars">
        <span style="color:#D4A017;">★★★★☆</span>
        <span style="font-size:0.8rem;color:#333;">4.0/5</span>
      </div>
      <div style="display:flex;justify-content:center;margin-top:0.5rem;">
        <a href="product_detail.php?id=8" class="btn btn-green">Buy Now</a>
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