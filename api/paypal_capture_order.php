<?php

 */
session_start();
header('Content-Type: application/json');

// ── Guard ──
if (empty($_SESSION['cart'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Cart is empty.']);
    exit;
}
if (empty($_SESSION['checkout_day'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No collection slot selected.']);
    exit;
}

require_once __DIR__ . '/../include/paypal_config.php';

// ── Read the order ID from the request body ──
$input   = json_decode(file_get_contents('php://input'), true);
$orderId = $input['orderID'] ?? '';

if (empty($orderId)) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing PayPal order ID.']);
    exit;
}

// ── Verify the order ID matches what we created ──
if (($orderId !== ($_SESSION['paypal_order_id'] ?? ''))) {
    http_response_code(400);
    echo json_encode(['error' => 'Order ID mismatch.']);
    exit;
}

// ── Capture the payment on PayPal ──
try {
    $result = paypal_request('POST', '/v2/checkout/orders/' . $orderId . '/capture');

    $httpCode = $result['_http_code'] ?? 0;
    $status   = $result['status'] ?? '';

    if ($httpCode === 201 && $status === 'COMPLETED') {

        // Extract transaction details
        $capture     = $result['purchase_units'][0]['payments']['captures'][0] ?? [];
        $txn_id      = $capture['id'] ?? $orderId;
        $amount_paid = $capture['amount']['value'] ?? 0;
        $payer_email = $result['payer']['email_address'] ?? '';
        $payer_name  = trim(
            ($result['payer']['name']['given_name'] ?? '') . ' ' .
            ($result['payer']['name']['surname'] ?? '')
        );

        // ── Calculate totals ──
        $subtotal     = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $_SESSION['cart']));
        $discount_pct = (int)($_SESSION['promo_discount'] ?? 0);
        $discount_amt = round($subtotal * $discount_pct / 100, 2);
        $total        = round($subtotal - $discount_amt, 2);
        $item_count   = array_sum(array_column($_SESSION['cart'], 'qty'));
        $day          = $_SESSION['checkout_day'];
        $time         = $_SESSION['checkout_time'];

        // ── Generate order reference ──
        $order_ref = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));

        // ── Save order to log ──
        $log_dir = dirname(__DIR__) . '/messages';
        if (!is_dir($log_dir)) mkdir($log_dir, 0755, true);

        $items_text = '';
        foreach ($_SESSION['cart'] as $item) {
            $items_text .= "  - {$item['name']} x{$item['qty']} = \${$item['price']}\n";
        }
        $entry = "========================================\n"
               . "ORDER REF:   $order_ref\n"
               . "DATE:        " . date('Y-m-d H:i:s') . "\n"
               . "Collection:  $day @ $time\n"
               . "Payment:     PayPal (LIVE)\n"
               . "PayPal TXN:  $txn_id\n"
               . "Payer:       $payer_name <$payer_email>\n"
               . "Items:\n$items_text"
               . "Subtotal:    \$$subtotal\n"
               . "Discount:    -\$$discount_amt\n"
               . "Total Paid:  \$$total\n\n";
        file_put_contents($log_dir . '/orders.log', $entry, FILE_APPEND | LOCK_EX);

        // ── Store for confirmation page ──
        $_SESSION['order_ref']       = $order_ref;
        $_SESSION['order_total']     = $total;
        $_SESSION['order_day']       = $day;
        $_SESSION['order_time']      = $time;
        $_SESSION['order_items']     = $_SESSION['cart'];
        $_SESSION['order_txn_id']    = $txn_id;
        $_SESSION['order_payer']     = $payer_email;

        // ── Store for invoice page ──
        $_SESSION['invoice_ref']          = $order_ref;
        $_SESSION['invoice_items']        = $_SESSION['cart'];
        $_SESSION['invoice_subtotal']     = $subtotal;
        $_SESSION['invoice_discount_pct'] = $discount_pct;
        $_SESSION['invoice_discount_amt'] = $discount_amt;
        $_SESSION['invoice_tax_pct']      = 0;
        $_SESSION['invoice_tax_amt']      = 0;
        $_SESSION['invoice_total']        = $total;
        $_SESSION['invoice_bill_name']    = $payer_name ?: ($_SESSION['user_name'] ?? '');
        $_SESSION['invoice_bill_address'] = '';
        $_SESSION['invoice_bill_email']   = $payer_email ?: ($_SESSION['user_email'] ?? '');
        $_SESSION['invoice_ship_name']    = $payer_name ?: ($_SESSION['user_name'] ?? '');
        $_SESSION['invoice_ship_address'] = '';
        $_SESSION['invoice_date']         = date('F j, Y');

        // ── Clear cart ──
        $_SESSION['cart']           = [];
        $_SESSION['promo_code']     = null;
        $_SESSION['promo_discount'] = 0;
        unset(
            $_SESSION['checkout_day'],
            $_SESSION['checkout_time'],
            $_SESSION['paypal_order_id']
        );

        echo json_encode([
            'status'    => 'COMPLETED',
            'order_ref' => $order_ref,
            'txn_id'    => $txn_id,
        ]);

    } else {
        error_log('PayPal Capture failed: ' . json_encode($result));
        http_response_code(500);
        echo json_encode([
            'error'   => 'Payment capture failed.',
            'status'  => $status,
            'details' => $result['details'] ?? null,
        ]);
    }

} catch (\Exception $e) {
    error_log('PayPal Capture exception: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
