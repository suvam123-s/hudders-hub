<?php
$pageTitle = 'Contact Us - Hudders Hub';
include 'include/header.php';

$success = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname   = trim($_POST['fname']   ?? '');
    $lname   = trim($_POST['lname']   ?? '');
    $email   = trim($_POST['email']   ?? '');
    $phone   = trim($_POST['phone']   ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($fname))  $errors[] = 'First name is required.';
    if (empty($lname))  $errors[] = 'Last name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email address is required.';
    if (empty($message)) $errors[] = 'Please write a message.';

    if (empty($errors)) {
        // TODO: replace with actual mail / DB insert
        // mail('huddershub@gmail.com', 'Contact: '.$subject, $message, 'From: '.$email);
        $success = 'Thank you, ' . htmlspecialchars($fname) . '! Your message has been sent.';
    }
}
?>

<section class="contact-section">

    <!-- Decorative vine top-right (mirrors the screenshot) -->
    <div class="contact-vine contact-vine--tr" aria-hidden="true"></div>

    <div class="contact-wrapper">

        <div class="contact-heading">
            <h1>Contact Us</h1>
            <p>Any question or remarks? Just write us a message!</p>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="contact-alert contact-alert--error">
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="contact-alert contact-alert--success">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <div class="contact-card">

            <!-- LEFT: Contact Information -->
            <div class="contact-info">
                <h3>Contact Information</h3>
                <p class="contact-info__sub">Say something to start a live chat!</p>

                <ul class="contact-details">
                    <li>
                        <span class="contact-icon">📞</span>
                        <span>+111 3489202000</span>
                    </li>
                    <li>
                        <span class="contact-icon">✉️</span>
                        <span>huddershub@gmail.com</span>
                    </li>
                    <li>
                        <span class="contact-icon">📍</span>
                        <span>Cleckhuddersfax, London</span>
                    </li>
                </ul>

                <!-- Decorative signpost image inside card -->
                <div class="contact-info__deco" aria-hidden="true"></div>
            </div>

            <!-- RIGHT: Contact Form -->
            <div class="contact-form-wrap">
                <form class="contact-form" action="contact.php" method="post">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="fname">First Name</label>
                            <input type="text" id="fname" name="fname"
                                   value="<?= htmlspecialchars($_POST['fname'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="lname">Last Name</label>
                            <input type="text" id="lname" name="lname"
                                   value="<?= htmlspecialchars($_POST['lname'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email"
                                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone"
                                   value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                        </div>
                    </div>

                    <!-- Subject -->
                    <div class="form-group form-group--full">
                        <label>Select Subject?</label>
                        <div class="subject-options">
                            <?php
                            $subjects = ['General Inquiry', 'Order Issue', 'Trader Support', 'Other'];
                            $selected = $_POST['subject'] ?? 'General Inquiry';
                            foreach ($subjects as $s):
                            ?>
                            <label class="subject-option">
                                <input type="radio" name="subject" value="<?= htmlspecialchars($s) ?>"
                                    <?= $selected === $s ? 'checked' : '' ?>>
                                <span class="subject-label"><?= htmlspecialchars($s) ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Message -->
                    <div class="form-group form-group--full">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="4"
                                  placeholder="Write your message.." required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                    </div>

                    <div class="form-submit-row">
                        <button type="submit" class="btn btn-dark btn-send">Send Message</button>
                    </div>

                </form>
            </div>

        </div><!-- /.contact-card -->

    </div><!-- /.contact-wrapper -->

</section>

<style>
/* ── Contact Section ──────────────────────── */
.contact-section {
    background: var(--beige-light);
    min-height: calc(100vh - 200px);
    padding: 4rem 2rem 6rem;
    position: relative;
    overflow: hidden;
}

