<?php
session_start();
if (empty($_SESSION['cart']))          { header('Location: cart.php');     exit; }
if (empty($_SESSION['checkout_day']))  { header('Location: checkout.php'); exit; }

require_once 'include/paypal_config.php';

$subtotal     = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $_SESSION['cart']));
$discount_pct = (int)($_SESSION['promo_discount'] ?? 0);
$discount_amt = (int)round($subtotal * $discount_pct / 100);
$total        = $subtotal - $discount_amt;
$item_count   = array_sum(array_column($_SESSION['cart'], 'qty'));
$day          = $_SESSION['checkout_day'];
$time         = $_SESSION['checkout_time'];

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

        <!-- PayPal Smart Payment Buttons Container -->
        <div id="paypal-button-container"></div>

        <!-- Error message area -->
        <div id="paypal-error" class="pp-error-msg" style="display:none;">
          <i class="fas fa-exclamation-triangle"></i>
          <span id="paypal-error-text"></span>
        </div>

        <!-- Processing overlay -->
        <div id="paypal-processing" class="pp-processing" style="display:none;">
          <div class="pp-spinner"></div>
          <p>Processing your payment securely…</p>
        </div>

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

<!-- ══════════════════════════════════════════════════════════════
     PayPal JavaScript SDK — Smart Payment Buttons
     ══════════════════════════════════════════════════════════════ -->
<script src="https://www.paypal.com/sdk/js?client-id=<?= htmlspecialchars(paypal_client_id(), ENT_QUOTES, 'UTF-8') ?>&currency=<?= PAYPAL_CURRENCY ?>&intent=capture&disable-funding=credit,card"></script>

<script>
// ── PayPal Smart Buttons ──
paypal.Buttons({

  // Style the buttons to match the site design
  style: {
    layout:  'vertical',
    color:   'blue',
    shape:   'rect',
    label:   'paypal',
    height:  50,
    tagline: false,
  },

  // ── Step 1: Create the order on our server ──
  createOrder: function(data, actions) {
    showProcessing(false);
    hideError();

    return fetch('api/paypal_create_order.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
    })
    .then(function(res) { return res.json(); })
    .then(function(orderData) {
      if (orderData.error) {
        throw new Error(orderData.error);
      }
      return orderData.id; // Return the PayPal order ID
    });
  },

  // ── Step 2: Buyer approved → capture the payment ──
  onApprove: function(data, actions) {
    showProcessing(true);

    return fetch('api/paypal_capture_order.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ orderID: data.orderID }),
    })
    .then(function(res) { return res.json(); })
    .then(function(captureData) {
      if (captureData.status === 'COMPLETED') {
        // ✅ Payment successful — redirect to confirmation
        window.location.href = 'order_confirmed.php';
      } else {
        showProcessing(false);
        showError(captureData.error || 'Payment could not be completed. Please try again.');
      }
    })
    .catch(function(err) {
      showProcessing(false);
      showError('An error occurred while processing your payment. Please try again.');
      console.error('PayPal Capture Error:', err);
    });
  },

  // ── Buyer cancelled ──
  onCancel: function(data) {
    showProcessing(false);
    showError('Payment was cancelled. You can try again whenever you\'re ready.');
  },

  // ── SDK / network error ──
  onError: function(err) {
    showProcessing(false);
    showError('Something went wrong with PayPal. Please try again or contact support.');
    console.error('PayPal SDK Error:', err);
  },

}).render('#paypal-button-container');

// ── UI Helpers ──
function showError(msg) {
  var el = document.getElementById('paypal-error');
  document.getElementById('paypal-error-text').textContent = msg;
  el.style.display = 'flex';
}

function hideError() {
  document.getElementById('paypal-error').style.display = 'none';
}

function showProcessing(show) {
  document.getElementById('paypal-processing').style.display = show ? 'flex' : 'none';
}
</script>

<?php include 'include/footer.php'; ?>