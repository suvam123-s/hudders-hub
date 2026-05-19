<?php
require_once __DIR__ . '/db_connect.php';
$conn = get_db_connection();

// Fetch products
$sql_prod = "SELECT p.product_ID, p.product_name, p.item_price, p.product_image, p.product_description, p.allergy, c.category_name, c.category_ID
             FROM PRODUCT p
             JOIN PRODUCT_CATEGORY c ON p.category_ID = c.category_ID";
$stmt_prod = oci_parse($conn, $sql_prod);
oci_execute($stmt_prod);

$products = [];
while ($row = oci_fetch_assoc($stmt_prod)) {
    $cat_key = 'cat_' . $row['CATEGORY_ID'];

    // In Oracle, CLOBs might need to be read, but oci_fetch_assoc usually returns them as strings or objects.
    // We can use load() if it's an object.
    $desc = is_object($row['PRODUCT_DESCRIPTION']) ? $row['PRODUCT_DESCRIPTION']->load() : $row['PRODUCT_DESCRIPTION'];

    $products[$row['PRODUCT_ID']] = [
        'name' => $row['PRODUCT_NAME'],
        'price' => (float) $row['ITEM_PRICE'],
        'image' => 'assets/css/image/' . ($row['PRODUCT_IMAGE'] ? $row['PRODUCT_IMAGE'] : 'placeholder.png'),
        'rating' => 4.5, // Default rating
        'desc' => $desc,
        'allergy' => $row['ALLERGY'] ? $row['ALLERGY'] : 'No known allergens.',
        'category' => $cat_key,
        'old_price' => null
    ];
}
oci_free_statement($stmt_prod);

// Fetch categories
$sql_cat = "SELECT category_ID, category_name FROM PRODUCT_CATEGORY";
$stmt_cat = oci_parse($conn, $sql_cat);
oci_execute($stmt_cat);

$categories = [];
while ($row = oci_fetch_assoc($stmt_cat)) {
    $cat_key = 'cat_' . $row['CATEGORY_ID'];
    $categories[$cat_key] = $row['CATEGORY_NAME'];
}
oci_free_statement($stmt_cat);
oci_close($conn);
?>