<?php
session_start();
if (empty($_SESSION['cart']))          { header('Location: cart.php');     exit; }
if (empty($_SESSION['checkout_day']))  { header('Location: checkout.php'); exit; }

$subtotal     = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $_SESSION['cart']));
$discount_pct = (int)($_SESSION['promo_discount'] ?? 0);
$discount_amt = (int)round($subtotal * $discount_pct / 100);
$total        = $subtotal - $discount_amt;
$item_count   = array_sum(array_column($_SESSION['cart'], 'qty'));
$day          = $_SESSION['checkout_day'];
$time         = $_SESSION['checkout_time'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'pay') {
    $order_ref = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));

    // Save order to log
    $log_dir = __DIR__ . '/messages';
    if (!is_dir($log_dir)) mkdir($log_dir, 0755, true);
    $items_text = '';
    foreach ($_SESSION['cart'] as $item) {
        $items_text .= "  - {$item['name']} x{$item['qty']} = \${$item['price']}\n";
    }
    $entry = "========================================\n"
           . "ORDER REF:   $order_ref\n"
           . "DATE:        " . date('Y-m-d H:i:s') . "\n"
           . "Collection:  $day @ $time\n"
           . "Payment:     PayPal\n"
           . "Items:\n$items_text"
           . "Subtotal:    \$$subtotal\n"
           . "Discount:    -\$$discount_amt\n"
           . "Total Paid:  \$$total\n\n";
    file_put_contents($log_dir . '/orders.log', $entry, FILE_APPEND | LOCK_EX);

    // Store for confirmation page
    $_SESSION['order_ref']   = $order_ref;
    $_SESSION['order_total'] = $total;
    $_SESSION['order_day']   = $day;
    $_SESSION['order_time']  = $time;
    $_SESSION['order_items'] = $_SESSION['cart'];

    // Clear cart
    $_SESSION['cart'] = [];
    $_SESSION['promo_code'] = null;
    $_SESSION['promo_discount'] = 0;
    unset($_SESSION['checkout_day'], $_SESSION['checkout_time']);

    header('Location: order_confirmed.php');
    exit;
}

$pageTitle = 'Payment – Hudders Hub';
include 'include/header.php';
?>
<link rel="stylesheet" href="assets/css/payment.css">

<main class="pay-page">
  <div class="co-wrap">

    <!-- Steps -->
    <div class="co-steps">
      <div class="co-step done">
        <div class="step-bubble"><i class="fas fa-check"></i></div>
        <span>Collection Slot</span>
      </div>
      <div class="step-connector done"></div>
      <div class="co-step active">
        <div class="step-bubble">2</div>
        <span>Payment</span>
      </div>
      <div class="step-connector"></div>
      <div class="co-step">
        <div class="step-bubble">3</div>
        <span>Confirmed</span>
      </div>
    </div>

    <div class="co-grid">

      <!-- LEFT: Payment -->
      <div class="co-card">
        <div class="co-card-header">
          <div class="co-card-icon paypal-color"><i class="fab fa-paypal"></i></div>
          <div>
            <h2>Payment Method</h2>
            <p class="co-card-sub">Complete your order securely with PayPal</p>
          </div>
        </div>

        <!-- Collection slot reminder -->
        <div class="slot-reminder">
          <div class="sr-left">
            <i class="fas fa-calendar-check"></i>
            <div>
              <span class="sr-label">Your Collection Slot</span>
              <span class="sr-value"><?= htmlspecialchars($day, ENT_QUOTES, 'UTF-8') ?> &nbsp;·&nbsp; <?= htmlspecialchars($time, ENT_QUOTES, 'UTF-8') ?></span>
            </div>
          </div>
          <a href="checkout.php" class="sr-change">Change</a>
        </div>

        <!-- PayPal option card -->
        <div class="paypal-card">
          <div class="pp-card-top">
            <div class="pp-radio-dot"><i class="fas fa-check"></i></div>
            <div class="pp-brand">
              <i class="fab fa-paypal pp-icon"></i>
              <div>
                <span class="pp-name">PayPal</span>
                <span class="pp-tag">Recommended · Buyer Protected</span>
              </div>
            </div>
          </div>
          <div class="pp-features">
            <div class="pp-feature"><i class="fas fa-shield-alt"></i> 100% Buyer protection on every order</div>
            <div class="pp-feature"><i class="fas fa-bolt"></i> Instant payment — no card details needed</div>
            <div class="pp-feature"><i class="fas fa-undo-alt"></i> Easy refunds if something goes wrong</div>
          </div>
          <p class="pp-note">You'll complete payment on PayPal's secure page. We never see your financial details.</p>
        </div>

        <!-- Pay button -->
        <form method="POST" action="payment.php">
          <input type="hidden" name="action" value="pay">
          <button type="submit" class="pay-btn">
            <i class="fab fa-paypal"></i>
            Pay $<?= number_format($total) ?> with PayPal
          </button>
        </form>
        <p class="pay-secure-note"><i class="fas fa-lock"></i> 256-bit SSL encrypted · Your data is always safe</p>
      </div>

      <!-- RIGHT: Summary -->
      <aside class="co-summary-card">
        <h3 class="co-summary-title">Order Summary</h3>
        <span class="co-summary-count"><?= $item_count ?> item<?= $item_count !== 1 ? 's' : '' ?></span>
        <div class="co-summary-items">
          <?php foreach ($_SESSION['cart'] as $item): ?>
          <div class="co-si-row">
            <img src="<?= htmlspecialchars($item['img'], ENT_QUOTES, 'UTF-8') ?>"
                 alt="<?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>"
                 onerror="this.src='assets/css/image/market-hero.png'">
            <div class="co-si-info">
              <span class="co-si-name"><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?></span>
              <span class="co-si-qty">Qty: <?= $item['qty'] ?></span>
            </div>
            <span class="co-si-price">$<?= number_format($item['price'] * $item['qty']) ?></span>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="co-summary-foot">
          <?php if ($discount_pct > 0): ?>
          <div class="co-foot-row"><span>Subtotal</span><span>$<?= number_format($subtotal) ?></span></div>
          <div class="co-foot-row discount"><span>Discount (<?= $discount_pct ?>% off)</span><span>-$<?= number_format($discount_amt) ?></span></div>
          <?php endif; ?>
          <div class="co-foot-row total"><span>Total</span><span>$<?= number_format($total) ?></span></div>
        </div>
        <div class="co-secure"><i class="fas fa-lock"></i> Secure &amp; encrypted checkout</div>
      </aside>

    </div>
  </div>
</main>

<?php include 'include/footer.php'; ?>