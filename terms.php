<?php
$pageTitle = 'Terms and Conditions - Hudders Hub';
include 'include/header.php';
?>

<style>
    /* Terms Page Specific Styles */
    body {
        background-color: #eee4d8;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    /* Container for Main Content */
    .terms-container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 50px 20px;
        flex-grow: 1;
    }

    /* Hero / Header Section Box */
    .terms-hero-box {
        background-color: #a5ad9a;
        padding: 60px 50px;
        margin-bottom: 50px;
        border-radius: 2px;
    }

    .terms-hero-box h1 {
        font-family: Georgia, 'Times New Roman', Times, serif;
        font-size: 48px;
        color: #1f2a1f;
        margin-bottom: 20px;
    }

    .terms-hero-box p {
        font-size: 22px;
        color: #505a50;
        max-width: 600px;
        line-height: 1.4;
    }

    /* Two Column Layout */
    .terms-content-layout {
        display: flex;
        gap: 40px;
        margin-bottom: 50px;
        align-items: flex-start;
    }

    /* Left Column */
    .terms-sidebar {
        width: 300px;
        background-color: #a5ad9a;
        padding: 35px;
        border-radius: 2px;
        text-align: center;
        flex-shrink: 0;
    }

    .terms-sidebar h2 {
        font-family: Georgia, 'Times New Roman', Times, serif;
        font-size: 24px;
        color: #1f2a1f;
    }

    /* Right Column */
    .terms-main-content {
        flex-grow: 1;
        background-color: #a5ad9a;
        padding: 45px;
        border-radius: 6px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .terms-main-content h2 {
        font-family: Georgia, 'Times New Roman', Times, serif;
        font-size: 30px;
        color: #1f2a1f;
        margin-bottom: 30px;
    }

    .terms-main-content p {
        font-size: 16px;
        color: #1f2a1f;
        line-height: 1.6;
        margin-bottom: 25px;
    }

    /* Buttons Bottom */
    .terms-action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 20px;
        margin-top: 50px;
    }

    .terms-action-buttons button {
        padding: 14px 45px;
        border-radius: 30px;
        font-size: 18px;
        font-weight: bold;
        font-family: Georgia, 'Times New Roman', Times, serif;
        cursor: pointer;
        transition: all 0.3s;
        border: 1px solid #1f2a1f;
    }

    .terms-btn-decline {
        background-color: #ded4c2;
        color: #1f2a1f;
    }
    
    .terms-btn-decline:hover {
        background-color: #c2b6a3;
    }

    .terms-btn-accept {
        background-color: #7f8c74;
        color: white;
        border: 1px solid #7f8c74 !important;
    }

    .terms-btn-accept:hover {
        background-color: #606b57;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .terms-content-layout {
            flex-direction: column;
        }
        .terms-sidebar {
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .terms-hero-box {
            padding: 40px 30px;
        }
        .terms-hero-box h1 {
            font-size: 36px;
        }
    }
</style>

    <!-- Main Container -->
    <div class="terms-container">
        <!-- Hero / Header Box -->
        <div class="terms-hero-box">
            <h1>Terms and Conditions</h1>
            <p>Read our terms below to learn more about your rights and responsibilities</p>
        </div>

        <!-- Content Layout -->
        <div class="terms-content-layout">
            <!-- Left Sidebar -->
            <div class="terms-sidebar">
                <h2>1. Introduction</h2>
            </div>

            <!-- Right Main Content -->
            <div class="terms-main-content">
                <h2>Introduction</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                
                <div class="terms-action-buttons">
                    <button class="terms-btn-decline" onclick="window.location.href='index.php'">Decline</button>
                    <button class="terms-btn-accept" onclick="window.location.href='index.php'">Accept</button>
                </div>
            </div>
        </div>
    </div>

<?php include 'include/footer.php'; ?>
