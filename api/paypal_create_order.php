<?php
/**
 * PayPal Create Order API
 * 
 * Called by the PayPal JavaScript SDK when the buyer clicks
 * the PayPal button. Creates an order on PayPal's side and
 * returns the order ID so the JS SDK can redirect to PayPal
 * for approval.
 */
session_start();
header('Content-Type: application/json');

// ── Guard: cart must exist ──
if (empty($_SESSION['cart'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Cart is empty.']);
    exit;
}

require_once __DIR__ . '/../include/paypal_config.php';

// ── Calculate totals from session cart ──
$subtotal     = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $_SESSION['cart']));
$discount_pct = (int)($_SESSION['promo_discount'] ?? 0);
$discount_amt = round($subtotal * $discount_pct / 100, 2);
$total        = round($subtotal - $discount_amt, 2);

// ── Build line items for PayPal ──
$items = [];
foreach ($_SESSION['cart'] as $item) {
    $items[] = [
        'name'        => $item['name'],
        'quantity'    => (string)$item['qty'],
        'unit_amount' => [
            'currency_code' => PAYPAL_CURRENCY,
            'value'         => number_format((float)$item['price'], 2, '.', ''),
        ],
    ];
}

// ── Build the PayPal order payload ──
$orderPayload = [
    'intent' => 'CAPTURE',
    'purchase_units' => [[
        'description' => 'Hudders Hub Market Order',
        'amount' => [
            'currency_code' => PAYPAL_CURRENCY,
            'value'         => number_format($total, 2, '.', ''),
            'breakdown'     => [
                'item_total' => [
                    'currency_code' => PAYPAL_CURRENCY,
                    'value'         => number_format($subtotal, 2, '.', ''),
                ],
                'discount' => [
                    'currency_code' => PAYPAL_CURRENCY,
                    'value'         => number_format($discount_amt, 2, '.', ''),
                ],
            ],
        ],
        'items' => $items,
    ]],
    'application_context' => [
        'brand_name'          => 'Hudders Hub Market',
        'shipping_preference' => 'NO_SHIPPING',
        'user_action'         => 'PAY_NOW',
    ],
];

// ── Create order on PayPal ──
try {
    $result = paypal_request('POST', '/v2/checkout/orders', $orderPayload);

    if (($result['_http_code'] ?? 0) === 201 && !empty($result['id'])) {
        // Store PayPal order ID in session for later verification
        $_SESSION['paypal_order_id'] = $result['id'];

        echo json_encode(['id' => $result['id']]);
    } else {
        error_log('PayPal Create Order failed: ' . json_encode($result));
        http_response_code(500);
        echo json_encode(['error' => 'Failed to create PayPal order.', 'details' => $result]);
    }
} catch (\Exception $e) {
    error_log('PayPal Create Order exception: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
