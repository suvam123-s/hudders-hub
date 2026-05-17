<?php
session_start();
if (empty($_SESSION['cart'])) {
  header('Location: cart.php');
  exit;
}

$errors = [];
$subtotal = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $_SESSION['cart']));
$discount_pct = (int) ($_SESSION['promo_discount'] ?? 0);
$discount_amt = (int) round($subtotal * $discount_pct / 100);
$total = $subtotal - $discount_amt;
$item_count = array_sum(array_column($_SESSION['cart'], 'qty'));

$slots = [
  'Wednesday' => ['10:00 – 12:00', '12:00 – 14:00', '14:00 – 16:00', '16:00 – 18:00'],
  'Thursday' => ['10:00 – 12:00', '12:00 – 14:00', '14:00 – 16:00', '16:00 – 18:00'],
  'Friday' => ['10:00 – 12:00', '12:00 – 14:00', '14:00 – 16:00', '16:00 – 18:00'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $day = trim(htmlspecialchars($_POST['slot_day'] ?? '', ENT_QUOTES, 'UTF-8'));
  $time = trim(htmlspecialchars($_POST['slot_time'] ?? '', ENT_QUOTES, 'UTF-8'));
  if (!array_key_exists($day, $slots))
    $errors[] = 'Please select a collection day.';
  elseif (!in_array($time, $slots[$day] ?? [], true))
    $errors[] = 'Please select a valid time slot for that day.';
  if (empty($errors)) {
    $_SESSION['checkout_day'] = $day;
    $_SESSION['checkout_time'] = $time;
    header('Location: payment.php');
    exit;
  }
}

$sel_day = $_POST['slot_day'] ?? '';
$sel_time = $_POST['slot_time'] ?? '';

$pageTitle = 'Checkout – Hudders Hub';
include 'include/header.php';
?>
<link rel="stylesheet" href="assets/css/checkout.css">

<main class="co-page">

  <div class="co-wrap">

    <!-- ── Step indicator ─────────────────────── -->
    <div class="co-steps">
      <div class="co-step active">
        <div class="step-bubble">1</div>
        <span>Collection Slot</span>
      </div>
      <div class="step-connector"></div>
      <div class="co-step">
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

      <!-- LEFT: Slot selector -->
      <div class="co-card">
        <div class="co-card-header">
          <div class="co-card-icon"><i class="fas fa-calendar-alt"></i></div>
          <div>
            <h2>Choose Collection Slot</h2>
            <p class="co-card-sub">Pick a day and available time for pickup</p>
          </div>
        </div>

        <?php if (!empty($errors)): ?>
          <div class="co-error-box">
            <i class="fas fa-exclamation-circle"></i>
            <ul><?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e, ENT_QUOTES, 'UTF-8') ?></li><?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <form method="POST" action="checkout.php" id="slotForm">

          <!-- Day selector -->
          <p class="co-field-label">Select Day</p>
          <div class="day-cards">
            <?php
            $dayMeta = ['Wednesday' => ['WED', '🌿'], 'Thursday' => ['THU', '🌱'], 'Friday' => ['FRI', '🛒']];
            foreach ($dayMeta as $day => [$short, $emoji]): ?>
              <label class="day-card <?= $sel_day === $day ? 'selected' : '' ?>">
                <input type="radio" name="slot_day" value="<?= $day ?>" <?= $sel_day === $day ? 'checked' : '' ?>>
                <span class="dc-emoji"><?= $emoji ?></span>
                <span class="dc-short"><?= $short ?></span>
                <span class="dc-full"><?= $day ?></span>
              </label>
            <?php endforeach; ?>
          </div>

          <!-- Time selector — dropdown -->
          <p class="co-field-label" style="margin-top:28px;">Select Time Slot</p>
          <div class="co-select-wrap">
            <i class="fas fa-clock co-select-icon"></i>
            <select name="slot_time" id="timeSelect" class="co-select" required>
              <option value="">— Choose a time —</option>
              <?php
              $show_slots = !empty($sel_day) ? $slots[$sel_day] : $slots['Wednesday'];
              foreach ($show_slots as $t): ?>
                <option value="<?= $t ?>" <?= $sel_time === $t ? 'selected' : '' ?>><?= $t ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Live summary bar -->
          <div class="slot-bar" id="slotBar" style="display:none">
            <i class="fas fa-calendar-check"></i>
            <span id="slotBarText"></span>
          </div>

          <button type="submit" class="co-btn">
            Continue to Payment <i class="fas fa-arrow-right"></i>
          </button>

        </form>
      </div>

      <!-- RIGHT: Order summary -->
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
            <div class="co-foot-row">
              <span>Subtotal</span><span>$<?= number_format($subtotal) ?></span>
            </div>
            <div class="co-foot-row discount">
              <span>Discount (<?= $discount_pct ?>% off)</span>
              <span>-$<?= number_format($discount_amt) ?></span>
            </div>
          <?php endif; ?>
          <div class="co-foot-row total">
            <span>Total</span>
            <span>$<?= number_format($total) ?></span>
          </div>
        </div>

        <div class="co-secure">
          <i class="fas fa-lock"></i> Secure &amp; encrypted checkout
        </div>
      </aside>

    </div><!-- /.co-grid -->
  </div><!-- /.co-wrap -->

</main>

<?php include 'include/footer.php'; ?>

<script>
  const slots = <?= json_encode($slots) ?>;

  // Day card selection + repopulate time dropdown
  document.querySelectorAll('.day-card').forEach(card => {
    card.addEventListener('click', function () {
      document.querySelectorAll('.day-card').forEach(c => c.classList.remove('selected'));
      this.classList.add('selected');
      const day = this.querySelector('input').value;
      const sel = document.getElementById('timeSelect');
      sel.innerHTML = '<option value="">— Choose a time —</option>';
      slots[day].forEach(t => {
        const o = document.createElement('option');
        o.value = t; o.textContent = t;
        sel.appendChild(o);
      });
      updateBar();
    });
  });

  document.getElementById('timeSelect').addEventListener('change', updateBar);

  function updateBar() {
    const day = document.querySelector('.day-card.selected input')?.value;
    const time = document.getElementById('timeSelect').value;
    const bar = document.getElementById('slotBar');
    if (day && time) {
      document.getElementById('slotBarText').textContent = day + '  ·  ' + time;
      bar.style.display = 'flex';
    } else {
      bar.style.display = 'none';
    }
  }

  // Init bar if values already set (e.g. after validation error)
  updateBar();
</script>