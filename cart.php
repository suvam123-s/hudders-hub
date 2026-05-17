<?php
session_start();

// ── Product catalogue ─────────────────────────────────────────
$catalogue = [
  1 => ['name' => 'Orange', 'price' => 1.49, 'image' => 'assets/css/image/orange.jpg'],
  2 => ['name' => 'Banana', 'price' => 1.29, 'image' => 'assets/css/image/bannan.png'],
  3 => ['name' => 'Pineapple', 'price' => 2.50, 'image' => 'assets/css/image/pineapple.jpg'],
  4 => ['name' => 'Pomegranate', 'price' => 2.99, 'image' => 'assets/css/image/fomegranate.jpg'],
  5 => ['name' => 'Broccoli', 'price' => 1.20, 'image' => 'assets/css/image/broccoli.png'],
  6 => ['name' => 'Cauliflower', 'price' => 1.50, 'image' => 'assets/css/image/cauliflower.png'],
  7 => ['name' => 'Salmon', 'price' => 6.90, 'image' => 'assets/css/image/salmon.png'],
  8 => ['name' => 'Steak', 'price' => 8.50, 'image' => 'assets/css/image/steak.png'],
  9 => ['name' => 'Sourdough', 'price' => 3.50, 'image' => 'assets/css/image/sourdough.png'],
  10 => ['name' => 'Bagels', 'price' => 2.50, 'image' => 'assets/css/image/bagels.jpg'],
  11 => ['name' => 'Croissant', 'price' => 1.80, 'image' => 'assets/css/image/croissant.jpg'],
  12 => ['name' => 'Cake', 'price' => 4.50, 'image' => 'assets/css/image/cake.jpg'],
  13 => ['name' => 'Donuts', 'price' => 3.00, 'image' => 'assets/css/image/donuts.jpg'],
  14 => ['name' => 'Muffins', 'price' => 2.20, 'image' => 'assets/css/image/muffins.jpg'],
  15 => ['name' => 'Cheese', 'price' => 5.50, 'image' => 'assets/css/image/cheese.jpg'],
  16 => ['name' => 'Ham', 'price' => 4.20, 'image' => 'assets/css/image/ham.jpg'],
  17 => ['name' => 'Prawns', 'price' => 8.90, 'image' => 'assets/css/image/prawns.jpg'],
  18 => ['name' => 'Coffee', 'price' => 6.50, 'image' => 'assets/css/image/coffee.jpg'],
  19 => ['name' => 'Cooking Oil', 'price' => 3.20, 'image' => 'assets/css/image/cooking oil.jpg'],
  20 => ['name' => 'Sugar', 'price' => 1.50, 'image' => 'assets/css/image/sugar.jpg'],
  21 => ['name' => 'Lemon Zest', 'price' => 1.10, 'image' => 'assets/css/image/Lemon zest.png'],
  22 => ['name' => 'Fish Fillet', 'price' => 7.50, 'image' => 'assets/css/image/Fish fillet.jpg'],
  23 => ['name' => 'Frozen Chicken', 'price' => 5.50, 'image' => 'assets/css/image/Frozen chicken.jpg'],
  24 => ['name' => 'Lobster', 'price' => 25.00, 'image' => 'assets/css/image/Lobster.jpg'],
  25 => ['name' => 'Tuna', 'price' => 12.00, 'image' => 'assets/css/image/Tuna.jpg'],
  26 => ['name' => 'Bacon', 'price' => 4.80, 'image' => 'assets/css/image/bacon.jpg'],
  27 => ['name' => 'Beef Steak', 'price' => 10.50, 'image' => 'assets/css/image/beef steak.jpg'],
  28 => ['name' => 'Pickle', 'price' => 2.50, 'image' => 'assets/css/image/pickle.jpg'],
  29 => ['name' => 'Salad', 'price' => 3.50, 'image' => 'assets/css/image/salad.jpg'],
  30 => ['name' => 'Sandwich', 'price' => 4.50, 'image' => 'assets/css/image/sandwich.jpg'],
  31 => ['name' => 'Cookies', 'price' => 2.80, 'image' => 'assets/css/image/Cookies.jpg'],
  32 => ['name' => 'Frozen Mutton', 'price' => 14.50, 'image' => 'assets/css/image/Frozen mutton.jpg'],
  33 => ['name' => 'Olives', 'price' => 3.20, 'image' => 'assets/css/image/Olives.jpg'],
  34 => ['name' => 'Sausage', 'price' => 5.00, 'image' => 'assets/css/image/Sausage.jpg'],
  35 => ['name' => 'Bread', 'price' => 2.00, 'image' => 'assets/css/image/bread.jpg'],
  37 => ['name' => 'Pastries', 'price' => 3.50, 'image' => 'assets/css/image/pastries.jpg'],
  38 => ['name' => 'Salami', 'price' => 4.80, 'image' => 'assets/css/image/salami.jpg'],
  39 => ['name' => 'Smoked Meat', 'price' => 6.00, 'image' => 'assets/css/image/smoked meat.jpg'],
];

