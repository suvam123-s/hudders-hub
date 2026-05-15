<?php
session_start();
if (empty($_SESSION['order_ref'])) { header('Location: index.php'); exit; }

$ref   = $_SESSION['order_ref'];
$total = $_SESSION['order_total'];
$day   = $_SESSION['order_day'];
$time  = $_SESSION['order_time'];
$items = $_SESSION['order_items'] ?? [];

unset($_SESSION['order_ref'], $_SESSION['order_total'],
      $_SESSION['order_day'], $_SESSION['order_time'], $_SESSION['order_items']);

$pageTitle = 'Order Confirmed – Hudders Hub';
include 'include/header.php';
?>
<link rel="stylesheet" href="assets/css/order_confirmed.css">

<main class="oc-page">

  <!-- animated background blobs -->
  <div class="oc-blob oc-blob1"></div>
  <div class="oc-blob oc-blob2"></div>

  <div class="oc-card">

    <!-- Success icon with ring animation -->
    <div class="oc-icon-wrap">
      <div class="oc-ring"></div>
      <div class="oc-circle"><i class="fas fa-check"></i></div>
    </div>

    <h1 class="oc-title">Order Confirmed!</h1>
    <p class="oc-sub">Your payment was successful and your order has been placed. See you at the market!</p>

    <!-- Reference badge -->
    <div class="oc-ref-badge">
      <span class="oc-ref-label">Order Reference</span>
      <span class="oc-ref-code">#<?= htmlspecialchars($ref, ENT_QUOTES, 'UTF-8') ?></span>
    </div>

    <!-- Detail tiles -->
    <div class="oc-tiles">
      <div class="oc-tile">
        <i class="fas fa-calendar-alt"></i>
        <span class="oc-tile-label">Collection Day</span>
        <span class="oc-tile-val"><?= htmlspecialchars($day, ENT_QUOTES, 'UTF-8') ?></span>
      </div>
      <div class="oc-tile">
        <i class="fas fa-clock"></i>
        <span class="oc-tile-label">Time Slot</span>
        <span class="oc-tile-val"><?= htmlspecialchars($time, ENT_QUOTES, 'UTF-8') ?></span>
      </div>
      <div class="oc-tile">
        <i class="fab fa-paypal"></i>
        <span class="oc-tile-label">Payment</span>
        <span class="oc-tile-val">PayPal</span>
      </div>
      <div class="oc-tile oc-tile-green">
        <i class="fas fa-receipt"></i>
        <span class="oc-tile-label">Amount Paid</span>
        <span class="oc-tile-val">$<?= number_format($total) ?></span>
      </div>
    </div>

    <!-- Items list -->
    <?php if (!empty($items)): ?>
    <div class="oc-items">
      <p class="oc-items-title">Items in your order</p>
      <?php foreach ($items as $item): ?>
      <div class="oc-item-row">
        <img src="<?= htmlspecialchars($item['img'], ENT_QUOTES, 'UTF-8') ?>"
             alt="<?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>"
             onerror="this.src='assets/css/image/market-hero.png'">
        <span class="oc-item-name"><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?></span>
        <span class="oc-item-qty">×<?= $item['qty'] ?></span>
        <span class="oc-item-price">$<?= number_format($item['price'] * $item['qty']) ?></span>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- What's next -->
    <div class="oc-next">
      <p class="oc-next-title"><i class="fas fa-info-circle"></i> What happens next?</p>
      <div class="oc-next-steps">
        <div class="oc-ns"><div class="oc-ns-num">1</div><p>Your order is being prepared fresh by our local traders</p></div>
        <div class="oc-ns"><div class="oc-ns-num">2</div><p>Come collect on <strong><?= htmlspecialchars($day, ENT_QUOTES, 'UTF-8') ?></strong> between <strong><?= htmlspecialchars($time, ENT_QUOTES, 'UTF-8') ?></strong></p></div>
        <div class="oc-ns"><div class="oc-ns-num">3</div><p>Show your reference <strong>#<?= htmlspecialchars($ref, ENT_QUOTES, 'UTF-8') ?></strong> at collection</p></div>
      </div>
    </div>

    <!-- Actions -->
    <div class="oc-actions">
      <a href="shop.php" class="oc-btn-shop"><i class="fas fa-store"></i> Continue Shopping</a>
      <a href="invoice.php" class="oc-btn-home"><i class="fas fa-file-invoice"></i> View Invoice</a>
      <a href="index.php" class="oc-btn-home"><i class="fas fa-home"></i> Back to Home</a>
    </div>

  </div>
</main>

<?php include 'include/footer.php'; ?>