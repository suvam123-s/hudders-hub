#8:52


<?php
$pageTitle = 'Login - Hudders Hub';
include 'include/header.php';
?>

<section class="auth-section">
  <div class="auth-inner">

    <!-- Left Image -->
    <div class="auth-image">
      <img src="assets\css\image\about-image.png" alt="Hudders Hub Market Stall">
    </div>

    <!-- Right Form -->
    <div class="auth-container">
      <h2>Login</h2>
      <form class="auth-form" action="login_process.php" method="post">
        
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </div>

        <div class="form-options">
          <label><input type="checkbox" name="remember"> Keep me logged in</label>
          <a href="#">Forgot password?</a>
        </div>

        <button type="submit" class="btn btn-green">Log in</button>

        <div class="social-login">
          <button type="button" class="btn btn-outline">Sign in with Google</button>
        </div>

        <p class="auth-link">Don’t have an account? <a href="register.php">Sign up</a></p>
      </form>
    </div>

  </div>
</section>

<?php include 'include/footer.php'; ?>
