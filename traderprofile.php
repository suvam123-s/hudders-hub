<?php
session_start();
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
if (!isset($_SESSION['wishlist'])) $_SESSION['wishlist'] = [];

// ── Static trader/shop data (mirrors HHM.sql seed data) ──
$traders = [
  1 => [
    'name'        => 'James Morrison',
    'username'    => 'jmorrison',
    'email'       => 'james@thebutcher.co.uk',
    'phone'       => '07711 223 344',
    'member_since'=> 'January 2020',
    'trader_id'   => '1001',
    'shop_name'   => 'Hendersons Butchers',
    'shop_type'   => 'MEAT',
    'shop_location'=> '8 Market Place, Cleckhuddersfax HD2 1AB',
    'shop_desc'   => 'Family-run butchers with 40 years tradition. Providing premium cuts of locally reared, free-range meats. Est. 1987.',
    'shop_image'  => 'assets/css/image/butcher.jpeg',
    'badge_color' => '#7c3a1e',
    'products'    => [
      ['name'=>'Prime Sirloin Steak','price'=>8.50,'image'=>'assets/css/image/steak.png','id'=>8,'rating'=>4.0],
    ],
  ],
  2 => [
    'name'        => 'Sarah Greenway',
    'username'    => 'sgreenway',
    'email'       => 'sarah@greengrocers.co.uk',
    'phone'       => '07722 334 455',
    'member_since'=> 'March 2020',
    'trader_id'   => '1002',
    'shop_name'   => 'Greens & Roots',
    'shop_type'   => 'VEGETABLES',
    'shop_location'=> '14 High Street, Cleckhuddersfax HD2 1AC',
    'shop_desc'   => 'Fresh seasonal fruit and vegetables direct from local farms. Ensuring the highest quality produce for your family.',
    'shop_image'  => 'assets/css/image/greengrocer.jpg',
    'badge_color' => '#3a6b2a',
    'products'    => [
      ['name'=>'Organic Broccoli','price'=>1.20,'image'=>'assets/css/image/broccoli.png','id'=>5,'rating'=>4.5],
    ],
  ],
  3 => [
    'name'        => 'Pete Fisher',
    'username'    => 'pfisher',
    'email'       => 'pete@fishmonger.co.uk',
    'phone'       => '07733 445 566',
    'member_since'=> 'June 2019',
    'trader_id'   => '1003',
    'shop_name'   => 'The Harbour Fish Co.',
    'shop_type'   => 'SEAFOOD',
    'shop_location'=> '3 Riverside Lane, Cleckhuddersfax HD2 1AD',
    'shop_desc'   => 'Fresh catch delivered daily from the coast. A fine selection of locally sourced fish and seafood prepared daily.',
    'shop_image'  => 'assets/css/image/fishmonger.jpeg',
    'badge_color' => '#1e4a6b',
    'products'    => [
      ['name'=>'Fresh Salmon Fillet','price'=>6.90,'image'=>'assets/css/image/salmon.png','id'=>7,'rating'=>5.0],
    ],
  ],
  4 => [
    'name'        => 'Anne Baker',
    'username'    => 'abaker',
    'email'       => 'anne@huddershub-bakery.co.uk',
    'phone'       => '07744 556 677',
    'member_since'=> 'February 2021',
    'trader_id'   => '1004',
    'shop_name'   => 'The Old Mill Bakery',
    'shop_type'   => 'BAKERY',
    'shop_location'=> '22 Church Street, Cleckhuddersfax HD2 1AE',
    'shop_desc'   => 'Artisan breads baked fresh each morning. Speciality sourdoughs, pastries, and sweet treats crafted with care.',
    'shop_image'  => 'assets/css/image/bakery.jpeg',
    'badge_color' => '#6b4f1e',
    'products'    => [
      ['name'=>'Sourdough Loaf','price'=>3.50,'image'=>'assets/css/image/sourdough.png','id'=>9,'rating'=>3.5],
    ],
  ],
  5 => [
    'name'        => 'Marco DelVecchio',
    'username'    => 'mdelvecchio',
    'email'       => 'marco@deli.co.uk',
    'phone'       => '07755 667 788',
    'member_since'=> 'September 2020',
    'trader_id'   => '1005',
    'shop_name'   => 'La Belle Delicatessen',
    'shop_type'   => 'DELICATESSEN',
    'shop_location'=> '5 Old Square, Cleckhuddersfax HD2 1AF',
    'shop_desc'   => 'Continental cheeses and fine foods. Discover our curated collection of gourmet charcuterie and luxury hampers.',
    'shop_image'  => 'assets/css/image/deli.jpeg',
    'badge_color' => '#5a1e6b',
    'products'    => [
      ['name'=>'Mature Cheddar','price'=>4.20,'image'=>'assets/css/image/cheese.jpg','id'=>15,'rating'=>4.7],
    ],
  ],
];

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!isset($traders[$id])) {
  header('Location: index.php');
  exit;
}

