<?php

/** @var yii\web\View $this */

use app\components\Helper;

$this->title = 'Terms & Conditions - Assignly';
?>

<!-- Terms & Conditions Hero Section -->
<section class="terms-hero py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="hero-title">Terms & Conditions</h1>
                <p class="hero-subtitle">Rules and guidelines for using our platform</p>
            </div>
        </div>
    </div>
</section>

<!-- Terms & Conditions Content Section -->
<section class="terms-content py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="terms-policy-content">
                    
                    <!-- Acceptance -->
                    <div class="terms-section mb-4">
                        <h2>Acceptance of Terms</h2>
                        <p>By using Assignly, you agree to these terms and conditions. If you don't agree, please don't use our services.</p>
                    </div>

                    <!-- User Responsibilities -->
                    <div class="terms-section mb-4">
                        <h2>User Responsibilities</h2>
                        <p>You must provide accurate information, maintain account security, and use the platform responsibly. No harassment, fraud, or illegal activities are allowed.</p>
                    </div>

                    <!-- Service Description -->
                    <div class="terms-section mb-4">
                        <h2>Our Services</h2>
                        <p>We connect students with qualified tutors for educational support. We facilitate communication and payments but are not responsible for the quality of tutoring sessions.</p>
                    </div>

                    <!-- Payment Terms -->
                    <div class="terms-section mb-4">
                        <h2>Payment & Fees</h2>
                        <p>Payments are not processed through our software. You need to agree on a suitable payment medium directly with your tutor. The in-app payment options are only for tutors to buy coins and memberships.</p>
                    </div>

                    <!-- Contact -->
                    <div class="terms-section">
                        <h2>Contact Us</h2>
                        <div class="contact-info">
                            <p><strong>Email:</strong> legal@assignly.com</p>
                            <p><strong>Phone:</strong> 1-800-EXPERT-1</p>
                        </div>
                        <p class="last-updated"><strong>Last Updated:</strong> <?= date('F j, Y') ?></p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Terms & Conditions Hero Section */
    .terms-hero {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6c63ff 100%);
        color: white;
    }

    .hero-title {
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .hero-subtitle {
        font-size: clamp(1.1rem, 2.5vw, 1.3rem);
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
        color: white;
    }

    /* Terms & Conditions Content */
    .terms-content {
        background: #f8f9fa;
    }

    .terms-policy-content {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        line-height: 1.6;
    }

    .terms-section h2 {
        color: var(--primary-color);
        font-size: clamp(1.6rem, 3vw, 2rem);
        font-weight: 700;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-color);
    }

    .terms-section p {
        color: var(--text-light);
        font-size: clamp(1rem, 2vw, 1.1rem);
        margin-bottom: 0.5rem;
    }

    .contact-info {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 12px;
        margin: 1rem 0;
        border-left: 4px solid var(--primary-color);
    }

    .contact-info p {
        margin-bottom: 0.5rem;
    }

    .last-updated {
        text-align: center;
        font-style: italic;
        color: var(--text-muted);
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .terms-policy-content {
            padding: 2rem 1.5rem;
        }

        .terms-section h2 {
            font-size: 1.5rem;
        }

        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 576px) {
        .terms-policy-content {
            padding: 1.5rem 1rem;
        }

        .terms-section h2 {
            font-size: 1.4rem;
        }
    }
</style>
