<?php
$pageTitle = 'About Us - Hudders Hub Market';
include 'include/header.php';
?>

<style>
    body {
        background-color: #eee4d8;
        overflow-x: hidden;
        margin: 0;
        padding: 0;
    }

    /* ─── HERO SECTION ─── */
    .about-hero {
        position: relative;
        height: 600px;
        background-image: url('/hudders-hub/assets/css/image/hero.jpg');
        background-size: cover;
        background-position: center;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .about-hero-overlay {
        position: absolute;
        inset: 0;
        background: rgba(96, 119, 88, 0.60);
        z-index: 1;
    }

    .about-hero-title {
        position: relative;
        z-index: 10;
        color: #fff;
        font-size: 72px;
        font-family: Georgia, serif;
        font-style: italic;
        text-shadow: 2px 2px 12px rgba(0,0,0,0.25);
        margin: 0;
    }

    /* ── Decorative circle that rises from the hero bottom ── */
    .hero-circle {
        position: absolute;
        bottom: -220px;
        left: 50%;
        transform: translateX(-50%);
        width: 480px;
        height: 480px;
        border-radius: 50%;
        background-color: #eee4d8;
        z-index: 2;
    }

    /* ─── MAIN CONTENT ─── */
    .about-main-content {
        position: relative;
        padding: 260px 60px 120px;
    }

    /* ── Section title ── */
    .about-section-title {
        text-align: center;
        font-size: 40px;
        margin-bottom: 70px;
        font-family: Georgia, serif;
        color: #4f5c4d;
    }

    /* ─── HISTORY LAYOUT ─── */
    .history-layout {
        max-width: 1300px;
        margin: 0 auto;
        display: flex;
        gap: 60px;
        align-items: flex-start;
        justify-content: center;
    }

    /* ── Left image block ── */
    .left-block {
        flex-shrink: 0;
        width: 380px;
        height: 460px;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0,0,0,0.10);
    }

    .left-block img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* ── Center text ── */
    .center-text {
        flex: 1;
        max-width: 560px;
        font-size: 17px;
        line-height: 1.85;
        color: #5f645f;
        font-family: Georgia, serif;
    }

    .center-text p {
        margin-bottom: 22px;
    }

    /* ── Right image block – offset down ── */
    .right-block {
        flex-shrink: 0;
        width: 340px;
        height: 400px;
        margin-top: 140px;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0,0,0,0.10);
    }

    .right-block img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 1200px) {
        .history-layout {
            flex-direction: column;
            align-items: center;
        }
        .right-block { margin-top: 0; }
        .center-text { max-width: 100%; }
    }

    @media (max-width: 768px) {
        .about-hero       { height: 420px; }
        .about-hero-title { font-size: 46px; }
        .hero-circle      { width: 340px; height: 340px; bottom: -110px; }

        .left-block,
        .right-block { width: 100%; height: auto; min-height: 280px; }

        .about-main-content { padding: 160px 20px 80px; }
        .center-text { font-size: 15px; }
    }
</style>

<!-- ═══ HERO ═══ -->
<section class="about-hero">

    <div class="about-hero-overlay"></div>

    <h1 class="about-hero-title">About Us</h1>

    <!-- Decorative semi-circle rising from bottom -->
    <div class="hero-circle"></div>

</section>

<!-- ═══ MAIN CONTENT ═══ -->
<main class="about-main-content">

    <h2 class="about-section-title">Our History</h2>

    <div class="history-layout">

        <!-- LEFT IMAGE -->
        <div class="left-block">
            <img
                src="/hudders-hub/assets/css/image/artisan.jpg"
                alt="Hudders Hub Market artisan stall"
                onerror="this.src='https://via.placeholder.com/380x460/8fa888/ffffff?text=Market+Stall';"
            >
        </div>

        <!-- CENTER TEXT -->
        <div class="center-text">
            <p>
                Hudders Hub Market was created with a vision to bring together
                quality products, trusted vendors, and a welcoming shopping
                experience all in one place.
            </p>
            <p>
                Inspired by the vibrant community spirit of Huddersfield,
                our market connects people with fresh products.
            </p>
            <p>
                We believe shopping should feel warm, enjoyable, and meaningful.
                That is why we carefully choose vendors who value quality,
                creativity, and customer satisfaction.
            </p>
            <p>
                At Hudders Hub Market, we continue to grow as a modern marketplace
                while keeping the friendly and authentic atmosphere of a
                traditional local market.
            </p>
        </div>

        <!-- RIGHT IMAGE (offset downward) -->
        <div class="right-block">
            <img
                src="/hudders-hub/assets/css/image/basket.jpg"
                alt="Market lifestyle"
                onerror="this.src='https://via.placeholder.com/340x400/8fa888/ffffff?text=Market+Goods';"
            >
        </div>

    </div>

</main>

<?php include 'include/footer.php'; ?>
