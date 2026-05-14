<?php
session_start();
// If already logged in, go home
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$pageTitle  = 'Login & Sign Up - Hudders Hub';
$isAuthPage = true;   // tells header.php to show Contact Us, hide USER dropdown
include 'include/header.php';


// Show any session messages
$error   = $_SESSION['auth_error']   ?? '';
$success = $_SESSION['auth_success'] ?? '';
unset($_SESSION['auth_error'], $_SESSION['auth_success']);

// Which tab to show by default
$activeTab = $_GET['tab'] ?? 'login'; // 'login' or 'register'
?>

<section class="auth-combined-section">
  <div class="auth-combined-inner">

    <!-- Left decorative panel -->
    <div class="auth-combined-image">
      <img src="assets/css/image/about-image.png" alt="Hudders Hub Market">
      <div class="auth-combined-overlay">
        <h2>Welcome to<br><span>Hudders Hub</span></h2>
        <p>Your local market, now online.</p>
      </div>
    </div>

    <!-- Right form panel -->
    <div class="auth-combined-box">

      <!-- Tab switcher -->
      <div class="auth-tabs">
        <button class="auth-tab-btn <?= $activeTab === 'login' ? 'active' : '' ?>"
                id="tabLogin" onclick="switchTab('login')">
          Login
        </button>
        <button class="auth-tab-btn <?= $activeTab === 'register' ? 'active' : '' ?>"
                id="tabRegister" onclick="switchTab('register')">
          Sign Up
        </button>
        <div class="auth-tab-indicator" id="tabIndicator"></div>
      </div>

      <?php if ($error): ?>
        <div class="auth-alert auth-alert-error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <?php if ($success): ?>
        <div class="auth-alert auth-alert-success"><?= htmlspecialchars($success) ?></div>
      <?php endif; ?>

      <!-- ── LOGIN FORM ── -->
      <div class="auth-form-panel <?= $activeTab === 'login' ? 'auth-panel-active' : '' ?>" id="panelLogin">
        <h3 class="auth-form-heading">Welcome back</h3>
        <p class="auth-form-sub">Log in to your account to continue shopping.</p>

        <form class="auth-form" action="login_process.php" method="post">
          <div class="form-group">
            <label for="login_email">Email Address</label>
            <div class="auth-input-group">
              <span class="auth-input-icon"><i class="fas fa-envelope"></i></span>
              <input type="email" id="login_email" name="email" placeholder="you@example.com" required>
            </div>
          </div>

          <div class="form-group">
            <label for="login_password">Password</label>
            <div class="auth-input-group">
              <span class="auth-input-icon"><i class="fas fa-lock"></i></span>
              <input type="password" id="login_password" name="password" placeholder="••••••••" required>
              <button type="button" class="toggle-pw" onclick="togglePw('login_password', this)" tabindex="-1">
                <i class="fas fa-eye"></i>
              </button>
            </div>
          </div>

          <div class="form-options">
            <label class="checkbox-label">
              <input type="checkbox" name="remember"> Keep me logged in
            </label>
            <a href="#" class="forgot-link">Forgot password?</a>
          </div>

          <button type="submit" class="btn btn-auth-primary">
            <i class="fas fa-sign-in-alt"></i> Log In
          </button>

          <p class="auth-switch-link">
            Don't have an account?
            <a href="#" onclick="switchTab('register'); return false;">Sign up here</a>
          </p>
        </form>
      </div>

      <!-- ── REGISTER FORM ── -->
      <div class="auth-form-panel <?= $activeTab === 'register' ? 'auth-panel-active' : '' ?>" id="panelRegister">
        <h3 class="auth-form-heading">Create an account</h3>
        <p class="auth-form-sub">Join Hudders Hub and start shopping local.</p>

        <form class="auth-form" action="Register_process.php" method="post">
          <div class="auth-form-row">
            <div class="form-group">
              <label for="reg_fname">First Name</label>
              <div class="auth-input-group">
                <span class="auth-input-icon"><i class="fas fa-user"></i></span>
                <input type="text" id="reg_fname" name="fname" placeholder="John" required>
              </div>
            </div>
            <div class="form-group">
              <label for="reg_lname">Last Name</label>
              <div class="auth-input-group">
                <span class="auth-input-icon"><i class="fas fa-user"></i></span>
                <input type="text" id="reg_lname" name="lname" placeholder="Smith" required>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="reg_email">Email Address</label>
            <div class="auth-input-group">
              <span class="auth-input-icon"><i class="fas fa-envelope"></i></span>
              <input type="email" id="reg_email" name="email" placeholder="you@example.com" required>
            </div>
          </div>

          <div class="form-group">
            <label for="reg_phone">Phone Number</label>
            <div class="auth-input-group">
              <span class="auth-input-icon"><i class="fas fa-phone"></i></span>
              <input type="text" id="reg_phone" name="phone" placeholder="+44 7700 000000" required>
            </div>
          </div>

          <div class="form-group">
            <label for="reg_password">Create Password</label>
            <div class="auth-input-group">
              <span class="auth-input-icon"><i class="fas fa-lock"></i></span>
              <input type="password" id="reg_password" name="password" placeholder="Min. 8 characters" required>
              <button type="button" class="toggle-pw" onclick="togglePw('reg_password', this)" tabindex="-1">
                <i class="fas fa-eye"></i>
              </button>
            </div>
          </div>

          <div class="form-options">
            <label class="checkbox-label">
              <input type="checkbox" name="terms" required>
              I agree to the <a href="terms.php" target="_blank">terms & privacy policy</a>
            </label>
          </div>

          <button type="submit" class="btn btn-auth-primary">
            <i class="fas fa-user-plus"></i> Create Account
          </button>

          <p class="auth-switch-link">
            Already have an account?
            <a href="#" onclick="switchTab('login'); return false;">Login here</a>
          </p>
        </form>
      </div>


    </div><!-- /.auth-combined-box -->
  </div><!-- /.auth-combined-inner -->
</section>

<script>
function switchTab(tab) {
  const loginPanel    = document.getElementById('panelLogin');
  const registerPanel = document.getElementById('panelRegister');
  const tabLogin      = document.getElementById('tabLogin');
  const tabRegister   = document.getElementById('tabRegister');
  const indicator     = document.getElementById('tabIndicator');

  if (tab === 'login') {
    loginPanel.classList.add('auth-panel-active');
    registerPanel.classList.remove('auth-panel-active');
    tabLogin.classList.add('active');
    tabRegister.classList.remove('active');
    indicator.style.transform = 'translateX(0%)';
  } else {
    registerPanel.classList.add('auth-panel-active');
    loginPanel.classList.remove('auth-panel-active');
    tabRegister.classList.add('active');
    tabLogin.classList.remove('active');
    indicator.style.transform = 'translateX(100%)';
  }
}

function togglePw(fieldId, btn) {
  const input = document.getElementById(fieldId);
  const icon  = btn.querySelector('i');
  if (input.type === 'password') {
    input.type = 'text';
    icon.className = 'fas fa-eye-slash';
  } else {
    input.type = 'password';
    icon.className = 'fas fa-eye';
  }
}

// Set initial indicator position
(function() {
  const activeTab = '<?= $activeTab ?>';
  const indicator = document.getElementById('tabIndicator');
  if (activeTab === 'register') indicator.style.transform = 'translateX(100%)';
})();
</script>

<?php include 'include/footer.php'; ?>