$t = $traders[$id];
$pageTitle = $t['shop_name'] . ' — Hudders Hub';
include 'include/header.php';
?>

<style>
/* ── Trader Profile Page ── */
.tp-page { background: var(--beige-light); min-height: 100vh; padding-bottom: 4rem; }

/* Hero banner */
.tp-hero {
  background: linear-gradient(135deg, #4a5e32 0%, #2C3A1E 100%);
  padding: 3.5rem 0 2rem;
  position: relative;
  overflow: hidden;
}
.tp-hero::before {
  content: '';
  position: absolute; inset: 0;
  background: url('<?= htmlspecialchars($t['shop_image']) ?>') center/cover no-repeat;
  opacity: 0.12;
}
.tp-hero-inner {
  max-width: var(--max-width); margin: 0 auto; padding: 0 2rem;
  display: flex; align-items: center; gap: 2rem; position: relative; z-index: 1;
}
.tp-avatar {
  width: 110px; height: 110px; border-radius: 50%;
  border: 4px solid rgba(255,255,255,0.35);
  background: #aeb9a2;
  display: flex; align-items: center; justify-content: center;
  font-size: 2.8rem; color: #fff; font-family: var(--font-display);
  font-weight: 700; flex-shrink: 0;
  box-shadow: 0 8px 24px rgba(0,0,0,0.25);
}
.tp-hero-info { flex: 1; }
.tp-hero-info h1 {
  font-family: var(--font-display); font-size: 2rem; color: #fff;
  margin-bottom: 0.25rem; font-weight: 700;
}
.tp-hero-info .tp-email { color: rgba(255,255,255,0.75); font-size: 0.9rem; margin-bottom: 0.6rem; }
.tp-hero-meta { display: flex; gap: 2rem; flex-wrap: wrap; }
.tp-hero-meta span { font-size: 0.82rem; color: rgba(255,255,255,0.8); display: flex; align-items: center; gap: 0.4rem; }
.tp-hero-meta span i { color: #a8c97f; }
.tp-badge-hero {
  background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25);
  color: #fff; font-size: 0.7rem; font-weight: 700; letter-spacing: 1px;
  padding: 0.4rem 1rem; border-radius: 20px; backdrop-filter: blur(4px);
  align-self: flex-start;
}

/* Breadcrumb */
.tp-breadcrumb {
  max-width: var(--max-width); margin: 1.5rem auto 0; padding: 0 2rem;
  font-size: 0.82rem; color: var(--grey);
}
.tp-breadcrumb a { color: var(--olive); transition: color 0.2s; }
.tp-breadcrumb a:hover { color: var(--dark-green); }
.tp-breadcrumb span { margin: 0 0.4rem; color: #bbb; }

/* Layout */
.tp-body {
  max-width: var(--max-width); margin: 2rem auto 0; padding: 0 2rem;
  display: grid; grid-template-columns: 300px 1fr; gap: 2rem;
}
@media(max-width:780px){ .tp-body { grid-template-columns: 1fr; } }

/* Sidebar */
.tp-sidebar {}
.tp-card {
  background: #fff; border-radius: 14px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.07);
  overflow: hidden; margin-bottom: 1.5rem;
}
.tp-card-header {
  background: linear-gradient(135deg,#4a5e32,#2C3A1E);
  color: #fff; padding: 1rem 1.4rem;
  font-family: var(--font-display); font-size: 1rem; font-weight: 600;
  display: flex; align-items: center; gap: 0.6rem;
}
.tp-card-header i { opacity: 0.8; }
.tp-card-body { padding: 1.2rem 1.4rem; }

.tp-shop-img {
  width: 100%; height: 180px; object-fit: cover;
  border-radius: 10px; margin-bottom: 1rem;
  box-shadow: 0 4px 14px rgba(0,0,0,0.1);
}
.tp-shop-name {
  font-family: var(--font-display); font-size: 1.25rem; color: var(--dark-green);
  margin-bottom: 0.2rem; font-weight: 700;
}
.tp-shop-type-badge {
  display: inline-block; font-size: 0.62rem; font-weight: 700; letter-spacing: 1px;
  padding: 0.3rem 0.85rem; border-radius: 20px; color: #fff; margin-bottom: 0.8rem;
}
.tp-shop-desc { font-size: 0.82rem; color: var(--grey); line-height: 1.65; margin-bottom: 1rem; }
.tp-info-row { display: flex; align-items: flex-start; gap: 0.7rem; margin-bottom: 0.75rem; font-size: 0.84rem; color: #444; }
.tp-info-row i { color: var(--olive); width: 16px; margin-top: 2px; flex-shrink: 0; }
.tp-stat-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.8rem; }
.tp-stat {
  background: #f5f2e8; border-radius: 10px; padding: 0.9rem;
  text-align: center;
}
.tp-stat-num { font-size: 1.4rem; font-weight: 700; color: var(--dark-green); font-family: var(--font-display); }
.tp-stat-label { font-size: 0.7rem; color: var(--grey); margin-top: 0.2rem; }

/* Main content */
.tp-main {}
.tp-section-title {
  font-family: var(--font-display); font-size: 1.3rem; color: var(--dark-green);
  font-weight: 700; margin-bottom: 1.2rem;
  display: flex; align-items: center; gap: 0.7rem;
}
.tp-section-title::after {
  content: ''; flex: 1; height: 1px; background: #ddd8c4;
}

/* Products grid */
.tp-products-grid {
  display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
  gap: 1.2rem; margin-bottom: 2.5rem;
}
.tp-prod-card {
  background: #fff; border-radius: 12px;
  box-shadow: 0 3px 14px rgba(0,0,0,0.07);
  overflow: hidden; transition: transform 0.2s, box-shadow 0.2s;
  text-decoration: none; color: inherit;
}
.tp-prod-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.12); }
.tp-prod-img { height: 130px; background: #f5f2e8; display: flex; align-items: center; justify-content: center; }
.tp-prod-img img { height: 110px; object-fit: contain; }
.tp-prod-body { padding: 0.9rem; }
.tp-prod-name { font-weight: 600; font-size: 0.88rem; color: var(--dark-green); margin-bottom: 0.25rem; }
.tp-prod-price { font-size: 0.9rem; font-weight: 700; color: var(--olive); margin-bottom: 0.5rem; }
.tp-prod-stars { font-size: 0.78rem; color: var(--star); margin-bottom: 0.7rem; }
.tp-prod-btn {
  display: block; width: 100%; text-align: center;
  background: var(--dark-green); color: #fff;
  border: none; border-radius: 20px; padding: 0.45rem 0; font-size: 0.78rem;
  font-weight: 600; cursor: pointer; transition: background 0.2s; font-family: var(--font-body);
}
.tp-prod-btn:hover { background: var(--olive); }

/* About section */
.tp-about-card {
  background: #fff; border-radius: 14px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.07);
  overflow: hidden; margin-bottom: 2rem;
}
.tp-about-body { padding: 1.5rem; }
.tp-about-body p { font-size: 0.9rem; color: #444; line-height: 1.75; margin-bottom: 1rem; }
.tp-about-body p:last-child { margin-bottom: 0; }

/* Contact row */
.tp-contact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
@media(max-width:500px){ .tp-contact-grid { grid-template-columns: 1fr; } }
.tp-contact-item {
  background: #f5f2e8; border-radius: 10px; padding: 1rem 1.2rem;
  display: flex; align-items: center; gap: 0.9rem;
}
.tp-contact-icon {
  width: 38px; height: 38px; border-radius: 50%;
  background: var(--dark-green); color: #fff;
  display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0;
}
.tp-contact-label { font-size: 0.7rem; color: var(--grey); margin-bottom: 0.15rem; }
.tp-contact-value { font-size: 0.85rem; font-weight: 600; color: var(--dark); }

/* CTA */
.tp-cta {
  background: linear-gradient(135deg,#4a5e32,#2C3A1E);
  border-radius: 14px; padding: 2rem; text-align: center; color: #fff; margin-top: 2rem;
}
.tp-cta h3 { font-family: var(--font-display); font-size: 1.4rem; margin-bottom: 0.5rem; }
.tp-cta p { font-size: 0.88rem; opacity: 0.8; margin-bottom: 1.2rem; }
.tp-cta-btn {
  display: inline-flex; align-items: center; gap: 0.5rem;
  background: #fff; color: var(--dark-green);
  padding: 0.65rem 1.8rem; border-radius: 25px;
  font-weight: 700; font-size: 0.88rem; transition: all 0.2s; text-decoration: none;
}
.tp-cta-btn:hover { background: #e8e4cc; transform: translateY(-2px); }

/* Toast */
.shop-toast {
  position: fixed; bottom: 2rem; right: 2rem; z-index: 9999;
  background: var(--dark-green); color: #fff;
  padding: 0.85rem 1.5rem; border-radius: 10px;
  display: flex; align-items: center; gap: 0.7rem;
  font-size: 0.88rem; font-weight: 500;
  box-shadow: 0 8px 24px rgba(0,0,0,0.2);
  opacity: 0; transform: translateY(12px); pointer-events: none;
  transition: opacity 0.3s, transform 0.3s;
}
.shop-toast.show { opacity: 1; transform: translateY(0); pointer-events: auto; }
.shop-toast.error { background: #c0392b; }
.shop-toast.success { background: var(--dark-green); }
</style>

<div class="tp-page">

  <!-- Hero Banner -->
  <div class="tp-hero">
    <div class="tp-hero-inner">
      <div class="tp-avatar"><?= strtoupper(substr($t['name'],0,1)) ?></div>
      <div class="tp-hero-info">
        <h1><?= htmlspecialchars($t['name']) ?></h1>
        <div class="tp-email"><?= htmlspecialchars($t['email']) ?></div>
        <div class="tp-hero-meta">
          <span><i class="fas fa-id-badge"></i> Trader ID: <?= htmlspecialchars($t['trader_id']) ?></span>
          <span><i class="fas fa-calendar-alt"></i> Member since <?= htmlspecialchars($t['member_since']) ?></span>
          <span><i class="fas fa-store"></i> <?= htmlspecialchars($t['shop_name']) ?></span>
        </div>
      </div>
      <div class="tp-badge-hero"><?= htmlspecialchars($t['shop_type']) ?></div>
    </div>
  </div>

  <!-- Breadcrumb -->
  <div class="tp-breadcrumb">
    <a href="index.php">Home</a><span>›</span>
    <a href="index.php#traders">Our Traders</a><span>›</span>
    <?= htmlspecialchars($t['shop_name']) ?>
  </div>

  <!-- Body -->
  <div class="tp-body">

    <!-- Sidebar -->
    <aside class="tp-sidebar">

      <!-- Shop Card -->
      <div class="tp-card">
        <div class="tp-card-header"><i class="fas fa-store"></i> Shop Profile</div>
        <div class="tp-card-body">
          <img src="<?= htmlspecialchars($t['shop_image']) ?>" alt="<?= htmlspecialchars($t['shop_name']) ?>" class="tp-shop-img">
          <div class="tp-shop-name"><?= htmlspecialchars($t['shop_name']) ?></div>
          <span class="tp-shop-type-badge" style="background:<?= htmlspecialchars($t['badge_color']) ?>;"><?= htmlspecialchars($t['shop_type']) ?></span>
          <p class="tp-shop-desc"><?= htmlspecialchars($t['shop_desc']) ?></p>
          <div class="tp-info-row"><i class="fas fa-map-marker-alt"></i><span><?= htmlspecialchars($t['shop_location']) ?></span></div>
          <div class="tp-info-row"><i class="fas fa-phone"></i><span><?= htmlspecialchars($t['phone']) ?></span></div>
          <div class="tp-info-row"><i class="fas fa-envelope"></i><span><?= htmlspecialchars($t['email']) ?></span></div>
        </div>
      </div>

      <!-- Stats -->
      <div class="tp-card">
        <div class="tp-card-header"><i class="fas fa-chart-bar"></i> Shop Stats</div>
        <div class="tp-card-body">
          <div class="tp-stat-grid">
            <div class="tp-stat">
              <div class="tp-stat-num"><?= count($t['products']) ?>+</div>
              <div class="tp-stat-label">Products</div>
            </div>
            <div class="tp-stat">
              <div class="tp-stat-num">★ 4.5</div>
              <div class="tp-stat-label">Avg Rating</div>
            </div>
            <div class="tp-stat">
              <div class="tp-stat-num">100+</div>
              <div class="tp-stat-label">Orders</div>
            </div>
            <div class="tp-stat">
              <div class="tp-stat-num">3</div>
              <div class="tp-stat-label">Slots/Week</div>
            </div>
          </div>
        </div>
      </div>

    </aside>

    <!-- Main Content -->
    <main class="tp-main">

      <!-- About -->
      <div class="tp-section-title"><i class="fas fa-info-circle"></i> About the Shop</div>
      <div class="tp-about-card">
        <div class="tp-about-body">
          <p><?= htmlspecialchars($t['shop_desc']) ?></p>
          <p>Located at <strong><?= htmlspecialchars($t['shop_location']) ?></strong>, <?= htmlspecialchars($t['shop_name']) ?> has been proudly serving the Cleckhudderfax community as part of the Hudders Hub marketplace. Collection slots are available Wednesday, Thursday and Friday.</p>
        </div>
      </div>

      <!-- Contact -->
      <div class="tp-section-title"><i class="fas fa-address-card"></i> Contact Information</div>
      <div class="tp-about-card" style="margin-bottom:2rem;">
        <div class="tp-about-body">
          <div class="tp-contact-grid">
            <div class="tp-contact-item">
              <div class="tp-contact-icon"><i class="fas fa-envelope"></i></div>
              <div>
                <div class="tp-contact-label">Email Address</div>
                <div class="tp-contact-value"><?= htmlspecialchars($t['email']) ?></div>
              </div>
            </div>
            <div class="tp-contact-item">
              <div class="tp-contact-icon"><i class="fas fa-phone"></i></div>
              <div>
                <div class="tp-contact-label">Phone Number</div>
                <div class="tp-contact-value"><?= htmlspecialchars($t['phone']) ?></div>
              </div>
            </div>
            <div class="tp-contact-item">
              <div class="tp-contact-icon"><i class="fas fa-map-marker-alt"></i></div>
              <div>
                <div class="tp-contact-label">Location</div>
                <div class="tp-contact-value"><?= htmlspecialchars($t['shop_location']) ?></div>
              </div>
            </div>
            <div class="tp-contact-item">
              <div class="tp-contact-icon"><i class="fas fa-user"></i></div>
              <div>
                <div class="tp-contact-label">Trader</div>
                <div class="tp-contact-value"><?= htmlspecialchars($t['name']) ?></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Featured Products -->
      <div class="tp-section-title"><i class="fas fa-box-open"></i> Featured Products</div>
      <div class="tp-products-grid">
        <?php foreach($t['products'] as $p):
          $stars_full = floor($p['rating']);
          $has_half   = ($p['rating'] - $stars_full) >= 0.5;
          $stars_empty= 5 - $stars_full - ($has_half ? 1 : 0);
          $stars      = str_repeat('★',$stars_full).($has_half?'½':'').str_repeat('☆',$stars_empty);
        ?>
        <div class="tp-prod-card">
          <div class="tp-prod-img">
            <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
          </div>
          <div class="tp-prod-body">
            <div class="tp-prod-name"><?= htmlspecialchars($p['name']) ?></div>
            <div class="tp-prod-price">£<?= number_format($p['price'],2) ?></div>
            <div class="tp-prod-stars"><?= $stars ?> <?= number_format($p['rating'],1) ?>/5</div>
            <button class="tp-prod-btn" onclick="tpAddCart(<?= (int)$p['id'] ?>, this)">
              <i class="fas fa-cart-plus"></i> Add to Cart
            </button>
          </div>
        </div>
        <?php endforeach; ?>

        <!-- View All card -->
        <a href="shop.php" class="tp-prod-card" style="display:flex;align-items:center;justify-content:center;text-align:center;min-height:220px;background:linear-gradient(135deg,#4a5e32,#2C3A1E);color:#fff;text-decoration:none;">
          <div>
            <i class="fas fa-th" style="font-size:2rem;margin-bottom:0.7rem;opacity:0.8;"></i>
            <div style="font-weight:700;font-size:0.95rem;">View All Products</div>
            <div style="font-size:0.78rem;opacity:0.7;margin-top:0.3rem;">Browse the full shop</div>
          </div>
        </a>
      </div>

      <!-- CTA -->
      <div class="tp-cta">
        <h3>Ready to Order from <?= htmlspecialchars($t['shop_name']) ?>?</h3>
        <p>Fresh, locally sourced produce ready for collection. Shop now and support local traders.</p>
        <a href="shop.php" class="tp-cta-btn"><i class="fas fa-shopping-basket"></i> Shop Now</a>
      </div>

    </main>
  </div>
</div>

<div id="toast" class="shop-toast">
  <i class="fas fa-check-circle"></i>
  <span id="toastMsg"></span>
</div>

<script>
function showToast(msg, type='success'){
  const t=document.getElementById('toast');
  document.getElementById('toastMsg').textContent=msg;
  t.className='shop-toast show '+type;
  setTimeout(()=>{t.className='shop-toast';},2800);
}
function tpAddCart(productId, btn){
  btn.disabled=true;
  const orig=btn.innerHTML;
  btn.innerHTML='<i class="fas fa-spinner fa-spin"></i> Adding…';
  fetch('api/cart_action.php',{
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded'},
    body:'action=add_to_cart&product_id='+productId+'&qty=1'
  })
  .then(r=>r.json())
  .then(data=>{
    if(data.success){
      showToast(data.message,'success');
      const badge=document.getElementById('cartBadge');
      if(badge){badge.textContent=data.cart_count;badge.style.display='flex';}
      btn.innerHTML='<i class="fas fa-check"></i> Added!';
      setTimeout(()=>{btn.innerHTML=orig;btn.disabled=false;},1500);
    } else {
      showToast(data.message||'Error','error');
      btn.innerHTML=orig; btn.disabled=false;
    }
  })
  .catch(()=>{showToast('Network error','error');btn.innerHTML=orig;btn.disabled=false;});
}
</script>

<?php include 'include/footer.php'; ?>
