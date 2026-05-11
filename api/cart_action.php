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
    return [
        1 => [
            'name'  => 'Orange',
            'price' => 145,
            'image' => 'assets/css/image/orange.jpg',
            'rating' => 3.5,
            'desc'  => 'Fresh organic oranges, hand-picked from local farms.',
            'allergy' => 'No known allergens.',
            'category' => 'grocery',
            'old_price' => null,
        ],
        2 => [
            'name'  => 'Banana',
            'price' => 180,
            'image' => 'assets/css/image/bannan.png',
            'rating' => 4.5,
            'desc'  => 'Ripe, sweet bananas perfect for snacking or smoothies.',
            'allergy' => 'No known allergens.',
            'category' => 'grocery',
            'old_price' => null,
        ],
        3 => [
            'name'  => 'Pineapple',
            'price' => 120,
            'image' => 'assets/css/image/pineapple.jpg',
            'rating' => 5.0,
            'desc'  => 'Tropical pineapple, sweet and juicy.',
            'allergy' => 'No known allergens.',
            'category' => 'grocery',
            'old_price' => 150,
        ],
        4 => [
            'name'  => 'Pomegranate',
            'price' => 240,
            'image' => 'assets/css/image/fomegranate.jpg',
            'rating' => 3.5,
            'desc'  => 'Rich, ruby-red pomegranate seeds bursting with antioxidants.',
            'allergy' => 'No known allergens.',
            'category' => 'grocery',
            'old_price' => 260,
        ],
        5 => [
            'name'  => 'Broccoli',
            'price' => 180,
            'image' => 'assets/css/image/broccoli.png',
            'rating' => 4.5,
            'desc'  => 'Fresh organic broccoli from local farms. Rich in vitamins C and K.',
            'allergy' => 'No known allergens.',
            'category' => 'grocery',
            'old_price' => null,
        ],
        6 => [
            'name'  => 'Cauliflower',
            'price' => 130,
            'image' => 'assets/css/image/cauliflower.png',
            'rating' => 4.5,
            'desc'  => 'Fresh organic cauliflower, perfect for roasting or steaming.',
            'allergy' => 'No known allergens.',
            'category' => 'grocery',
            'old_price' => 160,
        ],
        7 => [
            'name'  => 'Salmon',
            'price' => 212,
            'image' => 'assets/css/image/salmon.png',
            'rating' => 5.0,
            'desc'  => 'Premium Atlantic salmon fillet, fresh daily. Rich in omega-3.',
            'allergy' => 'Contains: Fish.',
            'category' => 'fish',
            'old_price' => 232,
        ],
        8 => [
            'name'  => 'Steak',
            'price' => 145,
            'image' => 'assets/css/image/steak.png',
            'rating' => 4.0,
            'desc'  => 'Premium 28-day aged sirloin steak from Yorkshire farms.',
            'allergy' => 'No known allergens.',
            'category' => 'frozen_meat',
            'old_price' => null,
        ],
        9 => [
            'name'  => 'Sourdough',
            'price' => 80,
            'image' => 'assets/css/image/sourdough.png',
            'rating' => 3.5,
            'desc'  => 'Artisan 48-hour fermented sourdough bread. Crispy crust, soft interior.',
            'allergy' => 'Contains: Wheat (Gluten).',
            'category' => 'bakery',
            'old_price' => null,
        ],
    ];
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
