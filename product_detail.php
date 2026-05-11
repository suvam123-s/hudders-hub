<?php
session_start();

// ── Product Data ──
$products = [
    1 => [
        'name'    => 'Broccoli',
        'price'   => 2.50,
        'image'   => 'assets/css/image/broccoli.png',
        'rating'  => 4,
        'desc'    => 'Fresh organic broccoli sourced from local farms in Cleckhudderfax. Rich in vitamins C and K, this vibrant green vegetable is perfect for stir-fries, steaming, or roasting. Our broccoli is hand-picked at peak freshness to ensure the best taste and nutritional value. Each head is carefully inspected for quality before making it to our shelves.',
        'allergy' => 'No known allergens. However, please wash thoroughly before consumption.',
    ],
    2 => [
        'name'    => 'Salmon',
        'price'   => 12.99,
        'image'   => 'assets/css/image/salmon.png',
        'rating'  => 5,
        'desc'    => 'Premium Atlantic salmon fillet delivered fresh daily from The Harbour Fish Co. Rich in omega-3 fatty acids and high-quality protein. Our salmon is sustainably sourced and perfect for grilling, baking, or pan-searing. Each fillet is carefully trimmed and deboned for your convenience.',
        'allergy' => 'Contains: Fish. May contain traces of crustaceans and molluscs. Not suitable for those with fish allergies.',
    ],
    3 => [
        'name'    => 'Sourdough',
        'price'   => 4.50,
        'image'   => 'assets/css/image/sourdough.png',
        'rating'  => 4,
        'desc'    => 'Artisan sourdough bread baked fresh each morning at The Old Mill Bakery. Made using a traditional 48-hour fermentation process with our 25-year-old starter culture. The result is a beautifully crusty loaf with a soft, tangy interior. Perfect for sandwiches, toast, or simply enjoyed with butter.',
        'allergy' => 'Contains: Wheat (Gluten). May contain traces of milk, eggs, sesame, and nuts. Produced in a bakery that handles multiple allergens.',
    ],
    4 => [
        'name'    => 'Steak',
        'price'   => 15.99,
        'image'   => 'assets/css/image/steak.png',
        'rating'  => 5,
        'desc'    => 'Premium 28-day aged sirloin steak from Hendersons Butchers. Our beef is sourced from grass-fed cattle raised on local Yorkshire farms. Each cut is hand-selected by our master butcher for optimal marbling and tenderness. Perfect for grilling or pan-frying to your preferred doneness.',
        'allergy' => 'No known allergens. Suitable for most diets. Please note this product is processed in a facility that also handles other meats.',
    ],
];

// ── Get product from URL ──
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!isset($products[$id])) {
    header('Location: index.php');
    exit;
}

$product = $products[$id];
$pageTitle = htmlspecialchars($product['name']) . ' – Hudders Hub';

$stars = str_repeat('★', $product['rating']) . str_repeat('☆', 5 - $product['rating']);

$similar = array_filter($products, function($key) use ($id) {
    return $key !== $id;
}, ARRAY_FILTER_USE_KEY);
?>
<?php include 'include/header.php'; ?>

<style>
  body { background: var(--beige-light); }
</style>

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
      <p class="product-detail-price">Price: <strong>$<?= number_format($product['price'], 2) ?></strong></p>
      <div class="product-detail-stars"><?= $stars ?></div>
      <p class="product-detail-desc">
        <?= htmlspecialchars($product['desc']) ?>
      </p>
      <p class="product-detail-allergy">
        <strong>Allergy Information:</strong> <?= htmlspecialchars($product['allergy']) ?>
      </p>
      <div class="product-detail-actions">
        <!-- FIX: wrapped in a form that POSTs to cart.php -->
        <form method="POST" action="cart.php">
          <input type="hidden" name="action" value="add">
          <input type="hidden" name="product_id" value="<?= $id ?>">
          <button type="submit" class="product-detail-btn-cart">ADD TO CART</button>
        </form>
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
          <!-- FIX: now a real form instead of a link wrapping a button -->
          <form method="POST" action="cart.php">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="product_id" value="<?= $simId ?>">
            <button type="submit" class="product-detail-sim-cart-btn">🛒 ADD TO CART</button>
          </form>
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

    <div class="product-detail-review-card">
      <div class="product-detail-review-header">
        <div>
          <h4 class="product-detail-reviewer">Rachana Aryal</h4>
          <div class="product-detail-review-stars">★★★</div>
        </div>
        <span class="product-detail-review-date">4 May 2026</span>
      </div>
      <p class="product-detail-review-text">
        Excellent quality <?= htmlspecialchars($product['name']) ?>! Very fresh and well-packaged. Arrived in perfect condition and tasted wonderful. Will definitely order again from Hudders Hub Market.
      </p>
    </div>

    <div class="product-detail-review-card">
      <div class="product-detail-review-header">
        <div>
          <h4 class="product-detail-reviewer">Smriti Shrestha</h4>
          <div class="product-detail-review-stars">★★★★</div>
        </div>
        <span class="product-detail-review-date">2 May 2026</span>
      </div>
      <p class="product-detail-review-text">
        Great <?= htmlspecialchars($product['name']) ?> at a fair price. The quality is consistently good every time I order. Love supporting local traders through this platform. Highly recommended!
      </p>
    </div>

  </div>
</section>

<?php include 'include/footer.php'; ?>

