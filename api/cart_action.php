<?php
/**
 * AJAX Cart & Wishlist API
 * Handles: add_to_cart, remove_from_cart, toggle_wishlist
 * Returns JSON responses for frontend JavaScript
 */
session_start();
header('Content-Type: application/json');

// Initialize session arrays
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
if (!isset($_SESSION['wishlist'])) $_SESSION['wishlist'] = [];

$action     = $_POST['action']     ?? $_GET['action'] ?? '';
$product_id = $_POST['product_id'] ?? $_GET['product_id'] ?? '';
$qty        = max(1, (int)($_POST['qty'] ?? 1));

// ── Master product catalog (same source for whole site) ──
function get_all_products() {
    require_once __DIR__ . '/../include/products_data.php';
    return $products;
}

switch ($action) {

    // ── ADD TO CART ──
    case 'add_to_cart':
        $products = get_all_products();
        $pid = (int)$product_id;
        if (!isset($products[$pid])) {
            echo json_encode(['success' => false, 'message' => 'Product not found.']);
            exit;
        }
        $p = $products[$pid];

        // Check if already in cart — update qty
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if (isset($item['product_id']) && $item['product_id'] === $pid) {
                $item['qty'] += $qty;
                $found = true;
                break;
            }
        }
        unset($item);

        if (!$found) {
            $_SESSION['cart'][] = [
                'product_id' => $pid,
                'name'       => $p['name'],
                'price'      => $p['price'],
                'qty'        => $qty,
                'img'        => $p['image'],
                'meta'       => ['Type' => ucfirst($p['category'])],
            ];
        }

        $cart_count = array_sum(array_column($_SESSION['cart'], 'qty'));
        echo json_encode([
            'success'    => true,
            'message'    => $p['name'] . ' added to cart!',
            'cart_count' => $cart_count,
        ]);
        break;

    // ── TOGGLE WISHLIST ──
    case 'toggle_wishlist':
        $pid = (int)$product_id;
        if (in_array($pid, $_SESSION['wishlist'])) {
            $_SESSION['wishlist'] = array_values(array_diff($_SESSION['wishlist'], [$pid]));
            echo json_encode([
                'success' => true,
                'wishlisted' => false,
                'message' => 'Removed from wishlist.',
                'wishlist_count' => count($_SESSION['wishlist']),
            ]);
        } else {
            $_SESSION['wishlist'][] = $pid;
            echo json_encode([
                'success' => true,
                'wishlisted' => true,
                'message' => 'Added to wishlist!',
                'wishlist_count' => count($_SESSION['wishlist']),
            ]);
        }
        break;

    // ── GET WISHLIST STATE ──
    case 'get_wishlist':
        echo json_encode([
            'success'  => true,
            'wishlist' => $_SESSION['wishlist'],
        ]);
        break;

    // ── GET CART COUNT ──
    case 'get_cart_count':
        $cart_count = array_sum(array_column($_SESSION['cart'], 'qty'));
        echo json_encode([
            'success'    => true,
            'cart_count' => $cart_count,
        ]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Unknown action.']);
}
