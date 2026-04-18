<?php
$pageTitle = 'Register - Hudders Hub';
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
      <h2>Register</h2>
      <form class="auth-form" action="register_process.php" method="post">
        
        <div class="form-group">
          <label for="fname">First Name</label>
          <input type="text" id="fname" name="fname" required>
        </div>

        <div class="form-group">
          <label for="lname">Last Name</label>
          <input type="text" id="lname" name="lname" required>
        </div>

        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
          <label for="phone">Phone Number</label>
          <input type="text" id="phone" name="phone" required>
        </div>

        <div class="form-group">
          <label for="password">Create Password</label>
          <input type="password" id="password" name="password" required>
        </div>

        <div class="form-options">
          <label><input type="checkbox" name="terms" required> I agree to the terms and privacy policy</label>
        </div>

        <button type="submit" class="btn btn-green">Create an account</button>

        <p class="auth-link">Already have an account? <a href="login.php">Login here</a></p>
      </form>
    </div>

  </div>
</section>

<?php include 'include/footer.php'; ?>
