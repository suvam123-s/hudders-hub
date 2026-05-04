<?php
$pageTitle = 'About Us - Hudders Hub Market';
include 'include/header.php';
?>

<style>
    /* About Us Page Specific Styles */
    body {
        background-color: #eee4d8;
        overflow-x: hidden;
    }

    /* Hero Section */
    .about-hero {
        position: relative;
        height: 830px;
        background-image: url('assets/images/about-city.jpg');
        background-size: cover;
        background-position: center;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding-top: 200px;
    }

    .about-hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(96, 119, 88, 0.68);
    }

    .about-hero-title {
        position: relative;
        z-index: 2;
        color: white;
        font-family: Georgia, 'Times New Roman', Times, serif;
        font-size: 78px;
        font-style: italic;
        text-shadow: 2px 2px 8px rgba(0,0,0,0.2);
    }
    
    .about-hero-title span {
        font-size: 110px;
        line-height: 0.7;
        vertical-align: middle;
    }

    .flower-vine {
        position: absolute;
        right: 0;
        top: 50px;
        width: 260px;
        z-index: 5;
        pointer-events: none;
    }

    .arch-shape {
        position: absolute;
        bottom: -405px;
        left: 50%;
        transform: translateX(-50%);
        width: 810px;
        height: 810px;
        background-color: #eee4d8;
        border-radius: 50%;
        z-index: 2;
    }

    /* Main Content */
    .about-main-content {
        background-color: #eee4d8;
        padding-top: 290px;
        padding-bottom: 150px;
        position: relative;
        z-index: 3;
    }

    .about-section-title {
        text-align: center;
        font-family: Georgia, 'Times New Roman', Times, serif;
        font-size: 44px;
        color: #000;
        margin-bottom: 100px;
    }

    .history-layout {
        max-width: 1500px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 0 40px;
        gap: 40px;
    }

    .left-block {
        width: 490px;
        height: 530px;
        background-color: #9fa895;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        flex-shrink: 0;
    }

    .center-text {
        width: 600px;
        font-size: 18px;
        line-height: 1.6;
        color: #6f7470;
        flex-shrink: 1;
    }

    .center-text p {
        margin-bottom: 20px;
    }

    .right-block {
        width: 460px;
        height: 450px;
        background-color: #9fa895;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-top: 200px;
        flex-shrink: 0;
    }

    /* Responsive Design */
    @media (max-width: 1400px) {
        .history-layout {
            flex-wrap: wrap;
            justify-content: center;
        }
        .right-block {
            margin-top: 40px;
        }
        .center-text {
            width: 100%;
            order: -1;
            margin-bottom: 40px;
            text-align: center;
        }
    }

    @media (max-width: 1024px) {
        .about-hero-title {
            font-size: 60px;
        }
        .arch-shape {
            width: 600px;
            height: 600px;
            bottom: -300px;
        }
        .about-main-content {
            padding-top: 200px;
        }
        .left-block, .right-block {
            width: 100%;
            max-width: 490px;
        }
    }

    @media (max-width: 768px) {
        .about-hero {
            height: 500px;
            padding-top: 100px;
        }
        .about-hero-title {
            font-size: 40px;
        }
        .flower-vine {
            width: 150px;
        }
        .arch-shape {
            width: 400px;
            height: 400px;
            bottom: -200px;
        }
        .about-main-content {
            padding-top: 100px;
        }
        .history-layout {
            padding: 0 15px;
        }
    }
</style>

    <!-- Hero Section -->
    <section class="about-hero">
        <div class="about-hero-overlay"></div>
        <img src="assets/images/flower-vine.png" alt="Decorative Vine" class="flower-vine" onerror="this.style.display='none'">
        <h1 class="about-hero-title"><span>A</span>bout Us</h1>
        <div class="arch-shape"></div>
    </section>

    <!-- Main Content -->
    <main class="about-main-content">
        <h2 class="about-section-title">Our History</h2>
        
        <div class="history-layout">
            <div class="left-block"></div>
            
            <div class="center-text">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed malesuada nulla nec augue rhoncus, eget ullamcorper nulla ultrices. Fusce vulputate scelerisque est, ac venenatis nisi facilisis id. Vivamus vel massa eget velit sagittis blandit. Nullam condimentum ipsum nec purus finibus, ac mattis mauris malesuada. Fusce dignissim diam ut ligula tincidunt euismod. Proin ut mauris malesuada, placerat nulla sed, faucibus augue. Donec eget risus tellus. Phasellus euismod dui et lacus mollis ultricies. Mauris fringilla mauris libero, id pretium quam ultrices nec. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;</p>
                <p>Allergy Information : Proin ut mauris malesuada'uere cubilia Curae; llergy Information : Proin ut mauris dd malesuada' hjgklmnuhjnkhjbvdfjkvnfdjvnjnfdvjnfdfv, placerat nulla sed, faucibus augue.dgdavdkljnvjdfv, placerat nulla sed, faucibus augue.uere cubilia Curae; Allergy Information : Proin ut mauris malesuada'fvfvf, placerat nulla sed, faucibus augue.</p>
                <p>jkdhcvjdfmkbvnjfvfjhaduijcbdfjsbvioejncdsjkvdvkndf</p>
                <p>Allergy Information : Proin ut mauris malesuada'uere cubilia Curae; llergy Information : Proin ut mauris dd malesuada' hjgklmnuhjnkhjbvdfjkvnfdjvnjnfdvjnfdfv, placerat nulla sed, faucibus augue.dgdavdkljnvjdfv, placerat nulla sed, faucibus augue.uere cubilia Curae; Allergy Information : Proin ut mauris malesuada'fvfvf, placerat nulla sed, faucibus augue.</p>
            </div>
            
            <div class="right-block"></div>
        </div>
    </main>

<?php include 'include/footer.php'; ?>