// ── Handle POST actions ───────────────────────────────────────
$action = $_POST['action'] ?? '';
$item_id = (int) ($_POST['item_id'] ?? -1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if ($action === 'update_qty' && isset($_SESSION['cart'][$item_id])) {
    $qty = max(1, min(99, (int) $_POST['qty']));
    $_SESSION['cart'][$item_id]['qty'] = $qty;

  } elseif ($action === 'remove' && isset($_SESSION['cart'][$item_id])) {
    array_splice($_SESSION['cart'], $item_id, 1);

  } elseif ($action === 'apply_promo') {
    $code = strtoupper(trim(htmlspecialchars($_POST['promo'] ?? '', ENT_QUOTES, 'UTF-8')));
    $valid = ['SAVE20' => 20, 'HUB10' => 10];
    if (array_key_exists($code, $valid)) {
      $_SESSION['promo_code'] = $code;
      $_SESSION['promo_discount'] = $valid[$code];
      unset($_SESSION['promo_error']);
    } else {
      $_SESSION['promo_code'] = null;
      $_SESSION['promo_discount'] = 0;
      $_SESSION['promo_error'] = 'Invalid promo code.';
    }
  }

  header('Location: cart.php');
  exit;
}

// ── Handle POST actions ───────────────────────────────────────
$action = $_POST['action'] ?? '';
$item_id = (int) ($_POST['item_id'] ?? -1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if ($action === 'add') {
    $pid = (int) ($_POST['product_id'] ?? 0);
    if (isset($catalogue[$pid])) {
      $p = $catalogue[$pid];
      $found = false;
      foreach ($_SESSION['cart'] as &$item) {
        if ($item['name'] === $p['name']) {
          $item['qty']++;
          $found = true;
          break;
        }
      }
      unset($item);
      if (!$found) {
        $_SESSION['cart'][] = [
          'name' => $p['name'],
          'meta' => [],
          'price' => $p['price'],
          'qty' => 1,
          'img' => $p['image'],
        ];
      }
    }

  } elseif ($action === 'update_qty' && isset($_SESSION['cart'][$item_id])) {
    $qty = max(1, min(99, (int) $_POST['qty']));
    $_SESSION['cart'][$item_id]['qty'] = $qty;

  } elseif ($action === 'remove' && isset($_SESSION['cart'][$item_id])) {
    array_splice($_SESSION['cart'], $item_id, 1);

  } elseif ($action === 'apply_promo') {
    $code = strtoupper(trim(htmlspecialchars($_POST['promo'] ?? '', ENT_QUOTES, 'UTF-8')));
    $valid = ['SAVE20' => 20, 'HUB10' => 10];
    if (array_key_exists($code, $valid)) {
      $_SESSION['promo_code'] = $code;
      $_SESSION['promo_discount'] = $valid[$code];
      unset($_SESSION['promo_error']);
    } else {
      $_SESSION['promo_code'] = null;
      $_SESSION['promo_discount'] = 0;
      $_SESSION['promo_error'] = 'Invalid promo code.';
    }
  }

  header('Location: cart.php');
  exit;
}

// ── Totals ────────────────────────────────────────────────────
$subtotal = 0;
foreach ($_SESSION['cart'] as $item) {
  $subtotal += $item['price'] * $item['qty'];
}
$discount_pct = (int) ($_SESSION['promo_discount'] ?? 0);
$discount_amt = (int) round($subtotal * $discount_pct / 100);
$total = $subtotal - $discount_amt;

$pageTitle = 'Your Cart – Hudders Hub';
include 'include/header.php';
?>

<link rel="stylesheet" href="assets/css/cart.css">