/* Vine decorations (CSS-only approximation matching screenshot) */
.contact-vine--tr {
    position: absolute;
    top: 0;
    right: 0;
    width: 180px;
    height: 320px;
    background:
        radial-gradient(ellipse 12px 18px at 70% 10%, #8fad6a 80%, transparent 100%),
        radial-gradient(ellipse 10px 14px at 90% 25%, #a3bf7e 80%, transparent 100%),
        radial-gradient(ellipse 14px 10px at 55% 40%, #7a9a5c 80%, transparent 100%),
        radial-gradient(ellipse 10px 16px at 80% 55%, #8fad6a 80%, transparent 100%),
        radial-gradient(ellipse 12px 10px at 60% 70%, #a3bf7e 80%, transparent 100%),
        radial-gradient(ellipse 8px 12px at 95% 80%, #7a9a5c 80%, transparent 100%);
    background-repeat: no-repeat;
    opacity: 0.55;
    pointer-events: none;
}

/* Heading */
.contact-wrapper {
    max-width: 980px;
    margin: 0 auto;
}

.contact-heading {
    text-align: center;
    margin-bottom: 2.5rem;
}

.contact-heading h1 {
    font-family: var(--font-display);
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.contact-heading p {
    font-size: 1rem;
    color: var(--grey);
}

/* Alerts */
.contact-alert {
    max-width: 900px;
    margin: 0 auto 1.5rem;
    padding: 1rem 1.5rem;
    border-radius: var(--radius);
    font-size: 0.9rem;
}

.contact-alert--error {
    background: #fff0f0;
    border: 1.5px solid #f5c6c6;
    color: #c0392b;
}

.contact-alert--error ul {
    padding-left: 1.25rem;
}

.contact-alert--success {
    background: #f0fff4;
    border: 1.5px solid #9ae6b4;
    color: #276749;
    font-weight: 500;
}

/* Card */
.contact-card {
    background: var(--cream);
    border-radius: 16px;
    box-shadow: var(--shadow);
    display: grid;
    grid-template-columns: 280px 1fr;
    overflow: hidden;
    min-height: 440px;
}

/* Info panel */
.contact-info {
    background: var(--dark-green);
    color: white;
    padding: 2.5rem 2rem;
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
}

.contact-info h3 {
    font-family: var(--font-display);
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 0.4rem;
}

.contact-info__sub {
    font-size: 0.8rem;
    color: rgba(255,255,255,0.7);
    margin-bottom: 2.5rem;
}

.contact-details {
    list-style: none;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.contact-details li {
    display: flex;
    align-items: flex-start;
    gap: 0.85rem;
    font-size: 0.875rem;
    line-height: 1.5;
}

.contact-icon {
    font-size: 1rem;
    flex-shrink: 0;
    margin-top: 0.1rem;
}

/* Decorative circles bottom-right of info panel */
.contact-info__deco {
    position: absolute;
    bottom: -30px;
    right: -30px;
    width: 180px;
    height: 180px;
    border: 40px solid rgba(255,255,255,0.08);
    border-radius: 50%;
}
.contact-info__deco::before {
    content: '';
    position: absolute;
    top: 30px;
    left: 30px;
    right: 30px;
    bottom: 30px;
    border: 20px solid rgba(255,255,255,0.06);
    border-radius: 50%;
}

/* Form panel */
.contact-form-wrap {
    padding: 2.5rem 2.5rem 2rem;
}

.contact-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
}

.form-group--full {
    /* handled by parent flex */
}

.form-group label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--grey);
    letter-spacing: 0.03em;
    text-transform: uppercase;
}

.form-group input,
.form-group textarea {
    border: none;
    border-bottom: 1.5px solid var(--light-grey);
    background: transparent;
    padding: 0.5rem 0;
    font-size: 0.9rem;
    color: var(--dark);
    font-family: var(--font-body);
    outline: none;
    transition: border-color 0.15s;
    width: 100%;
}

.form-group input:focus,
.form-group textarea:focus {
    border-bottom-color: var(--dark-green);
}

.form-group textarea {
    resize: none;
}

/* Subject options */
.subject-options {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
    margin-top: 0.5rem;
}

.subject-option {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    cursor: pointer;
    font-size: 0.85rem;
    color: var(--dark);
}

.subject-option input[type="radio"] {
    accent-color: var(--dark-green);
    width: 15px;
    height: 15px;
    cursor: pointer;
    flex-shrink: 0;
}

.subject-label {
    white-space: nowrap;
}

/* Submit row */
.form-submit-row {
    display: flex;
    justify-content: flex-end;
}

.btn-send {
    padding: 0.75rem 2rem;
    font-size: 0.9rem;
    font-weight: 600;
    letter-spacing: 0.02em;
}

/* ── Responsive ───────────────────────────── */
@media (max-width: 760px) {
    .contact-card {
        grid-template-columns: 1fr;
    }
    .contact-info {
        padding: 2rem;
    }
    .form-row {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    .contact-form-wrap {
        padding: 2rem 1.5rem;
    }
    .form-submit-row {
        justify-content: center;
    }
    .btn-send {
        width: 100%;
    }
}
</style>

<?php include 'include/footer.php'; ?>