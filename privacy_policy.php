<?php
$pageTitle = 'Privacy Policy - Hudders Hub';
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
    .pp-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 60px 30px 100px;
    }

    /* ── HERO BANNER ── */
    .pp-hero {
        background-color: #607758;
        border-radius: 20px;
        padding: 70px 60px;
        margin-bottom: 60px;
        position: relative;
        overflow: hidden;
    }

    .pp-hero::before {
        content: '🔒';
        position: absolute;
        right: 60px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 160px;
        opacity: 0.06;
        line-height: 1;
        pointer-events: none;
    }

    .pp-hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: 52px;
        color: #f5ede3;
        margin: 0 0 16px 0;
        font-weight: 600;
        letter-spacing: -0.5px;
    }

    .pp-hero p {
        font-size: 17px;
        color: #c9d4c2;
        margin: 0;
        font-weight: 300;
        letter-spacing: 0.3px;
    }

    .pp-hero .badge {
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
    .pp-layout {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 30px;
        align-items: start;
    }

    /* ── SIDEBAR NAV ── */
    .pp-nav {
        position: sticky;
        top: 30px;
        background: #fff8f2;
        border-radius: 16px;
        padding: 30px 24px;
        border: 1px solid #ddd4c6;
    }

    .pp-nav h3 {
        font-family: 'Playfair Display', serif;
        font-size: 14px;
        color: #9a8c7e;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin: 0 0 20px 0;
        font-weight: 400;
    }

    .pp-nav ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .pp-nav ul li {
        margin-bottom: 4px;
    }

    .pp-nav ul li a {
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

    .pp-nav ul li a:hover,
    .pp-nav ul li a.active {
        background: #eee4d8;
        color: #3d4e38;
        font-weight: 700;
    }

    .pp-nav .last-updated {
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #ddd4c6;
        font-size: 12px;
        color: #a89e94;
        line-height: 1.6;
    }

    /* ── MAIN CONTENT CARD ── */
    .pp-card {
        background: #fff8f2;
        border-radius: 20px;
        border: 1px solid #ddd4c6;
        overflow: hidden;
    }

    /* ── SECTION ── */
    .pp-section {
        padding: 48px 52px;
        border-bottom: 1px solid #ece4da;
        scroll-margin-top: 30px;
    }

    .pp-section:last-of-type {
        border-bottom: none;
    }

    .pp-section-header {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 24px;
    }

    .pp-section-num {
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

    .pp-section h2 {
        font-family: 'Playfair Display', serif;
        font-size: 26px;
        color: #2e3a2b;
        margin: 0;
        font-weight: 600;
    }

    .pp-section p {
        font-size: 15.5px;
        color: #5a544e;
        line-height: 1.85;
        margin: 0 0 18px 0;
        font-weight: 300;
    }

    .pp-section p:last-of-type {
        margin-bottom: 0;
    }

    .pp-section ul {
        list-style: none;
        margin: 0 0 18px 0;
        padding: 0;
    }

    .pp-section ul li {
        font-size: 15px;
        color: #5a544e;
        font-weight: 300;
        padding: 6px 0 6px 22px;
        position: relative;
        line-height: 1.7;
    }

    .pp-section ul li::before {
        content: '✦';
        position: absolute;
        left: 0;
        color: #607758;
        font-size: 9px;
        top: 11px;
    }

    .pp-section ul li strong {
        color: #3d4e38;
        font-weight: 700;
    }

    /* ── HIGHLIGHT BOX ── */
    .pp-highlight {
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

    /* ── CONTACT BOX (inside section) ── */
    .pp-contact-box {
        background: #607758;
        border-radius: 14px;
        padding: 30px 36px;
        margin-top: 24px;
        color: #fff;
    }

    .pp-contact-box h3 {
        font-family: 'Playfair Display', serif;
        font-size: 20px;
        margin: 0 0 14px 0;
        font-weight: 600;
    }

    .pp-contact-box p {
        font-size: 15px;
        color: rgba(255,255,255,0.85);
        margin: 0 0 8px 0;
        font-weight: 300;
    }

    .pp-contact-box p:last-of-type {
        margin-bottom: 0;
    }

    .pp-contact-box a {
        color: #c8daa0;
        text-decoration: none;
    }

    .pp-contact-box a:hover {
        text-decoration: underline;
    }

    /* ── FOOTER ACTIONS ── */
    .pp-footer {
        background: #f5ede3;
        border-top: 1px solid #ddd4c6;
        padding: 36px 52px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .pp-footer p {
        font-size: 14px;
        color: #9a8c7e;
        margin: 0;
        max-width: 400px;
        line-height: 1.5;
    }

    .pp-btn {
        padding: 14px 36px;
        border-radius: 50px;
        font-size: 15px;
        font-weight: 700;
        font-family: 'Lato', sans-serif;
        cursor: pointer;
        transition: all 0.25s;
        border: 2px solid #607758;
        text-decoration: none;
        display: inline-block;
        background: #607758;
        color: #fff;
        letter-spacing: 0.3px;
    }

    .pp-btn:hover {
        background: #3d4e38;
        border-color: #3d4e38;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(96,119,88,0.35);
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 900px) {
        .pp-layout {
            grid-template-columns: 1fr;
        }
        .pp-nav {
            position: static;
        }
        .pp-section, .pp-footer {
            padding: 36px 28px;
        }
        .pp-hero {
            padding: 50px 32px;
        }
        .pp-hero h1 {
            font-size: 38px;
        }
        .pp-footer {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="pp-page">

    <!-- HERO -->
    <div class="pp-hero">
        <div class="badge">Legal</div>
        <h1>Privacy Policy</h1>
        <p>We respect your privacy and are committed to protecting your personal information. Last updated: May 2026.</p>
    </div>

    <div class="pp-layout">

        <!-- SIDEBAR NAV -->
        <aside class="pp-nav">
            <h3>Contents</h3>
            <ul>
                <li><a href="#collect" class="active">1. Information We Collect</a></li>
                <li><a href="#use">2. How We Use Your Data</a></li>
                <li><a href="#sharing">3. Sharing Your Data</a></li>
                <li><a href="#cookies">4. Cookies &amp; Tracking</a></li>
                <li><a href="#security">5. Data Security</a></li>
                <li><a href="#rights">6. Your Rights &amp; Choices</a></li>
                <li><a href="#retention">7. Data Retention</a></li>
                <li><a href="#thirdparty">8. Third-Party Links</a></li>
                <li><a href="#children">9. Children's Privacy</a></li>
                <li><a href="#changes">10. Changes to Policy</a></li>
                <li><a href="#contact">11. Contact Us</a></li>
            </ul>
            <div class="last-updated">
                Last updated<br>
                <strong>May 2026</strong>
            </div>
        </aside>

        <!-- MAIN CARD -->
        <div class="pp-card">

            <!-- INTRO -->
            <div class="pp-section" id="intro" style="padding-bottom: 32px; border-bottom: 1px solid #ece4da;">
                <p>Welcome to <strong>Hudders Hub</strong> — your local market, now online. Based in Cleckhuddersfax, London, we connect you with the finest independent traders: grocers, butchers, fishmongers, bakeries, and delis, all in one basket. This Privacy Policy explains how we collect, use, and protect your personal information when you use our website and services.</p>
                <div class="pp-highlight">
                    "By using Hudders Hub, you agree to the practices described in this policy. Please read it carefully before registering or placing an order."
                </div>
            </div>

            <!-- 1. Information We Collect -->
            <div class="pp-section" id="collect">
                <div class="pp-section-header">
                    <div class="pp-section-num">1</div>
                    <h2>Information We Collect</h2>
                </div>
                <p>We collect information you provide directly to us when you register, shop, or contact us, as well as data gathered automatically when you use our platform.</p>
                <p><strong style="color:#3d4e38;">Information you provide:</strong></p>
                <ul>
                    <li>Name, email address, phone number, and date of birth when you register</li>
                    <li>Username and password for your account</li>
                    <li>Shop name and business details (Trader accounts only)</li>
                    <li>Billing and shipping addresses for order processing</li>
                    <li>Payment information processed securely via PayPal</li>
                    <li>Messages and enquiries submitted via our Contact Us form</li>
                    <li>Product reviews and ratings you leave on listings</li>
                </ul>
                <p><strong style="color:#3d4e38;">Information collected automatically:</strong></p>
                <ul>
                    <li>IP address and approximate location</li>
                    <li>Browser type and device information</li>
                    <li>Pages visited, products viewed, and time spent on site</li>
                    <li>Shopping cart and wishlist activity</li>
                    <li>Search queries entered on our platform</li>
                </ul>
            </div>

            <!-- 2. How We Use Your Data -->
            <div class="pp-section" id="use">
                <div class="pp-section-header">
                    <div class="pp-section-num">2</div>
                    <h2>How We Use Your Data</h2>
                </div>
                <p>We use the information we collect for the following purposes:</p>
                <ul>
                    <li>Creating and managing your customer or trader account</li>
                    <li>Processing orders, arranging collection slots, and generating invoices</li>
                    <li>Communicating with you about your orders, enquiries, and account activity</li>
                    <li>Personalising your shopping experience and product recommendations</li>
                    <li>Displaying your reviews and ratings on product pages</li>
                    <li>Sending promotional emails and offers (with your consent)</li>
                    <li>Detecting and preventing fraudulent or unauthorised activity</li>
                    <li>Generating anonymised analytics to improve our platform</li>
                    <li>Complying with applicable legal obligations</li>
                </ul>
                <div class="pp-highlight">
                    "We will never sell your personal data to third parties for their own marketing purposes."
                </div>
            </div>

            <!-- 3. Sharing Your Data -->
            <div class="pp-section" id="sharing">
                <div class="pp-section-header">
                    <div class="pp-section-num">3</div>
                    <h2>Sharing Your Data</h2>
                </div>
                <p>We share your information only in the following limited circumstances:</p>
                <ul>
                    <li><strong>Traders on our platform:</strong> Your name, address, and order details are shared with the relevant trader(s) to fulfil your order.</li>
                    <li><strong>Payment processors:</strong> Payment information is handled by PayPal under their own privacy policy. We do not store full card details.</li>
                    <li><strong>Service providers:</strong> Trusted third-party providers for hosting, analytics, and email services who process data strictly on our behalf.</li>
                    <li><strong>Legal requirements:</strong> We may disclose information if required by law, court order, or regulatory authority.</li>
                    <li><strong>Business transfers:</strong> In the event of a merger or acquisition, your data may be transferred as part of that transaction.</li>
                </ul>
            </div>

            <!-- 4. Cookies & Tracking -->
            <div class="pp-section" id="cookies">
                <div class="pp-section-header">
                    <div class="pp-section-num">4</div>
                    <h2>Cookies &amp; Tracking</h2>
                </div>
                <p>Hudders Hub uses cookies and similar technologies to enhance your experience on our site.</p>
                <ul>
                    <li><strong>Essential cookies:</strong> Required for login sessions, cart functionality, and security (including CSRF protection).</li>
                    <li><strong>Preference cookies:</strong> Remember your settings such as sort order, filters, and collection slot choices.</li>
                    <li><strong>Analytics cookies:</strong> Help us understand how visitors use our site (data is anonymised).</li>
                    <li><strong>Google Sign-In:</strong> If you use "Sign in with Google," Google may set additional cookies governed by their own policy.</li>
                </ul>
                <p>You can control cookie settings through your browser preferences. Disabling essential cookies may affect core site functionality such as login and cart.</p>
            </div>

            <!-- 5. Data Security -->
            <div class="pp-section" id="security">
                <div class="pp-section-header">
                    <div class="pp-section-num">5</div>
                    <h2>Data Security</h2>
                </div>
                <p>We take the security of your personal information seriously and implement appropriate technical and organisational measures, including:</p>
                <ul>
                    <li>Encrypted passwords — we never store passwords in plain text</li>
                    <li>HTTPS encryption for all data in transit</li>
                    <li>CSRF token protection on all forms</li>
                    <li>Restricted access to personal data within our admin team</li>
                    <li>Security monitoring and alerts for unusual or unrecognised login activity</li>
                </ul>
                <div class="pp-highlight">
                    "While we strive to protect your information, no method of internet transmission is 100% secure. Please use a strong, unique password for your Hudders Hub account."
                </div>
            </div>

            <!-- 6. Your Rights & Choices -->
            <div class="pp-section" id="rights">
                <div class="pp-section-header">
                    <div class="pp-section-num">6</div>
                    <h2>Your Rights &amp; Choices</h2>
                </div>
                <p>Depending on your location, you may have the following rights regarding your personal data:</p>
                <ul>
                    <li><strong>Access:</strong> Request a copy of the personal information we hold about you.</li>
                    <li><strong>Correction:</strong> Ask us to correct inaccurate or incomplete information in your account.</li>
                    <li><strong>Deletion:</strong> Request that we delete your account and associated personal data.</li>
                    <li><strong>Portability:</strong> Receive your data in a structured, machine-readable format.</li>
                    <li><strong>Objection:</strong> Object to the processing of your data for marketing purposes.</li>
                    <li><strong>Withdraw consent:</strong> Unsubscribe from marketing emails at any time via the link in any email we send.</li>
                </ul>
                <p>To exercise any of these rights, please contact us at <strong>huddershub@gmail.com</strong>. We aim to respond within 30 days.</p>
            </div>

            <!-- 7. Data Retention -->
            <div class="pp-section" id="retention">
                <div class="pp-section-header">
                    <div class="pp-section-num">7</div>
                    <h2>Data Retention</h2>
                </div>
                <p>We retain your personal information for as long as your account is active or as needed to provide our services. Specifically:</p>
                <ul>
                    <li>Account data is kept for the duration of your account plus 2 years after closure</li>
                    <li>Order and invoice records are retained for 7 years for legal and tax compliance</li>
                    <li>Product reviews remain visible unless you request their deletion</li>
                    <li>Marketing preferences are updated immediately upon opt-out</li>
                </ul>
            </div>

            <!-- 8. Third-Party Links -->
            <div class="pp-section" id="thirdparty">
                <div class="pp-section-header">
                    <div class="pp-section-num">8</div>
                    <h2>Third-Party Links</h2>
                </div>
                <p>Our website may contain links to third-party websites, including PayPal, Google Maps, Facebook, Telegram, and Instagram. We are not responsible for the privacy practices of these external sites. We encourage you to review their privacy policies before providing any personal information.</p>
            </div>

            <!-- 9. Children's Privacy -->
            <div class="pp-section" id="children">
                <div class="pp-section-header">
                    <div class="pp-section-num">9</div>
                    <h2>Children's Privacy</h2>
                </div>
                <p>Hudders Hub is not intended for children under the age of 13. We do not knowingly collect personal information from children. If you believe a child has provided us with personal data without parental consent, please contact us immediately and we will promptly delete it.</p>
            </div>

            <!-- 10. Changes to Policy -->
            <div class="pp-section" id="changes">
                <div class="pp-section-header">
                    <div class="pp-section-num">10</div>
                    <h2>Changes to This Policy</h2>
                </div>
                <p>We may update this Privacy Policy from time to time to reflect changes in our practices or legal requirements. When we make significant changes, we will:</p>
                <ul>
                    <li>Update the "Last updated" date at the top of this page</li>
                    <li>Notify registered users via email</li>
                    <li>Display a notice on our website homepage</li>
                </ul>
                <p>Your continued use of Hudders Hub after changes are posted constitutes your acceptance of the updated policy.</p>
            </div>

            <!-- 11. Contact Us -->
            <div class="pp-section" id="contact">
                <div class="pp-section-header">
                    <div class="pp-section-num">11</div>
                    <h2>Contact Us</h2>
                </div>
                <p>If you have any questions, concerns, or requests relating to this Privacy Policy or your personal data, please get in touch:</p>
                <div class="pp-contact-box">
                    <h3>Hudders Hub — Privacy Team</h3>
                    <p>📧 <a href="mailto:huddershub@gmail.com">huddershub@gmail.com</a></p>
                    <p>📞 +111 3489202000</p>
                    <p>📍 Cleckhuddersfax, London, United Kingdom</p>
                    <p style="margin-top: 12px; font-size: 13px; opacity: 0.75;">We aim to respond to all privacy enquiries within 5 business days.</p>
                </div>
            </div>

            <!-- FOOTER ACTIONS -->
            <div class="pp-footer">
                <p>Questions about your data? Our team is here to help — reach us at huddershub@gmail.com.</p>
                <a href="index.php" class="pp-btn">Back to Home</a>
            </div>

        </div><!-- /.pp-card -->
    </div><!-- /.pp-layout -->
</div><!-- /.pp-page -->

<script>
    // Highlight active nav item on scroll
    const sections = document.querySelectorAll('.pp-section[id]');
    const navLinks = document.querySelectorAll('.pp-nav ul li a');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                navLinks.forEach(link => link.classList.remove('active'));
                const id = entry.target.getAttribute('id');
                const active = document.querySelector(`.pp-nav a[href="#${id}"]`);
                if (active) active.classList.add('active');
            }
        });
    }, { threshold: 0.4 });

    sections.forEach(s => observer.observe(s));
</script>

<?php include 'include/footer.php'; ?>