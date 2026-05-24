<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: Login.php');
    exit;
}

require_once 'include/db_connect.php';
$conn = get_db_connection();

$user_id = $_SESSION['user_id'];
$sql = "SELECT first_name, last_name, email, phonenumber, TO_CHAR(DOB, 'YYYY-MM-DD') AS DOB 
        FROM USER_ACCOUNT WHERE user_ID = :user_id";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':user_id', $user_id);
oci_execute($stmt);
$user = oci_fetch_assoc($stmt);
oci_free_statement($stmt);

$full_name = ($user['FIRST_NAME'] ?? '') . ' ' . ($user['LAST_NAME'] ?? '');
$email = $user['EMAIL'] ?? '';
$phone = $user['PHONENUMBER'] ?? '';
$dob = $user['DOB'] ?? '';

$pageTitle = 'Update Profile – Hudders Hub';
include 'include/header.php';
?>
<link rel="stylesheet" href="assets/css/profile.css">

<main class="profile-page-wrapper">
    <div class="update-profile-card">
        <h1 class="update-title">Update profile</h1>

        <form action="update_profile_process.php" method="POST" enctype="multipart/form-data" class="update-form">
            
            <div class="update-photo-section">
                <div class="photo-placeholder"></div>
                <div class="photo-actions">
                    <p class="photo-label">Upload your photo</p>
                    <p class="photo-desc">Your photo should be in PNG or JPG format</p>
                    <div class="photo-buttons">
                        <label class="btn-choose-image">
                            Choose Image
                            <input type="file" name="profile_image" accept="image/png, image/jpeg" style="display:none;">
                        </label>
                        <button type="button" class="btn-remove-image">Remove</button>
                    </div>
                </div>
            </div>

            <div class="update-fields">
                <div class="form-group">
                    <label>Full name</label>
                    <input type="text" name="full_name" placeholder="Your full name" value="<?= htmlspecialchars($full_name) ?>">
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Your email" value="<?= htmlspecialchars($email) ?>">
                </div>

                <div class="form-group">
                    <label>Phone number</label>
                    <input type="tel" name="phone" placeholder="Your phone number" value="<?= htmlspecialchars($phone) ?>">
                </div>

                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" name="dob" value="<?= htmlspecialchars($dob) ?>">
                </div>
            </div>

            <div class="password-section">
                <hr class="profile-divider">
                <h2 class="update-subtitle">Change Password</h2>
                
                <div class="update-fields">
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" placeholder="Leave blank to keep current password">
                    </div>
                    
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="new_password" placeholder="New password">
                    </div>

                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="confirm_password" placeholder="Confirm new password">
                    </div>
                </div>
            </div>

            <div class="update-form-actions">
                <a href="user_profile.php" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-save">Save profile</button>
            </div>
        </form>
    </div>
</main>

<?php include 'include/footer.php'; ?>
