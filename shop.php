<?php
$pageTitle = "Shop - Hudders Hub";
include 'include/header.php';
?>

<section class="shop-section">
  <div class="shop-header">
    <h1>Shop</h1>
  </div>

  <div class="shop-layout">
    <!-- Sidebar Filters -->
    <aside class="shop-sidebar">
      <h3>Categories</h3>
      <ul>
        <li><a href="#">Bakery Items</a></li>
        <li><a href="#">Grocery</a></li>
        <li><a href="#">Fish Items</a></li>
        <li><a href="#">Frozen Meat</a></li>
        <li><a href="#">Delicatessen</a></li>
      </ul>

      <h3>Price Range</h3>
      <input type="range" min="5" max="200" value="50" class="price-slider">
      <p>$5 – $200</p>
      <button class="btn btn-green">Apply Filter</button>
    </aside>

    <!-- Product Grid -->
    <div class="shop-products">
      <div class="product-card">
        <img src="assets/css/image/orange.png" alt="Orange">
        <h4>Lorem Ipsum</h4>
        <p>⭐⭐⭐⭐☆</p>
        <p class="price">$10.00</p>
      </div>

      <div class="product-card">
        <img src="assets/css/image/banana.png" alt="Banana">
        <h4>Lorem Ipsum</h4>
        <p>⭐⭐⭐☆☆</p>
        <p class="price">$8.00</p>
      </div>

      <div class="product-card">
        <img src="assets/css/image/pineapple.png" alt="Pineapple">
        <h4>Lorem Ipsum</h4>
        <p>⭐⭐⭐⭐⭐</p>
        <p class="price">$15.00 <span class="discount">$20.00</span></p>
      </div>

      <div class="product-card">
        <img src="assets/css/image/pomegranate.png" alt="Pomegranate">
        <h4>Lorem Ipsum</h4>
        <p>⭐⭐⭐⭐☆</p>
        <p class="price">$12.00</p>
      </div>

      <!-- Add more product cards as needed -->
    </div>
  </div>
</section>

<?php include 'include/footer.php'; ?>
