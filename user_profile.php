<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: Login.php');
    exit;
}

require_once 'include/db_connect.php';
$conn = get_db_connection();

$user_id = $_SESSION['user_id'];
$sql = "SELECT email, phonenumber FROM USER_ACCOUNT WHERE user_ID = :user_id";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':user_id', $user_id);
oci_execute($stmt);
$user = oci_fetch_assoc($stmt);
oci_free_statement($stmt);

$email = $user['EMAIL'] ?? 'username123@gmail.com';
$phone = $user['PHONENUMBER'] ?? '+977-9823123456';

$pageTitle = 'User Profile – Hudders Hub';
include 'include/header.php';
?>
<link rel="stylesheet" href="assets/css/profile.css">

<main class="user-profile-wrapper">
    <!-- Decorative Leaves (assuming image exists, else it will be blank) -->
    <img src="assets/css/image/leaves.png" alt="" class="profile-vine">

    <div class="profile-info-section">
        <!-- Avatar -->
        <div class="profile-avatar-large"></div>

        <!-- User Info -->
        <p class="profile-email-large"><?= htmlspecialchars($email) ?></p>
        <p class="profile-phone-large"><?= htmlspecialchars($phone) ?></p>

        <!-- Actions -->
        <div class="profile-top-actions">
            <a href="update_profile.php" class="btn-update-profile">UPDATE</a>
            <a href="logout.php" class="btn-logout-profile">LOG OUT</a>
        </div>
    </div>

    <!-- Recent Purchases -->
    <div class="recent-purchases-container">
        <h2 class="recent-purchases-title">Recent Purchases</h2>

        <!-- Purchase Card 1 -->
        <div class="purchase-card">
            <div class="purchase-img-box"></div>
            <div class="purchase-details">
                <h3 class="purchase-name">Organic Seasonal Veg Box</h3>
                <p class="purchase-price">Price:<strong>$35.00</strong></p>
                <p class="purchase-desc">
                    A beautiful, hand-picked selection of this week's finest seasonal vegetables straight from Cleckhudderfax's local farms. Packed with nutrients and flavor, this box includes farm-fresh carrots, leafy greens, heirloom tomatoes, and crisp cucumbers, all grown without synthetic pesticides to support a healthier lifestyle and our local environment.
                </p>
                <div class="purchase-meta">
                    <span>012-345-678-901-23</span>
                    <span>Quantity : 12</span>
                </div>
            </div>
            <button class="btn-review">REVIEW</button>
        </div>

        <!-- Purchase Card 2 -->
        <div class="purchase-card">
            <div class="purchase-img-box"></div>
            <div class="purchase-details">
                <h3 class="purchase-name">Artisan Sourdough Loaf</h3>
                <p class="purchase-price">Price:<strong>$8.50</strong></p>
                <p class="purchase-desc">
                    Freshly baked daily by our master bakers, this traditional sourdough loaf is made using a slow-fermentation process that develops a deep, tangy flavor and a perfectly crisp crust. Crafted with organic, locally milled flour and a historic natural starter, it's the perfect companion for your morning breakfast or paired with our farmhouse cheeses.
                </p>
                <div class="purchase-meta">
                    <span>012-345-678-901-23</span>
                    <span>Quantity : 12</span>
                </div>
            </div>
            <button class="btn-review">REVIEW</button>
        </div>

        <!-- Purchase Card 3 -->
        <div class="purchase-card">
            <div class="purchase-img-box"></div>
            <div class="purchase-details">
                <h3 class="purchase-name">Aged Farmhouse Cheddar</h3>
                <p class="purchase-price">Price:<strong>$14.00</strong></p>
                <p class="purchase-desc">
                    Award-winning traditional cheddar cheese, carefully aged for over 12 months in our local dairy cellars. This rich, crumbly cheese boasts a robust and nutty profile with crystalline crunches that melt in your mouth. Perfect for cheeseboards, grating over hot dishes, or enjoying simply with a slice of fresh sourdough bread.
                </p>
                <div class="purchase-meta">
                    <span>012-345-678-901-23</span>
                    <span>Quantity : 12</span>
                </div>
            </div>
            <button class="btn-review">REVIEW</button>
        </div>

    </div>
</main>

<?php include 'include/footer.php'; ?>