<?php
session_start();
$pageTitle = 'Verify Email - Hudders Hub';
$isAuthPage = true;
include 'include/header.php';

// Redirect if not coming from registration
if (!isset($_SESSION['otp_pending_email'])) {
    header("Location: Register.php");
    exit();
}

$email = $_SESSION['otp_pending_email'];
$name = $_SESSION['otp_pending_name'] ?? 'User';
$error = $_SESSION['otp_error'] ?? '';
unset($_SESSION['otp_error']);
?>

<style>
.otp-section {
    padding: 60px 20px;
    min-height: calc(100vh - 200px);
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
}
.otp-container {
    background: #fff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    max-width: 500px;
    width: 100%;
    text-align: center;
}
.otp-icon {
    font-size: 48px;
    color: #52b788;
    margin-bottom: 20px;
}
.otp-title {
    font-size: 24px;
    color: #1a1a2e;
    margin-bottom: 10px;
    font-weight: 700;
}
.otp-desc {
    color: #666;
    margin-bottom: 30px;
    line-height: 1.6;
}
.otp-inputs {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 30px;
}
.otp-input {
    width: 50px;
    height: 60px;
    font-size: 24px;
    text-align: center;
    border: 2px solid #ddd;
    border-radius: 8px;
    font-weight: bold;
    color: #2d6a4f;
    transition: all 0.3s;
}
.otp-input:focus {
    border-color: #52b788;
    outline: none;
    box-shadow: 0 0 0 3px rgba(82, 183, 136, 0.2);
}
.otp-error {
    color: #d90429;
    background: #ffe3e3;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 20px;
    font-size: 14px;
}
.btn-verify {
    background: #2d6a4f;
    color: white;
    border: none;
    padding: 12px 30px;
    font-size: 16px;
    border-radius: 6px;
    cursor: pointer;
    width: 100%;
    font-weight: 600;
    transition: background 0.3s;
}
.btn-verify:hover {
    background: #1b4332;
}
</style>

<section class="otp-section">
    <div class="otp-container">
        <i class="fas fa-envelope-open-text otp-icon"></i>
        <h2 class="otp-title">Verify Your Email</h2>
        <p class="otp-desc">
            Hi <?= htmlspecialchars($name) ?>, we've sent a 6-digit code to <strong><?= htmlspecialchars($email) ?></strong>.
            <br>Please enter it below to activate your account.
        </p>

        <?php if ($error): ?>
            <div class="otp-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="verify_otp_process.php" method="post" id="otpForm">
            <div class="otp-inputs">
                <input type="text" class="otp-input" name="otp[]" maxlength="1" required autocomplete="off" autofocus>
                <input type="text" class="otp-input" name="otp[]" maxlength="1" required autocomplete="off">
                <input type="text" class="otp-input" name="otp[]" maxlength="1" required autocomplete="off">
                <input type="text" class="otp-input" name="otp[]" maxlength="1" required autocomplete="off">
                <input type="text" class="otp-input" name="otp[]" maxlength="1" required autocomplete="off">
                <input type="text" class="otp-input" name="otp[]" maxlength="1" required autocomplete="off">
            </div>
            
            <input type="hidden" name="full_otp" id="full_otp">
            <button type="submit" class="btn-verify">Verify Account</button>
        </form>
    </div>
</section>

<script>
// Auto-advance OTP inputs
const inputs = document.querySelectorAll('.otp-input');
const fullOtp = document.getElementById('full_otp');

inputs.forEach((input, index) => {
    input.addEventListener('keyup', (e) => {
        // If a number is entered, move to next
        if (e.key >= 0 && e.key <= 9) {
            if (index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        }
        // If backspace is pressed, move to previous
        else if (e.key === 'Backspace') {
            if (index > 0) {
                inputs[index - 1].focus();
            }
        }
        
        // Update hidden field
        updateFullOtp();
    });
    
    // Select all text on focus
    input.addEventListener('focus', () => {
        input.select();
    });
});

function updateFullOtp() {
    let val = '';
    inputs.forEach(input => {
        val += input.value;
    });
    fullOtp.value = val;
}

// Ensure form submission uses the hidden field
document.getElementById('otpForm').addEventListener('submit', (e) => {
    updateFullOtp();
    if (fullOtp.value.length !== 6) {
        e.preventDefault();
        alert('Please enter a 6-digit OTP.');
    }
});
</script>

<?php include 'include/footer.php'; ?>
