<?php

session_start();

// Redirect to cart if cart is empty
if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

$success = false;
$errors  = [];

// ── Totals ────────────────────────────────────────────────────
$subtotal     = 0;
foreach ($_SESSION['cart'] as $item) {
    $subtotal += $item['price'] * $item['qty'];
}
$discount_pct = (int)($_SESSION['promo_discount'] ?? 0);
$discount_amt = (int)round($subtotal * $discount_pct / 100);
$total        = $subtotal - $discount_amt;

// ── Handle order submission ───────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim(htmlspecialchars($_POST['full_name']   ?? '', ENT_QUOTES, 'UTF-8'));
    $email   = trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL));
    $phone   = trim(htmlspecialchars($_POST['phone']       ?? '', ENT_QUOTES, 'UTF-8'));
    $address = trim(htmlspecialchars($_POST['address']     ?? '', ENT_QUOTES, 'UTF-8'));
    $day     = trim(htmlspecialchars($_POST['slot_day']    ?? '', ENT_QUOTES, 'UTF-8'));
    $time    = trim(htmlspecialchars($_POST['slot_time']   ?? '', ENT_QUOTES, 'UTF-8'));

    if (empty($name))    $errors[] = 'Full name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if (empty($address)) $errors[] = 'Delivery address is required.';
    if (empty($day))     $errors[] = 'Please select a collection day.';
    if (empty($time))    $errors[] = 'Please select a collection time.';

    if (empty($errors)) {
        // Save order summary to log
        $log_dir  = __DIR__ . '/messages';
        if (!is_dir($log_dir)) mkdir($log_dir, 0755, true);

        $items_text = '';
        foreach ($_SESSION['cart'] as $item) {
            $items_text .= "  - {$item['name']} x{$item['qty']} = \${$item['price']}\n";
        }

        $entry = "========================================\n"
               . "ORDER DATE:  " . date('Y-m-d H:i:s') . "\n"
               . "Name:        $name\n"
               . "Email:       $email\n"
               . "Phone:       $phone\n"
               . "Address:     $address\n"
               . "Collection:  $day @ $time\n"
               . "Items:\n$items_text"
               . "Subtotal:    \$$subtotal\n"
               . "Discount:    -\$$discount_amt\n"
               . "Total:       \$$total\n\n";

        file_put_contents($log_dir . '/orders.log', $entry, FILE_APPEND | LOCK_EX);

        // Clear cart and promo
        $_SESSION['cart']           = [];
        $_SESSION['promo_code']     = null;
        $_SESSION['promo_discount'] = 0;
        $success = true;
    }
}

$pageTitle = 'Checkout – Hudders Hub';
include 'include/header.php';
?>

<link rel="stylesheet" href="assets/css/cart.css">
<link rel="stylesheet" href="assets/css/checkout.css">

<main class="checkout-page">

  <?php if ($success): ?>
  <!-- ── Order confirmed ─────────────────────── -->
  <div class="checkout-success">
    <i class="fas fa-check-circle"></i>
    <h2>Order Placed!</h2>
    <p>Thank you for your order. We'll have it ready for your chosen collection slot.</p>
    <a href="index.php">Back to Home</a>
  </div>

  <?php else: ?>
  <div class="checkout-inner">

    <!-- LEFT: Form -->
    <div class="checkout-form-box">
      <h2>Delivery Details</h2>

      <?php if (!empty($errors)): ?>
        <div class="co-errors">
          Please fix the following:
          <ul>
            <?php foreach ($errors as $e): ?>
              <li><?= htmlspecialchars($e, ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="POST" action="checkout.php" novalidate>

        <div class="co-form-row">
          <div class="co-form-group">
            <label for="full_name">Full Name *</label>
            <input type="text" id="full_name" name="full_name"
                   maxlength="80" required autocomplete="name"
                   value="<?= htmlspecialchars($_POST['full_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
          </div>
          <div class="co-form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email"
                   maxlength="150" required autocomplete="email"
                   value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
          </div>
        </div>

        <div class="co-form-row">
          <div class="co-form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone"
                   maxlength="20" autocomplete="tel"
                   value="<?= htmlspecialchars($_POST['phone'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
          </div>
          <div class="co-form-group">
            <label for="postcode">Postcode</label>
            <input type="text" id="postcode" name="postcode"
                   maxlength="10" autocomplete="postal-code"
                   value="<?= htmlspecialchars($_POST['postcode'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
          </div>
        </div>

        <div class="co-form-row">
          <div class="co-form-group full">
            <label for="address">Delivery Address *</label>
            <textarea id="address" name="address"
                      maxlength="300" required
                      placeholder="Street, City"><?= htmlspecialchars($_POST['address'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
          </div>
        </div>

        <div class="co-slot-row">
          <div class="co-form-group">
            <label for="slot_day">Collection Day *</label>
            <select id="slot_day" name="slot_day" required>
              <option value="">Select day</option>
              <?php foreach (['Wednesday','Thursday','Friday'] as $d): ?>
                <option value="<?= $d ?>"
                  <?= (($_POST['slot_day'] ?? '') === $d) ? 'selected' : '' ?>><?= $d ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="co-form-group">
            <label for="slot_time">Collection Time *</label>
            <select id="slot_time" name="slot_time" required>
              <option value="">Select time</option>
              <?php foreach (['10:00 – 13:00','13:00 – 16:00','16:00 – 19:00'] as $t): ?>
                <option value="<?= $t ?>"
                  <?= (($_POST['slot_time'] ?? '') === $t) ? 'selected' : '' ?>><?= $t ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <button type="submit" class="co-submit-btn">
          Confirm Order &nbsp;<i class="fas fa-check"></i>
        </button>

      </form>
    </div>

    <!-- RIGHT: Summary -->
    <aside class="co-summary">
      <h3>Order Summary</h3>
      <?php foreach ($_SESSION['cart'] as $item): ?>
        <div class="co-summary-item">
          <span class="name"><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?> ×<?= $item['qty'] ?></span>
          <span>$<?= number_format($item['price'] * $item['qty']) ?></span>
        </div>
      <?php endforeach; ?>
      <hr class="co-divider">
      <?php if ($discount_pct > 0): ?>
        <div class="co-summary-item">
          <span>Discount (-<?= $discount_pct ?>%)</span>
          <span style="color:#c0392b;">-$<?= number_format($discount_amt) ?></span>
        </div>
      <?php endif; ?>
      <div class="co-summary-total">
        <span>Total</span>
        <span>$<?= number_format($total) ?></span>
      </div>
    </aside>

  </div>
  <?php endif; ?>

</main>

<?php include 'include/footer.php'; ?>