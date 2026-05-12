<?php
session_start();

// ── Guard: must arrive from order_confirmed (session data present) ────────────
if (empty($_SESSION['invoice_ref'])) {
    header('Location: index.php');
    exit();
}

$ref          = $_SESSION['invoice_ref'];
$items        = $_SESSION['invoice_items']      ?? [];
$subtotal     = (float)($_SESSION['invoice_subtotal']  ?? 0);
$discount_pct = (int)($_SESSION['invoice_discount_pct'] ?? 0);
$discount_amt = (float)($_SESSION['invoice_discount_amt'] ?? 0);
$tax_pct      = (float)($_SESSION['invoice_tax_pct']   ?? 8.5);
$tax_amt      = (float)($_SESSION['invoice_tax_amt']   ?? 0);
$total        = (float)($_SESSION['invoice_total']     ?? 0);
$bill_name    = $_SESSION['invoice_bill_name']  ?? '';
$bill_address = $_SESSION['invoice_bill_address'] ?? '';
$bill_email   = $_SESSION['invoice_bill_email'] ?? '';
$ship_name    = $_SESSION['invoice_ship_name']  ?? $bill_name;
$ship_address = $_SESSION['invoice_ship_address'] ?? $bill_address;
$invoice_date = $_SESSION['invoice_date']       ?? date('F j, Y');

$pageTitle = 'Invoice #' . htmlspecialchars($ref) . ' – Hudders Hub';
include 'include/header.php';
?>
<link rel="stylesheet" href="assets/css/invoice.css">

<main class="inv-page">

  <h1 class="inv-title">INVOICE</h1>

  <div class="inv-card">

    <!-- ── Bill To / Ship To ──────────────────────────────── -->
    <div class="inv-addresses">

      <div class="inv-address-block">
        <p class="inv-address-label">BILL TO</p>
        <p class="inv-address-name"><?= htmlspecialchars($bill_name) ?></p>
        <?php foreach (explode("\n", $bill_address) as $line): ?>
          <p class="inv-address-line"><?= htmlspecialchars(trim($line)) ?></p>
        <?php endforeach; ?>
        <?php if ($bill_email): ?>
          <p class="inv-address-email"><?= htmlspecialchars($bill_email) ?></p>
        <?php endif; ?>
      </div>

      <div class="inv-address-block">
        <p class="inv-address-label">SHIP TO</p>
        <p class="inv-address-name"><?= htmlspecialchars($ship_name) ?></p>
        <?php foreach (explode("\n", $ship_address) as $line): ?>
          <p class="inv-address-line"><?= htmlspecialchars(trim($line)) ?></p>
        <?php endforeach; ?>
      </div>

    </div>

    <!-- ── Items table ────────────────────────────────────── -->
    <table class="inv-table">
      <thead>
        <tr>
          <th class="inv-th inv-th-desc">Description</th>
          <th class="inv-th inv-th-qty">Qty</th>
          <th class="inv-th inv-th-price">Unit Price</th>
          <th class="inv-th inv-th-total">Total</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $item):
          $line_total = (float)$item['price'] * (int)$item['qty'];
        ?>
        <tr class="inv-row">
          <td class="inv-td inv-td-desc">
            <span class="inv-item-name"><?= htmlspecialchars($item['name']) ?></span>
            <?php if (!empty($item['description'])): ?>
              <span class="inv-item-sub"><?= htmlspecialchars($item['description']) ?></span>
            <?php endif; ?>
          </td>
          <td class="inv-td inv-td-qty"><?= (int)$item['qty'] ?></td>
          <td class="inv-td inv-td-price">$<?= number_format((float)$item['price'], 2) ?></td>
          <td class="inv-td inv-td-total"><strong>$<?= number_format($line_total, 2) ?></strong></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <!-- ── Notes + Totals ─────────────────────────────────── -->
    <div class="inv-footer">

      <div class="inv-notes">
        <p class="inv-notes-label">NOTES</p>
        <p class="inv-notes-text">
          Thank you for your shopping at Hudders Hub.<br>
          Your artisan goods have been carefully packed<br>
          in compostable materials. We hope they bring<br>
          nature's serenity into your home.
        </p>
      </div>

      <div class="inv-totals">
        <div class="inv-total-row">
          <span>Subtotal</span>
          <span>$<?= number_format($subtotal, 2) ?></span>
        </div>

        <?php if ($discount_amt > 0): ?>
        <div class="inv-total-row inv-discount">
          <span>Eco-Discount (<?= $discount_pct ?>%)</span>
          <span>-$<?= number_format($discount_amt, 2) ?></span>
        </div>
        <?php endif; ?>

        <div class="inv-total-row">
          <span>Tax (<?= $tax_pct ?>%)</span>
          <span>$<?= number_format($tax_amt, 2) ?></span>
        </div>

        <div class="inv-total-row inv-amount-due">
          <span>Amount Due</span>
          <span class="inv-due-amount">$<?= number_format($total, 2) ?></span>
        </div>
      </div>

    </div><!-- /.inv-footer -->

  </div><!-- /.inv-card -->

  <!-- ── Actions ────────────────────────────────────────────── -->
  <div class="inv-actions">
    <a href="order_confirmed.php" class="inv-btn-back">
      <i class="fas fa-arrow-left"></i> Back to Order
    </a>
    <button class="inv-btn-print" onclick="window.print()">
      <i class="fas fa-print"></i> Print Invoice
    </button>
  </div>

</main>

<?php include 'include/footer.php'; ?>