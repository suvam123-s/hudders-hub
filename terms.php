<?php
$pageTitle = 'Terms and Conditions - Hudders Hub';
include 'include/header.php';
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Lato:wght@300;400;700&display=swap');

    body {
        background-color: #eee4d8;
        margin: 0;
        padding: 0;
        font-family: 'Lato', sans-serif;
    }

    /* ── PAGE WRAPPER ── */
    .tc-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 60px 30px 100px;
    }

    /* ── HERO BANNER ── */
    .tc-hero {
        background-color: #607758;
        border-radius: 20px;
        padding: 70px 60px;
        margin-bottom: 60px;
        position: relative;
        overflow: hidden;
    }

    .tc-hero::before {
        content: '§';
        position: absolute;
        right: 60px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 200px;
        color: rgba(255,255,255,0.06);
        font-family: 'Playfair Display', serif;
        line-height: 1;
        pointer-events: none;
    }

    .tc-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: 52px;
        color: #f5ede3;
        margin: 0 0 16px 0;
        font-weight: 600;
        letter-spacing: -0.5px;
    }

    .tc-hero p {
        font-size: 17px;
        color: #c9d4c2;
        margin: 0;
        font-weight: 300;
        letter-spacing: 0.3px;
    }

    .tc-hero .badge {
        display: inline-block;
        background: rgba(255,255,255,0.15);
        color: #e8ddd2;
        font-size: 12px;
        letter-spacing: 2px;
        text-transform: uppercase;
        padding: 6px 16px;
        border-radius: 20px;
        margin-bottom: 20px;
        font-family: 'Lato', sans-serif;
        font-weight: 700;
    }

    /* ── LAYOUT ── */
    .tc-layout {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 30px;
        align-items: start;
    }

    /* ── SIDEBAR NAV ── */
    .tc-nav {
        position: sticky;
        top: 30px;
        background: #fff8f2;
        border-radius: 16px;
        padding: 30px 24px;
        border: 1px solid #ddd4c6;
    }

    .tc-nav h3 {
        font-family: 'Playfair Display', serif;
        font-size: 14px;
        color: #9a8c7e;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin: 0 0 20px 0;
        font-weight: 400;
    }

    .tc-nav ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .tc-nav ul li {
        margin-bottom: 4px;
    }

    .tc-nav ul li a {
        display: block;
        padding: 10px 14px;
        border-radius: 10px;
        color: #5f5448;
        text-decoration: none;
        font-size: 14px;
        font-weight: 400;
        transition: all 0.2s;
        line-height: 1.4;
    }

    .tc-nav ul li a:hover,
    .tc-nav ul li a.active {
        background: #eee4d8;
        color: #3d4e38;
        font-weight: 700;
    }

    .tc-nav .last-updated {
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #ddd4c6;
        font-size: 12px;
        color: #a89e94;
        line-height: 1.6;
    }

    /* ── MAIN CONTENT CARD ── */
    .tc-card {
        background: #fff8f2;
        border-radius: 20px;
        border: 1px solid #ddd4c6;
        overflow: hidden;
    }

    /* ── SECTION ── */
    .tc-section {
        padding: 48px 52px;
        border-bottom: 1px solid #ece4da;
        scroll-margin-top: 30px;
    }

    .tc-section:last-of-type {
        border-bottom: none;
    }

    .tc-section-header {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 24px;
    }

    .tc-section-num {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #607758;
        color: #fff;
        font-family: 'Playfair Display', serif;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-weight: 600;
    }

    .tc-section h2 {
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        color: #2e3a2b;
        margin: 0;
        font-weight: 600;
    }

    .tc-section p {
        font-size: 15.5px;
        color: #5a544e;
        line-height: 1.85;
        margin: 0 0 18px 0;
        font-weight: 300;
    }

    .tc-section p:last-of-type {
        margin-bottom: 0;
    }

    /* ── HIGHLIGHT BOX ── */
    .tc-highlight {
        background: #eee4d8;
        border-left: 4px solid #607758;
        border-radius: 0 10px 10px 0;
        padding: 18px 22px;
        margin: 20px 0;
        font-size: 15px;
        color: #4a5645;
        line-height: 1.7;
        font-style: italic;
        font-family: 'Playfair Display', serif;
    }

    /* ── FOOTER ACTIONS ── */
    .tc-footer {
        background: #f5ede3;
        border-top: 1px solid #ddd4c6;
        padding: 36px 52px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .tc-footer p {
        font-size: 14px;
        color: #9a8c7e;
        margin: 0;
        max-width: 380px;
        line-height: 1.5;
    }

    .tc-footer-btns {
        display: flex;
        gap: 14px;
        flex-shrink: 0;
    }

    .tc-btn {
        padding: 14px 36px;
        border-radius: 50px;
        font-size: 15px;
        font-weight: 700;
        font-family: 'Lato', sans-serif;
        cursor: pointer;
        transition: all 0.25s;
        border: 2px solid transparent;
        letter-spacing: 0.3px;
    }

    .tc-btn-decline {
        background: transparent;
        color: #607758;
        border-color: #607758;
    }

    .tc-btn-decline:hover {
        background: #607758;
        color: #fff;
    }

    .tc-btn-accept {
        background: #607758;
        color: #fff;
        border-color: #607758;
    }

    .tc-btn-accept:hover {
        background: #3d4e38;
        border-color: #3d4e38;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(96,119,88,0.35);
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 900px) {
        .tc-layout {
            grid-template-columns: 1fr;
        }
        .tc-nav {
            position: static;
        }
        .tc-section, .tc-footer {
            padding: 36px 28px;
        }
        .tc-hero {
            padding: 50px 32px;
        }
        .tc-hero h1 {
            font-size: 38px;
        }
        .tc-footer {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="tc-page">

    <!-- HERO -->
    <div class="tc-hero">
        <div class="badge">Legal</div>
        <h1>Terms &amp; Conditions</h1>
        <p>Please read these terms carefully before using Hudders Hub Market.</p>
    </div>

    <div class="tc-layout">

        <!-- SIDEBAR NAV -->
        <aside class="tc-nav">
            <h3>Contents</h3>
            <ul>
                <li><a href="#intro" class="active">1. Introduction</a></li>
                <li><a href="#use">2. Use of the Platform</a></li>
                <li><a href="#vendors">3. Vendors &amp; Products</a></li>
                <li><a href="#payments">4. Payments &amp; Orders</a></li>
                <li><a href="#privacy">5. Privacy</a></li>
                <li><a href="#liability">6. Liability</a></li>
                <li><a href="#changes">7. Changes to Terms</a></li>
            </ul>
            <div class="last-updated">
                Last updated<br>
                <strong>May 2026</strong>
            </div>
        </aside>

        <!-- MAIN CARD -->
        <div class="tc-card">

            <div class="tc-section" id="intro">
                <div class="tc-section-header">
                    <div class="tc-section-num">1</div>
                    <h2>Introduction</h2>
                </div>
                <p>Welcome to Hudders Hub Market. By accessing or using our platform, you agree to be bound by these Terms and Conditions. These terms apply to all visitors, users, vendors, and others who access or use the service.</p>
                <div class="tc-highlight">
                    "Hudders Hub Market is a community-first marketplace. We ask that all users engage with honesty, respect, and good faith."
                </div>
                <p>If you disagree with any part of these terms, you may not access the platform. We reserve the right to update these terms at any time, and continued use of the platform constitutes your acceptance of any changes.</p>
            </div>

            <div class="tc-section" id="use">
                <div class="tc-section-header">
                    <div class="tc-section-num">2</div>
                    <h2>Use of the Platform</h2>
                </div>
                <p>You agree to use Hudders Hub Market only for lawful purposes and in a way that does not infringe the rights of others. You must not misuse our platform by knowingly introducing viruses or other malicious material, attempting to gain unauthorised access, or transmitting unsolicited communications.</p>
                <p>You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account. Please notify us immediately of any unauthorised use.</p>
            </div>

            <div class="tc-section" id="vendors">
                <div class="tc-section-header">
                    <div class="tc-section-num">3</div>
                    <h2>Vendors &amp; Products</h2>
                </div>
                <p>Hudders Hub Market acts as a marketplace connecting buyers with independent vendors. We do not manufacture, store, or ship products directly. Each vendor is responsible for the accuracy of their product listings, pricing, and fulfilment of orders.</p>
                <p>We reserve the right to remove any listing or suspend any vendor account that violates our community standards, misrepresents products, or engages in fraudulent behaviour.</p>
            </div>

            <div class="tc-section" id="payments">
                <div class="tc-section-header">
                    <div class="tc-section-num">4</div>
                    <h2>Payments &amp; Orders</h2>
                </div>
                <p>All transactions are processed securely through our payment partners. By placing an order, you confirm that the payment information provided is accurate and that you are authorised to use the payment method.</p>
                <p>Refunds and returns are subject to the individual vendor's policy. Hudders Hub Market may mediate disputes at its discretion but does not guarantee refunds beyond what is required by applicable law.</p>
            </div>

            <div class="tc-section" id="privacy">
                <div class="tc-section-header">
                    <div class="tc-section-num">5</div>
                    <h2>Privacy</h2>
                </div>
                <p>Your use of Hudders Hub Market is also governed by our Privacy Policy, which is incorporated into these Terms by reference. We are committed to protecting your personal data in accordance with applicable data protection legislation.</p>
            </div>

            <div class="tc-section" id="liability">
                <div class="tc-section-header">
                    <div class="tc-section-num">6</div>
                    <h2>Liability</h2>
                </div>
                <p>Hudders Hub Market is provided on an "as is" basis. To the fullest extent permitted by law, we exclude all liability for loss or damage arising from your use of the platform, including indirect or consequential losses.</p>
            </div>

            <div class="tc-section" id="changes">
                <div class="tc-section-header">
                    <div class="tc-section-num">7</div>
                    <h2>Changes to Terms</h2>
                </div>
                <p>We may revise these Terms and Conditions at any time. We will notify registered users of significant changes via email or a prominent notice on the platform. Your continued use after any changes indicates your acceptance of the new terms.</p>
            </div>

            <!-- FOOTER ACTIONS -->
            <div class="tc-footer">
                <p>By clicking Accept, you confirm that you have read and agree to our Terms and Conditions.</p>
                <div class="tc-footer-btns">
                    <button class="tc-btn tc-btn-decline" onclick="window.location.href='index.php'">Decline</button>
                    <button class="tc-btn tc-btn-accept" onclick="window.location.href='index.php'">Accept</button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Highlight active nav item on scroll
    const sections = document.querySelectorAll('.tc-section');
    const navLinks = document.querySelectorAll('.tc-nav ul li a');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                navLinks.forEach(link => link.classList.remove('active'));
                const id = entry.target.getAttribute('id');
                const active = document.querySelector(`.tc-nav a[href="#${id}"]`);
                if (active) active.classList.add('active');
            }
        });
    }, { threshold: 0.4 });

    sections.forEach(s => observer.observe(s));
</script>

<?php include 'include/footer.php'; ?>