<main class="cart-page">
  <div class="cart-inner">

    <!-- ══ LEFT: Items + Collection Slot ══════════════════ -->
    <div>

      <div class="cart-items-box">
        <?php if (empty($_SESSION['cart'])): ?>
          <div class="cart-empty">
            <i class="fas fa-shopping-cart"></i>
            <p>Your cart is empty.</p>
            <a href="shop.php">Continue Shopping</a>
          </div>

        <?php else: ?>
          <?php foreach ($_SESSION['cart'] as $i => $item): ?>
            <div class="cart-item">

              <!-- Delete -->
              <form method="POST" action="cart.php" style="position:absolute;top:14px;right:14px;">
                <input type="hidden" name="action" value="remove">
                <input type="hidden" name="item_id" value="<?= $i ?>">
                <button type="submit" class="cart-item-delete" title="Remove">
                  <i class="fas fa-trash"></i>
                </button>
              </form>

              <!-- Image -->
              <img class="cart-item-img" src="<?= htmlspecialchars($item['img'], ENT_QUOTES, 'UTF-8') ?>"
                alt="<?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>"
                onerror="this.src='assets/css/image/market-hero.png'">

              <!-- Info -->
              <div class="cart-item-info">
                <div class="cart-item-name">
                  <?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>
                </div>
                <div class="cart-item-meta">
                  <?php if (!empty($item['meta'])): ?>
                    <?php foreach ($item['meta'] as $k => $v): ?>
                      <?= htmlspecialchars($k, ENT_QUOTES, 'UTF-8') ?>:
                      <span><?= htmlspecialchars($v, ENT_QUOTES, 'UTF-8') ?></span>&nbsp;
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
                <div class="cart-item-price">
                  $<?= number_format($item['price'] * $item['qty'], 2) ?>
                </div>
              </div>

              <!-- Qty -->
              <form method="POST" action="cart.php" class="qty-control">
                <input type="hidden" name="action" value="update_qty">
                <input type="hidden" name="item_id" value="<?= $i ?>">
                <button type="submit" name="qty" value="<?= max(1, $item['qty'] - 1) ?>" class="qty-btn">&#8722;</button>
                <span class="qty-value"><?= (int) $item['qty'] ?></span>
                <button type="submit" name="qty" value="<?= min(99, $item['qty'] + 1) ?>" class="qty-btn">&#43;</button>
              </form>

            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div><!-- /.cart-items-box -->

      <!-- Collection Slot -->
      <div class="collection-slot">
        <span class="collection-slot-label">Collection Slot</span>
        <select class="slot-select" name="slot_day">
          <option>Day</option>
          <option>Wednesday</option>
          <option>Thursday</option>
          <option>Friday</option>
        </select>
        <select class="slot-select" name="slot_time">
          <option>Time</option>
          <option>10:00 – 13:00</option>
          <option>13:00 – 16:00</option>
          <option>16:00 – 19:00</option>
        </select>
      </div>

    </div><!-- /left col -->

    <!-- ══ RIGHT: Order Summary ═══════════════════════════ -->
    <aside class="order-summary">
      <h2>Order Summary</h2>

      <div class="summary-row">
        <span>Subtotal</span>
        <span>$<?= number_format($subtotal, 2) ?></span>
      </div>

      <?php if ($discount_pct > 0): ?>
        <div class="summary-row discount">
          <span>Discount (-<?= $discount_pct ?>%)</span>
          <span class="amount">-$<?= number_format($discount_amt, 2) ?></span>
        </div>
      <?php endif; ?>

      <hr class="summary-divider">

      <div class="summary-row total">
        <span>Total</span>
        <span>$<?= number_format($total, 2) ?></span>
      </div>

      <!-- Promo code -->
      <form method="POST" action="cart.php" class="promo-row">
        <input type="hidden" name="action" value="apply_promo">
        <input type="text" name="promo" class="promo-input" placeholder="Add promo code"
          value="<?= htmlspecialchars($_SESSION['promo_code'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <button type="submit" class="promo-btn">Apply</button>
      </form>

      <?php if (!empty($_SESSION['promo_error'])): ?>
        <p class="promo-msg error">
          <?= htmlspecialchars($_SESSION['promo_error'], ENT_QUOTES, 'UTF-8') ?>
        </p>
        <?php unset($_SESSION['promo_error']); ?>
      <?php elseif (!empty($_SESSION['promo_code'])): ?>
        <p class="promo-msg success">
          ✓ "<?= htmlspecialchars($_SESSION['promo_code'], ENT_QUOTES, 'UTF-8') ?>" applied!
        </p>
      <?php endif; ?>

      <!-- Checkout -->
      <a href="checkout.php" class="checkout-btn">
        Proceed&nbsp;to&nbsp;Checkout &nbsp;<i class="fas fa-arrow-right"></i>
      </a>
    </aside>

  </div>
</main>

<?php include 'include/footer.php'; ?>
