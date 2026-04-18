<?php
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
        <a href="customer/shop.php" class="btn btn-dark">Shop Now</a>
        <a href="about.php" class="btn btn-outline-dark">About Us</a>
      </div>
    </div>

    <!-- Right Image -->
    <div class="hero-image">
      <img src="assets\css\image\market-hero.png" alt="Hudders Hub Market">
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
      <div class="trader-info"><span class="trader-name">Greens & Roots</span><p>Fresh seasonal fruit and vegetables direct from local farms.</p></div>
    </div>
    <div class="trader-card">
      <div class="trader-img"><img src="assets/css/image/fishmonger.jpeg" alt="Fishmonger"></div>
      <div class="trader-info"><span class="trader-name">The Harbour Fish Co.</span><p>Fresh catch delivered daily from the coast.</p></div>
    </div>
    <div class="trader-card">
      <div class="trader-img"><img src="assets/css/image/bakery.jpeg" alt="Bakery"></div>
      <div class="trader-info"><span class="trader-name">The Old Mill Bakery</span><p>Artisan breads baked fresh each morning.</p></div>
    </div>
    <div class="trader-card">
      <div class="trader-img"><img src="assets/css/image/butcher.jpeg" alt="Butcher"></div>
      <div class="trader-info"><span class="trader-name">Hendersons Butchers</span><p>Family-run butchers with 40 years tradition.</p></div>
    </div>
    <div class="trader-card">
      <div class="trader-img"><img src="assets/css/image/deli.jpeg" alt="Delicatessen"></div>
      <div class="trader-info"><span class="trader-name">La Belle Delicatessen</span><p>Continental cheeses and fine foods.</p></div>
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
        <img src="assets/css/image/broccoli.png" alt="Broccoli">
      </div>
      <h3>Broccoli</h3>
      <div class="stars">
        <span>★★★★☆</span>
        <span>4.5/5</span>
      </div>
      <a href="customer/shop.php" class="btn btn-green btn-sm">Buy Now</a>
    </div>

    <div class="product-card">
      <div class="product-img">
        <img src="assets/css/image/salmon.png" alt="Salmon">
      </div>
      <h3>Salmon</h3>
      <div class="stars">
        <span>★★★★☆</span>
        <span>4.5/5</span>
      </div>
      <a href="customer/shop.php" class="btn btn-green btn-sm">Buy Now</a>
    </div>

    <div class="product-card">
      <div class="product-img">
        <img src="assets/css/image/sourdough.png" alt="Sourdough">
      </div>
      <h3>Sourdough</h3>
      <div class="stars">
        <span>★★★★☆</span>
        <span>4.5/5</span>
      </div>
      <a href="customer/shop.php" class="btn btn-green btn-sm">Buy Now</a>
    </div>

    <div class="product-card">
      <div class="product-img">
        <img src="assets/css/image/steak.png" alt="Steak">
      </div>
      <h3>Steak</h3>
      <div class="stars">
        <span>★★★★☆</span>
        <span>4.5/5</span>
      </div>
      <a href="customer/shop.php" class="btn btn-green btn-sm">Buy Now</a>
    </div>

  </div>
</section>


<?php include 'include/footer.php'; ?>
