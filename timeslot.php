<?php
session_start();

// Get the attempted timeslot from the session or default to demo values
$day = $_SESSION['full_slot_day'] ?? 'Wednesday';
$time = $_SESSION['full_slot_time'] ?? '10:00 – 12:00';

$pageTitle = 'Timeslot is Full – Hudders Hub';
include 'include/header.php';
?>

<style>
/* self-contained styles for the timeslot full warning page to prevent caching issues */
.co-page {
    background: #f5f2e8 !important; /* Cream background matching checkout page */
    min-height: 100vh;
    padding: 50px 0 90px;
}

.tf-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 60px 40px;
    box-shadow: 0 4px 28px rgba(0, 0, 0, 0.07);
    max-width: 580px;
    margin: 40px auto;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    animation: fadeInUp 0.4s ease-out;
}

.tf-icon-wrap {
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 90px;
    height: 90px;
}

.tf-title {
    font-family: var(--font-body), 'Inter', sans-serif;
    font-size: 1.85rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 16px;
    letter-spacing: -0.01em;
}

.tf-text {
    font-family: var(--font-body), 'Inter', sans-serif;
    font-size: 0.95rem;
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 32px;
    max-width: 440px;
}

.tf-text strong {
    color: #0f172a;
    font-weight: 700;
}

.tf-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 32px;
    background: #d97706; /* Orange-brown background matching the screenshot */
    color: #fff !important;
    border: none;
    border-radius: 30px;
    font-family: var(--font-body), 'Inter', sans-serif;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s ease-in-out;
    box-shadow: 0 4px 14px rgba(217, 119, 6, 0.3);
}

.tf-btn:hover {
    background: #b45309;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(217, 119, 6, 0.45);
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 480px) {
    .tf-card {
        padding: 40px 20px;
        margin: 20px 10px;
    }
    .tf-title {
        font-size: 1.5rem;
    }
    .tf-text {
        font-size: 0.88rem;
    }
}
</style>

<main class="co-page">
  <div class="co-wrap">

    <!-- ── Step indicator ─────────────────────── -->
    <div class="co-steps">
      <div class="co-step active">
        <div class="step-bubble">1</div>
        <span>Collection Slot</span>
      </div>
      <div class="step-connector"></div>
      <div class="co-step">
        <div class="step-bubble">2</div>
        <span>Payment</span>
      </div>
      <div class="step-connector"></div>
      <div class="co-step">
        <div class="step-bubble">3</div>
        <span>Confirmed</span>
      </div>
    </div>

    <!-- Main Warning Card -->
    <div class="tf-card">
      <div class="tf-icon-wrap">
        <!-- Custom Calendar SVG for 100% accurate rendering and zero font caching issues -->
        <svg class="tf-calendar-svg" width="90" height="90" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
          <!-- Binder Rings -->
          <rect x="25" y="4" width="8" height="18" rx="4" fill="#a0aec0" />
          <rect x="67" y="4" width="8" height="18" rx="4" fill="#a0aec0" />
          <!-- Calendar Body -->
          <rect x="15" y="14" width="70" height="76" rx="12" fill="#E53E3E" />
          <!-- Top Bar (Header) of the calendar -->
          <path d="M15 26C15 19.3726 20.3726 14 27 14H73C79.6274 14 85 19.3726 85 26V38H15V26Z" fill="#C53030" />
          <!-- Small binder holes on the body -->
          <circle cx="29" cy="26" r="4" fill="#F7FAFC" />
          <circle cx="71" cy="26" r="4" fill="#F7FAFC" />
          <!-- White X -->
          <path d="M38 52L62 76M62 52L38 76" stroke="white" stroke-width="8" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </div>
      <h1 class="tf-title">Timeslot is Full</h1>
      <p class="tf-text">
        Sorry, the <strong><?= htmlspecialchars($day, ENT_QUOTES, 'UTF-8') ?></strong> &nbsp;·&nbsp; <strong><?= htmlspecialchars($time, ENT_QUOTES, 'UTF-8') ?></strong> slot is fully booked.<br>
        Please go back and pick another timeslot.
      </p>
      <a href="checkout.php" class="tf-btn">
        <i class="fas fa-arrow-left"></i> Pick Another Timeslot
      </a>
    </div>

  </div>
</main>

<?php include 'include/footer.php'; ?>
