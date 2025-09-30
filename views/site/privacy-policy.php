<?php

/** @var yii\web\View $this */

use app\components\Helper;

$this->title = 'Privacy Policy - Assignly';
?>

<!-- Privacy Policy Hero Section -->
<section class="privacy-hero py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="hero-title">Privacy Policy</h1>
                <p class="hero-subtitle">How we protect your information</p>
            </div>
        </div>
    </div>
</section>

<!-- Privacy Policy Content Section -->
<section class="privacy-content py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="privacy-policy-content">
                    
                    <!-- What We Collect -->
                    <div class="policy-section mb-4">
                        <h2>What We Collect</h2>
                        <p>We collect your name, email, phone number, educational background, and payment information to provide our tutoring services.</p>
                    </div>

                    <!-- How We Use It -->
                    <div class="policy-section mb-4">
                        <h2>How We Use It</h2>
                        <p>Your information is used to match you with tutors, process payments, and improve our platform. We never sell your data to third parties.</p>
                    </div>

                    <!-- Security -->
                    <div class="policy-section mb-4">
                        <h2>Security</h2>
                        <p>We use encryption and secure systems to protect your personal information. Your data is stored safely and accessed only when necessary.</p>
                    </div>

                    <!-- Your Rights -->
                    <div class="policy-section mb-4">
                        <h2>Your Rights</h2>
                        <p>You can access, correct, or delete your information anytime. Contact us if you have questions about your data.</p>
                    </div>

                    <!-- Contact -->
                    <div class="policy-section">
                        <h2>Contact Us</h2>
                        <div class="contact-info">
                            <p><strong>Email:</strong> privacy@assignly.com</p>
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
    /* Privacy Policy Hero Section */
    .privacy-hero {
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

    /* Privacy Policy Content */
    .privacy-content {
        background: #f8f9fa;
    }

    .privacy-policy-content {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        line-height: 1.6;
    }

    .policy-section h2 {
        color: var(--primary-color);
        font-size: clamp(1.6rem, 3vw, 2rem);
        font-weight: 700;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-color);
    }

    .policy-section p {
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
        .privacy-policy-content {
            padding: 2rem 1.5rem;
        }

        .policy-section h2 {
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
        .privacy-policy-content {
            padding: 1.5rem 1rem;
        }

        .policy-section h2 {
            font-size: 1.4rem;
        }
    }
</style>
