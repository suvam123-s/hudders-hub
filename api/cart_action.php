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
    'name' => 'Orange',
    'price' => 1.49,
    'image' => 'assets/css/image/orange.jpg',
    'rating' => 3.5,
    'desc' => 'Fresh organic oranges sourced from local farms in Cleckhudderfax. Rich in Vitamin C and perfect for juicing, snacking, or cooking. Our oranges are hand-picked at peak ripeness to ensure the best taste and nutritional value. Each orange is carefully inspected for quality before making it to our shelves.',
    'allergy' => 'No known allergens. However, please wash thoroughly before consumption.',
    'category' => 'grocery',
    'old_price' => null,
  ],
  2 => [
    'name' => 'Banana',
    'price' => 1.29,
    'image' => 'assets/css/image/bannan.png',
    'rating' => 4.5,
    'desc' => 'Ripe, sweet bananas sourced from sustainable farms. Perfect for snacking, smoothies, or baking. Rich in potassium and natural energy. Our bananas are harvested at the perfect stage and ripened naturally for optimum sweetness and texture.',
    'allergy' => 'No known allergens.',
    'category' => 'grocery',
    'old_price' => null,
  ],
  3 => [
    'name' => 'Pineapple',
    'price' => 2.50,
    'image' => 'assets/css/image/pineapple.jpg',
    'rating' => 5.0,
    'desc' => 'Tropical pineapple bursting with sweet, tangy flavour. Perfect for desserts, juices, or grilling. Our pineapples are hand-selected for peak ripeness and shipped fresh. Each fruit is rich in bromelain and Vitamin C, making it a delicious and healthy choice.',
    'allergy' => 'No known allergens. May cause mild irritation for those sensitive to bromelain.',
    'category' => 'grocery',
    'old_price' => 3.20,
  ],
  4 => [
    'name' => 'Pomegranate',
    'price' => 2.99,
    'image' => 'assets/css/image/fomegranate.jpg',
    'rating' => 3.5,
    'desc' => 'Rich, ruby-red pomegranate seeds bursting with antioxidants and sweet-tart flavour. Perfect for salads, juices, smoothie bowls, or as a garnish. Our pomegranates are sourced from the finest orchards and selected for maximum seed density and juice content.',
    'allergy' => 'No known allergens.',
    'category' => 'grocery',
    'old_price' => 3.50,
  ],
  5 => [
    'name' => 'Broccoli',
    'price' => 1.20,
    'image' => 'assets/css/image/broccoli.png',
    'rating' => 4.5,
    'desc' => 'Fresh organic broccoli sourced from local farms in Cleckhudderfax. Rich in vitamins C and K, this vibrant green vegetable is perfect for stir-fries, steaming, or roasting. Our broccoli is hand-picked at peak freshness to ensure the best taste and nutritional value.',
    'allergy' => 'No known allergens. However, please wash thoroughly before consumption.',
    'category' => 'grocery',
    'old_price' => null,
  ],
  6 => [
    'name' => 'Cauliflower',
    'price' => 1.50,
    'image' => 'assets/css/image/cauliflower.png',
    'rating' => 4.5,
    'desc' => 'Fresh organic cauliflower, versatile and nutritious. Perfect for roasting, mashing, making cauliflower rice, or as a pizza base alternative. Our cauliflowers are sourced from Yorkshire farms and hand-picked for optimal size and freshness.',
    'allergy' => 'No known allergens.',
    'category' => 'grocery',
    'old_price' => 1.99,
  ],
  7 => [
    'name' => 'Salmon',
    'price' => 6.90,
    'image' => 'assets/css/image/salmon.png',
    'rating' => 5.0,
    'desc' => 'Premium Atlantic salmon fillet delivered fresh daily from The Harbour Fish Co. Rich in omega-3 fatty acids and high-quality protein. Our salmon is sustainably sourced and perfect for grilling, baking, or pan-searing. Each fillet is carefully trimmed and deboned for your convenience.',
    'allergy' => 'Contains: Fish. May contain traces of crustaceans and molluscs. Not suitable for those with fish allergies.',
    'category' => 'fish',
    'old_price' => 7.99,
  ],
  8 => [
    'name' => 'Steak',
    'price' => 8.50,
    'image' => 'assets/css/image/steak.png',
    'rating' => 4.0,
    'desc' => 'Premium 28-day aged sirloin steak from Hendersons Butchers. Our beef is sourced from grass-fed cattle raised on local Yorkshire farms. Each cut is hand-selected by our master butcher for optimal marbling and tenderness. Perfect for grilling or pan-frying to your preferred doneness.',
    'allergy' => 'No known allergens. Suitable for most diets. Please note this product is processed in a facility that also handles other meats.',
    'category' => 'frozen_meat',
    'old_price' => null,
  ],
  9 => [
    'name' => 'Sourdough',
    'price' => 3.50,
    'image' => 'assets/css/image/sourdough.png',
    'rating' => 3.5,
    'desc' => 'Artisan sourdough bread baked fresh each morning at The Old Mill Bakery. Made using a traditional 48-hour fermentation process with our 25-year-old starter culture. The result is a beautifully crusty loaf with a soft, tangy interior. Perfect for sandwiches, toast, or simply enjoyed with butter.',
    'allergy' => 'Contains: Wheat (Gluten). May contain traces of milk, eggs, sesame, and nuts. Produced in a bakery that handles multiple allergens.',
    'category' => 'bakery',
    'old_price' => null,
  ],
  10 => [
    'name'  => 'Bagels',
    'price' => 2.50,
    'image' => 'assets/css/image/bagels.jpg',
    'rating' => 4.2,
    'desc'  => 'Freshly baked authentic bagels. Chewy on the inside and perfectly crisp on the outside.',
    'allergy' => 'Contains: Wheat (Gluten).',
    'category' => 'bakery',
    'old_price' => null,
  ],
  11 => [
    'name'  => 'Croissant',
    'price' => 1.80,
    'image' => 'assets/css/image/croissant.jpg',
    'rating' => 4.8,
    'desc'  => 'Classic French-style butter croissants. Flaky, buttery, and baked fresh daily.',
    'allergy' => 'Contains: Wheat (Gluten), Milk, Eggs.',
    'category' => 'bakery',
    'old_price' => null,
  ],
  12 => [
    'name'  => 'Cake',
    'price' => 4.50,
    'image' => 'assets/css/image/cake.jpg',
    'rating' => 4.5,
    'desc'  => 'Delicious homemade cake slice, perfect for dessert or afternoon tea.',
    'allergy' => 'Contains: Wheat (Gluten), Milk, Eggs.',
    'category' => 'bakery',
    'old_price' => 5.00,
  ],
  13 => [
    'name'  => 'Donuts',
    'price' => 3.00,
    'image' => 'assets/css/image/donuts.jpg',
    'rating' => 4.6,
    'desc'  => 'Sweet, glazed donuts that melt in your mouth.',
    'allergy' => 'Contains: Wheat (Gluten), Milk, Eggs, Soy.',
    'category' => 'bakery',
    'old_price' => null,
  ],
  14 => [
    'name'  => 'Muffins',
    'price' => 2.20,
    'image' => 'assets/css/image/muffins.jpg',
    'rating' => 4.3,
    'desc'  => 'Soft and fluffy muffins loaded with flavor.',
    'allergy' => 'Contains: Wheat (Gluten), Milk, Eggs.',
    'category' => 'bakery',
    'old_price' => null,
  ],
  15 => [
    'name'  => 'Cheese',
    'price' => 5.50,
    'image' => 'assets/css/image/cheese.jpg',
    'rating' => 4.7,
    'desc'  => 'Premium artisan cheese wedge. Rich, savory, and perfect for a cheeseboard.',
    'allergy' => 'Contains: Milk.',
    'category' => 'deli',
    'old_price' => null,
  ],
  16 => [
    'name'  => 'Ham',
    'price' => 4.20,
    'image' => 'assets/css/image/ham.jpg',
    'rating' => 4.4,
    'desc'  => 'High-quality cooked ham slices. Great for sandwiches or salads.',
    'allergy' => 'No known allergens.',
    'category' => 'deli',
    'old_price' => null,
  ],
  17 => [
    'name'  => 'Prawns',
    'price' => 8.90,
    'image' => 'assets/css/image/prawns.jpg',
    'rating' => 4.9,
    'desc'  => 'Fresh, succulent prawns ready to be cooked. Perfect for pasta or grilling.',
    'allergy' => 'Contains: Crustaceans.',
    'category' => 'fish',
    'old_price' => 9.50,
  ],
  18 => [
    'name'  => 'Coffee',
    'price' => 6.50,
    'image' => 'assets/css/image/coffee.jpg',
    'rating' => 4.8,
    'desc'  => 'Rich, aromatic coffee beans roasted to perfection.',
    'allergy' => 'No known allergens.',
    'category' => 'grocery',
    'old_price' => 7.20,
  ],
  19 => [
    'name'  => 'Cooking Oil',
    'price' => 3.20,
    'image' => 'assets/css/image/cooking oil.jpg',
    'rating' => 4.0,
    'desc'  => 'High-quality cooking oil for all your frying and baking needs.',
    'allergy' => 'No known allergens.',
    'category' => 'grocery',
    'old_price' => null,
  ],
  20 => [
    'name'  => 'Sugar',
    'price' => 1.50,
    'image' => 'assets/css/image/sugar.jpg',
    'rating' => 4.1,
    'desc'  => 'Fine granulated sugar, essential for baking and sweetening beverages.',
    'allergy' => 'No known allergens.',
    'category' => 'grocery',
    'old_price' => null,
  ],
  21 => [
    'name'  => 'Lemon Zest',
    'price' => 1.10,
    'image' => 'assets/css/image/Lemon zest.png',
    'rating' => 4.5,
    'desc'  => 'Fresh lemon zest to add a citrusy punch to your dishes.',
    'allergy' => 'No known allergens.',
    'category' => 'grocery',
    'old_price' => null,
  ],
  22 => [
    'name'  => 'Fish Fillet',
    'price' => 7.50,
    'image' => 'assets/css/image/Fish fillet.jpg',
    'rating' => 4.5,
    'desc'  => 'Fresh, boneless fish fillets, ready to be seasoned and pan-fried.',
    'allergy' => 'Contains: Fish.',
    'category' => 'fish',
    'old_price' => null,
  ],
  23 => [
    'name'  => 'Frozen Chicken',
    'price' => 5.50,
    'image' => 'assets/css/image/Frozen chicken.jpg',
    'rating' => 4.3,
    'desc'  => 'High-quality frozen chicken, perfect for roasting or stews.',
    'allergy' => 'No known allergens.',
    'category' => 'frozen_meat',
    'old_price' => null,
  ],
  24 => [
    'name'  => 'Lobster',
    'price' => 25.00,
    'image' => 'assets/css/image/Lobster.jpg',
    'rating' => 4.9,
    'desc'  => 'Premium fresh lobster. A luxurious seafood treat.',
    'allergy' => 'Contains: Crustaceans.',
    'category' => 'fish',
    'old_price' => 28.00,
  ],
  25 => [
    'name'  => 'Tuna',
    'price' => 12.00,
    'image' => 'assets/css/image/Tuna.jpg',
    'rating' => 4.6,
    'desc'  => 'Fresh, sashimi-grade tuna steaks. Perfect for searing.',
    'allergy' => 'Contains: Fish.',
    'category' => 'fish',
    'old_price' => null,
  ],
  26 => [
    'name'  => 'Bacon',
    'price' => 4.80,
    'image' => 'assets/css/image/bacon.jpg',
    'rating' => 4.7,
    'desc'  => 'Thick-cut, naturally smoked bacon. Crispy and delicious.',
    'allergy' => 'No known allergens.',
    'category' => 'frozen_meat',
    'old_price' => null,
  ],
  27 => [
    'name'  => 'Beef Steak',
    'price' => 10.50,
    'image' => 'assets/css/image/beef steak.jpg',
    'rating' => 4.8,
    'desc'  => 'Tender and juicy beef steak, aged to perfection.',
    'allergy' => 'No known allergens.',
    'category' => 'frozen_meat',
    'old_price' => 12.00,
  ],
  28 => [
    'name'  => 'Pickle',
    'price' => 2.50,
    'image' => 'assets/css/image/pickle.jpg',
    'rating' => 4.1,
    'desc'  => 'Crunchy and tangy pickles, perfect for sandwiches and burgers.',
    'allergy' => 'No known allergens.',
    'category' => 'deli',
    'old_price' => null,
  ],
  29 => [
    'name'  => 'Salad',
    'price' => 3.50,
    'image' => 'assets/css/image/salad.jpg',
    'rating' => 4.4,
    'desc'  => 'Freshly prepared mixed green salad with a light vinaigrette.',
    'allergy' => 'No known allergens.',
    'category' => 'deli',
    'old_price' => null,
  ],
  30 => [
    'name'  => 'Sandwich',
    'price' => 4.50,
    'image' => 'assets/css/image/sandwich.jpg',
    'rating' => 4.6,
    'desc'  => 'Handcrafted deli sandwich packed with fresh ingredients.',
    'allergy' => 'Contains: Wheat (Gluten), Milk.',
    'category' => 'deli',
    'old_price' => null,
  ],
  31 => [
    'name'  => 'Cookies',
    'price' => 2.80,
    'image' => 'assets/css/image/Cookies.jpg',
    'rating' => 4.6,
    'desc'  => 'Freshly baked chocolate chip cookies. Soft and chewy.',
    'allergy' => 'Contains: Wheat (Gluten), Milk, Eggs, Soy.',
    'category' => 'bakery',
    'old_price' => null,
  ],
  32 => [
    'name'  => 'Frozen Mutton',
    'price' => 14.50,
    'image' => 'assets/css/image/Frozen mutton.jpg',
    'rating' => 4.3,
    'desc'  => 'Premium cuts of frozen mutton. Perfect for slow cooking and curries.',
    'allergy' => 'No known allergens.',
    'category' => 'frozen_meat',
    'old_price' => null,
  ],
  33 => [
    'name'  => 'Olives',
    'price' => 3.20,
    'image' => 'assets/css/image/Olives.jpg',
    'rating' => 4.5,
    'desc'  => 'Marinated mixed olives. A great appetizer or snack.',
    'allergy' => 'No known allergens.',
    'category' => 'deli',
    'old_price' => null,
  ],
  34 => [
    'name'  => 'Sausage',
    'price' => 5.00,
    'image' => 'assets/css/image/Sausage.jpg',
    'rating' => 4.4,
    'desc'  => 'High-quality pork sausages, great for grilling or breakfast.',
    'allergy' => 'Contains: Wheat (Gluten), Sulphites.',
    'category' => 'frozen_meat',
    'old_price' => null,
  ],
  35 => [
    'name'  => 'Bread',
    'price' => 2.00,
    'image' => 'assets/css/image/bread.jpg',
    'rating' => 4.2,
    'desc'  => 'Freshly baked farmhouse white bread loaf.',
    'allergy' => 'Contains: Wheat (Gluten).',
    'category' => 'bakery',
    'old_price' => null,
  ],
  37 => [
    'name'  => 'Pastries',
    'price' => 3.50,
    'image' => 'assets/css/image/pastries.jpg',
    'rating' => 4.7,
    'desc'  => 'Assorted Danish pastries. Flaky and sweet.',
    'allergy' => 'Contains: Wheat (Gluten), Milk, Eggs.',
    'category' => 'bakery',
    'old_price' => null,
  ],
  38 => [
    'name'  => 'Salami',
    'price' => 4.80,
    'image' => 'assets/css/image/salami.jpg',
    'rating' => 4.5,
    'desc'  => 'Authentic Italian sliced salami. Great for charcuterie boards.',
    'allergy' => 'No known allergens.',
    'category' => 'deli',
    'old_price' => null,
  ],
  39 => [
    'name'  => 'Smoked Meat',
    'price' => 6.00,
    'image' => 'assets/css/image/smoked meat.jpg',
    'rating' => 4.8,
    'desc'  => 'Deliciously seasoned and slow-smoked meat slices.',
    'allergy' => 'No known allergens.',
    'category' => 'deli',
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
