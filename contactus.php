<?php

session_start();

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$success = '';
$error   = '';
$old     = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CSRF check
    if (
        empty($_POST['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        $error = 'Invalid request. Please refresh and try again.';

    } else {

        // Sanitise inputs
        $old = [
            'first_name' => trim(htmlspecialchars($_POST['first_name'] ?? '', ENT_QUOTES, 'UTF-8')),
            'last_name'  => trim(htmlspecialchars($_POST['last_name']  ?? '', ENT_QUOTES, 'UTF-8')),
            'email'      => trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL)),
            'phone'      => trim(htmlspecialchars($_POST['phone']      ?? '', ENT_QUOTES, 'UTF-8')),
            'subject'    => trim(htmlspecialchars($_POST['subject']    ?? '', ENT_QUOTES, 'UTF-8')),
            'message'    => trim(htmlspecialchars($_POST['message']    ?? '', ENT_QUOTES, 'UTF-8')),
        ];

        $allowed_subjects = ['General Inquiry', 'Technical Support', 'Order & Delivery', 'Feedback'];

        // Validate
        if (empty($old['first_name']) || empty($old['last_name']) ||
            empty($old['email'])      || empty($old['message'])) {
            $error = 'Please fill in all required fields.';

        } elseif (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';

        } elseif (!empty($old['phone']) && !preg_match('/^[0-9\+\(\)\s\-]{6,20}$/', $old['phone'])) {
            $error = 'Please enter a valid phone number.';

        } elseif (strlen($old['message']) < 10) {
            $error = 'Your message is too short.';

        } elseif (strlen($old['message']) > 2000) {
            $error = 'Message must not exceed 2000 characters.';

        } else {
            if (!in_array($old['subject'], $allowed_subjects, true)) {
                $old['subject'] = 'General Inquiry';
            }

            // ── Save message to a local log file ───────────────
            $log_dir  = __DIR__ . '/messages';
            $log_file = $log_dir . '/contacts.log';

            // Create messages/ folder if it doesn't exist
            if (!is_dir($log_dir)) {
                mkdir($log_dir, 0755, true);
            }

            $entry = "========================================\n"
                   . "Date:    " . date('Y-m-d H:i:s') . "\n"
                   . "Name:    {$old['first_name']} {$old['last_name']}\n"
                   . "Email:   {$old['email']}\n"
                   . "Phone:   {$old['phone']}\n"
                   . "Subject: {$old['subject']}\n"
                   . "Message:\n{$old['message']}\n\n";

            file_put_contents($log_file, $entry, FILE_APPEND | LOCK_EX);

            $success = 'Thank you, ' . $old['first_name'] . '! Your message has been sent.';
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            $old = []; // clear form
        }
    }
}

$pageTitle = 'Contact Us – Hudders Hub';
include 'include/header.php';
?>

<link rel="stylesheet" href="assets/css/contactus.css">

<main class="contact-page">

  <!-- Floral top-right decoration -->
  <img class="contact-floral"
       src="assets/css/image/leaves.jpeg"
       alt="" aria-hidden="true">

  <!-- Heading -->
  <div class="contact-heading">
    <h1>Contact Us</h1>
    <p>Any question or remarks? Just write us a message!</p>
  </div>

  <!-- Card -->
  <div class="contact-card">

    <!-- LEFT: Info -->
    <aside class="contact-info-panel">
      <h2>Contact Information</h2>
      <p class="tagline">Say something to start a live chat!</p>

      <div class="info-row">
        <i class="fas fa-phone"></i>
        <span>+111 3489202000</span>
      </div>
      <div class="info-row">
        <i class="fas fa-envelope"></i>
        <span>huddershub@gmail.com</span>
      </div>
      <div class="info-row">
        <i class="fas fa-map-marker-alt"></i>
        <span>Cleckhuddersfax , London</span>
      </div>

      <img class="panel-deco" src="assets/css/image/signpost.png" alt="" aria-hidden="true">
    </aside>

    <!-- RIGHT: Form -->
    <section class="contact-form-section">

      <?php if ($success): ?>
        <div class="alert alert-success" role="alert"><?= $success ?></div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="alert alert-error" role="alert"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST" action="contactus.php" novalidate autocomplete="on">
        <input type="hidden" name="csrf_token"
               value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

        <!-- Row 1: Name -->
        <div class="form-row">
          <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name"
                   maxlength="50" required autocomplete="given-name"
                   value="<?= htmlspecialchars($old['first_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
          </div>
          <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name"
                   maxlength="50" required autocomplete="family-name"
                   value="<?= htmlspecialchars($old['last_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
          </div>
        </div>

        <!-- Row 2: Email & Phone -->
        <div class="form-row">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email"
                   maxlength="150" required autocomplete="email"
                   value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
          </div>
          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone"
                   maxlength="20" autocomplete="tel"
                   value="<?= htmlspecialchars($old['phone'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
          </div>
        </div>

        <!-- Subject -->
        <div class="subject-section">
          <h4>Select Subject?</h4>
          <div class="radio-group">
            <?php
            $subjects = ['General Inquiry', 'Technical Support', 'Order & Delivery', 'Feedback'];
            $sel = $old['subject'] ?? 'General Inquiry';
            foreach ($subjects as $s):
            ?>
            <label class="radio-label">
              <input type="radio" name="subject"
                     value="<?= htmlspecialchars($s, ENT_QUOTES, 'UTF-8') ?>"
                     <?= ($sel === $s) ? 'checked' : '' ?>>
              <?= htmlspecialchars($s, ENT_QUOTES, 'UTF-8') ?>
            </label>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Message -->
        <div class="message-group">
          <label for="message">Message</label>
          <textarea id="message" name="message"
                    maxlength="2000" required
                    placeholder="Write your message.."><?= htmlspecialchars($old['message'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>

        <!-- Submit -->
        <div class="form-submit-row">
          <button type="submit" class="btn-send">Send Message</button>
        </div>

      </form>
    </section>

  </div><!-- /.contact-card -->

</main>

<?php include 'include/footer.php'; ?>