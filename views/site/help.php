<?php

/** @var yii\web\View $this */

use app\components\Helper;

$this->title = 'Help Center - Assignly';
?>

<!-- Help Center Hero Section -->
<section class="help-hero py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="hero-title">Help Center</h1>
                <p class="hero-subtitle">Find answers, get support, and learn how to make the most of Assignly platform.</p>
            </div>
        </div>
    </div>
</section>

<!-- Popular Topics Section -->
<section class="popular-topics py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="section-title">Popular Topics</h2>
                <p class="section-subtitle">Quick access to the most searched help topics</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="topic-card" data-topic="getting-started">
                    <div class="topic-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3>Getting Started</h3>
                    <p>Learn the basics of using Assignly platform</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="topic-card" data-topic="account-management">
                    <div class="topic-icon">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <h3>Account Management</h3>
                    <p>Profile settings, security, and account preferences</p>
                </div>
            </div>
                         <div class="col-lg-4 col-md-6">
                 <div class="topic-card" data-topic="technical-support">
                     <div class="topic-icon">
                         <i class="fas fa-tools"></i>
                     </div>
                     <h3>Technical Support</h3>
                     <p>Troubleshooting and technical issues</p>
                 </div>
             </div>
        </div>
    </div>
</section>

<!-- Quick Actions Section -->
<section class="quick-actions py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="section-title">Quick Actions</h2>
                <p class="section-subtitle">Common tasks and quick solutions</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-video"></i>
                    </div>
                    <h4>Join a Session</h4>
                    <p>Quick guide to joining your tutoring session</p>
                    <a href="#" class="action-link">
                        <span>Learn More</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-calendar-plus"></i>
                    </div>
                    <h4>Book a Tutor</h4>
                    <p>Step-by-step booking process</p>
                    <a href="#" class="action-link">
                        <span>Learn More</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h4>Become a Tutor</h4>
                    <p>Apply to become a tutor today</p>
                    <a href="<?= Helper::baseUrl('/signup?tutor') ?>" class="action-link">
                        <span>Learn More</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h4>Contact Support</h4>
                    <p>Get in touch with our support team</p>
                    <a href="<?= Helper::baseUrl('#contact') ?>" class="action-link">
                        <span>Contact Us</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Browse Categories Section -->
<section class="browse-categories py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="section-title">Browse All Categories</h2>
                <p class="section-subtitle">Explore help topics by category</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="category-list-card">
                    <h3>For Students</h3>
                                         <ul class="category-list">
                         <li>
                             <a href="#">
                                 <span>Creating Your Student Account</span>
                                 <i class="fas fa-chevron-right"></i>
                             </a>
                         </li>
                         <li>
                             <a href="#">
                                 <span>Finding and Choosing Tutors</span>
                                 <i class="fas fa-chevron-right"></i>
                             </a>
                         </li>
                         <li>
                             <a href="#" class="view-all">
                                 <span>View All Student Articles</span>
                                 <i class="fas fa-arrow-right"></i>
                             </a>
                         </li>
                     </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="category-list-card">
                    <h3>For Tutors</h3>
                                         <ul class="category-list">
                         <li>
                             <a href="#">
                                 <span>Tutor Application Process</span>
                                 <i class="fas fa-chevron-right"></i>
                             </a>
                         </li>
                         <li>
                             <a href="#">
                                 <span>Setting Up Your Profile</span>
                                 <i class="fas fa-chevron-right"></i>
                             </a>
                         </li>
                         <li>
                             <a href="#" class="view-all">
                                 <span>View All Tutor Articles</span>
                                 <i class="fas fa-arrow-right"></i>
                             </a>
                         </li>
                     </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Support Section -->
<section class="help-contact-support py-5">
    <div class="container">
        <div class="row justify-content-center" id="contact">
            <div class="col-lg-8">
                <div class="support-card">
                    <div class="support-card-header">
                        <i class="fas fa-life-ring"></i>
                        <h2>Still Need Help?</h2>
                        <p>Can't find what you're looking for? Our support team is ready to assist you 24/7.</p>
                    </div>
                    <div class="support-card-body">
                                                 <div class="support-options">
                             <div class="support-option">
                                 <div class="support-option-icon">
                                     <i class="fas fa-envelope"></i>
                                 </div>
                                 <div class="support-option-content">
                                     <h4>Email Support</h4>
                                     <p>Send us a detailed message and we'll respond within 24 hours</p>
                                     <a href="mailto:example123@gmail.com" class="btn btn-outline-primary">Send Email</a>
                                 </div>
                             </div>
                             <div class="support-option">
                                 <div class="support-option-icon">
                                     <i class="fas fa-phone"></i>
                                 </div>
                                 <div class="support-option-content">
                                     <h4>Phone Support</h4>
                                     <p>Speak directly with our support team</p>
                                     <a href="tel:1-800-EXPERT-1" class="btn btn-outline-primary">Call Now</a>
                                 </div>
                             </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Help Center Hero Section */
    .help-hero {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6c63ff 100%);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .help-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="helpgrain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23helpgrain)"/></svg>');
        opacity: 0.3;
    }

    .hero-title {
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        font-weight: 700;
        margin-bottom: 1rem;
        position: relative;
        z-index: 1;
    }

    .hero-subtitle {
        font-size: clamp(1.1rem, 2.5vw, 1.3rem);
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto 3rem;
        color: white;
        position: relative;
        z-index: 1;
    }

    /* Help Search */
    .help-search-wrapper {
        position: relative;
        z-index: 1;
        max-width: 600px;
        margin: 0 auto;
    }

    .help-search-box {
        background: white;
        border-radius: 20px;
        display: flex;
        align-items: center;
        padding: 0.5rem 0.5rem 0.5rem 1.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
    }

    .help-search-box:focus-within {
        transform: translateY(-2px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .help-search-box i.fa-search {
        color: var(--primary-color);
        margin-right: 1rem;
        font-size: 1.2rem;
    }

    .help-search-input {
        flex: 1;
        border: none;
        outline: none;
        font-size: 1.1rem;
        padding: 1rem 0;
        color: var(--text-dark);
    }

    .help-search-input::placeholder {
        color: #999;
    }

    .help-search-btn {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6c63ff 100%);
        color: white;
        border: none;
        border-radius: 16px;
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .help-search-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(86, 79, 253, 0.3);
    }

    /* Section Styling */
    .popular-topics {
        background: #f8f9fa;
    }

    .section-title {
        font-size: clamp(2rem, 4vw, 2.5rem);
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .section-subtitle {
        font-size: clamp(1rem, 2.5vw, 1.2rem);
        color: var(--text-light);
        margin-bottom: 0;
    }

    /* Topic Cards */
    .topic-card {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        cursor: pointer;
        border: 1px solid rgba(0, 0, 0, 0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .topic-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        border-color: rgba(86, 79, 253, 0.2);
    }

    .topic-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, var(--primary-color) 0%, #6c63ff 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .topic-icon::before {
        content: '';
        position: absolute;
        inset: -2px;
        background: linear-gradient(135deg, var(--primary-color) 0%, #6c63ff 100%);
        border-radius: 22px;
        z-index: -1;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .topic-card:hover .topic-icon::before {
        opacity: 0.2;
    }

    .topic-icon i {
        font-size: 2rem;
        color: white;
    }

    .topic-card h3 {
        font-size: clamp(1.3rem, 2.5vw, 1.5rem);
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .topic-card p {
        color: var(--text-light);
        line-height: 1.6;
        margin-bottom: 0;
        flex: 1;
    }

    /* Quick Actions */
    .quick-actions {
        background: white;
    }

    .action-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .action-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    }

    .action-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 1.5rem;
        background: rgba(86, 79, 253, 0.1);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .action-card:hover .action-icon {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6c63ff 100%);
    }

    .action-icon i {
        font-size: 1.5rem;
        color: var(--primary-color);
        transition: color 0.3s ease;
    }

    .action-card:hover .action-icon i {
        color: white;
    }

    .action-card h4 {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .action-card p {
        color: var(--text-light);
        line-height: 1.6;
        margin-bottom: 1.5rem;
        flex: 1;
    }

    .action-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .action-link:hover {
        color: #6c63ff;
        gap: 0.8rem;
    }



    /* Browse Categories */
    .browse-categories {
        background: white;
    }

    .category-list-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        height: 100%;
    }

    .category-list-card h3 {
        font-size: clamp(1.4rem, 2.5vw, 1.6rem);
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid rgba(86, 79, 253, 0.1);
        position: relative;
    }

    .category-list-card h3::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 40px;
        height: 2px;
        background: linear-gradient(90deg, var(--primary-color) 0%, #6c63ff 100%);
        border-radius: 2px;
    }

    .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .category-list li {
        margin-bottom: 0.75rem;
    }

    .category-list a {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        color: var(--text-dark);
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .category-list a:hover {
        background: rgba(86, 79, 253, 0.05);
        border-color: rgba(86, 79, 253, 0.2);
        transform: translateX(5px);
    }

    .category-list a.view-all {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6c63ff 100%);
        color: white;
        font-weight: 600;
        margin-top: 1rem;
    }

    .category-list a.view-all:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(86, 79, 253, 0.3);
        background: linear-gradient(135deg, #6c63ff 0%, var(--primary-color) 100%);
    }

    .category-list i {
        font-size: 0.9rem;
        transition: transform 0.3s ease;
    }

    .category-list a:hover i {
        transform: translateX(3px);
    }

    /* Help Contact Support */
    .help-contact-support {
        background: #f8f9fa;
    }

    .support-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .support-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
    }

    .support-card-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6c63ff 100%);
        color: white;
        padding: 3rem 2rem 2rem;
        text-align: center;
        position: relative;
    }

    .support-card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="supportgrain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23supportgrain)"/></svg>');
        opacity: 0.3;
    }

    .support-card-header i {
        font-size: 3rem;
        margin-bottom: 1.5rem;
        display: block;
        opacity: 0.9;
        position: relative;
        z-index: 1;
    }

    .support-card-header h2 {
        font-size: clamp(2rem, 4vw, 2.5rem);
        font-weight: 700;
        margin-bottom: 1rem;
        position: relative;
        z-index: 1;
    }

    .support-card-header p {
        font-size: clamp(1.1rem, 2.5vw, 1.3rem);
        opacity: 0.9;
        margin: 0;
        position: relative;
        z-index: 1;
        max-width: 500px;
        margin: 0 auto;
    }

    .support-card-body {
        padding: 3rem 2rem;
    }

    .support-options {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
    }

    .support-option {
        display: flex;
        align-items: flex-start;
        gap: 1.5rem;
        padding: 1.5rem;
        border-radius: 16px;
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .support-option:hover {
        background: white;
        border-color: rgba(86, 79, 253, 0.2);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .support-option-icon {
        flex-shrink: 0;
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--primary-color) 0%, #6c63ff 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .support-option:hover .support-option-icon {
        transform: scale(1.05);
    }

    .support-option-icon i {
        font-size: 1.5rem;
        color: white;
    }

    .support-option-content {
        flex: 1;
    }

    .support-option-content h4 {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .support-option-content p {
        color: var(--text-light);
        line-height: 1.6;
        margin-bottom: 1rem;
        font-size: 0.95rem;
    }

    .support-option .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .support-option .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .support-option .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6c63ff 100%);
        border: none;
    }

    .support-option .btn-outline-primary {
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        background: transparent;
    }

    .support-option .btn-outline-primary:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .help-search-box {
            padding: 0.4rem 0.4rem 0.4rem 1rem;
        }

        .help-search-input {
            font-size: 1rem;
            padding: 0.875rem 0;
        }

        .help-search-btn {
            padding: 0.875rem 1.25rem;
        }

        .topic-card {
            padding: 2rem 1.5rem;
        }

        .topic-icon {
            width: 70px;
            height: 70px;
            margin-bottom: 1rem;
        }

        .topic-icon i {
            font-size: 1.8rem;
        }

        .action-card {
            padding: 1.5rem;
        }

        .action-icon {
            width: 50px;
            height: 50px;
            margin-bottom: 1rem;
        }

        .action-icon i {
            font-size: 1.3rem;
        }

        .category-list-card {
            padding: 1.5rem;
        }

        .category-list a {
            padding: 0.875rem 1.25rem;
        }

        .support-card-header {
            padding: 2rem 1.5rem 1.5rem;
        }

        .support-card-header i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .support-card-body {
            padding: 2rem 1.5rem;
        }

        .support-options {
            gap: 1.5rem;
        }

        .support-option {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .support-option-icon {
            margin: 0 auto;
        }
    }

    @media (max-width: 576px) {
        .help-search-box {
            flex-direction: column;
            padding: 1rem;
            gap: 1rem;
        }

        .help-search-input {
            padding: 0.5rem 0;
        }

        .help-search-btn {
            align-self: stretch;
            justify-content: center;
        }

        .topic-card,
        .action-card {
            padding: 1.5rem 1rem;
        }

        .support-options {
            grid-template-columns: 1fr;
        }
    }

    /* Search functionality styles */
    .search-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border-radius: 0 0 20px 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        max-height: 400px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
    }

    .search-result-item {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .search-result-item:hover {
        background: rgba(86, 79, 253, 0.05);
    }

    .search-result-item:last-child {
        border-bottom: none;
    }

    .search-result-title {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .search-result-category {
        font-size: 0.85rem;
        color: var(--primary-color);
        background: rgba(86, 79, 253, 0.1);
        padding: 0.125rem 0.5rem;
        border-radius: 8px;
        display: inline-block;
        margin-bottom: 0.5rem;
    }

    .search-result-excerpt {
        font-size: 0.9rem;
        color: var(--text-light);
        line-height: 1.4;
    }

    .no-results {
        padding: 2rem;
        text-align: center;
        color: var(--text-light);
    }

    /* Loading state */
    .help-search-btn.loading {
        pointer-events: none;
    }

    .help-search-btn.loading i {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('helpSearch');
    const searchBtn = document.querySelector('.help-search-btn');
    const searchBox = document.querySelector('.help-search-box');
    let searchTimeout;

    // Mock search data - in real implementation, this would come from an API
    const searchData = [
        { title: 'How to create an account', category: 'Getting Started', excerpt: 'Step-by-step guide to creating your Assignly account...' },
        { title: 'Booking your first session', category: 'Sessions', excerpt: 'Learn how to find and book tutors for your learning needs...' },
        { title: 'Payment methods and billing', category: 'Payments', excerpt: 'Understanding payment options, billing cycles, and invoices...' },
        { title: 'Technical requirements for online sessions', category: 'Technical', excerpt: 'System requirements and troubleshooting for video sessions...' },
        { title: 'Cancellation and refund policy', category: 'Policies', excerpt: 'Information about canceling sessions and refund procedures...' },
        { title: 'Becoming a tutor on our platform', category: 'Tutors', excerpt: 'Requirements and application process for tutors...' },
        { title: 'Profile settings and preferences', category: 'Account', excerpt: 'How to update your profile and manage account settings...' }
    ];

    // Function to escape HTML to prevent XSS
    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    function performSearch(query) {
        if (!query.trim()) {
            hideSearchResults();
            return;
        }

        // Show loading state
        searchBtn.classList.add('loading');
        
        // Simulate API delay
        setTimeout(() => {
            const results = searchData.filter(item => 
                item.title.toLowerCase().includes(query.toLowerCase()) ||
                item.excerpt.toLowerCase().includes(query.toLowerCase()) ||
                item.category.toLowerCase().includes(query.toLowerCase())
            );
            
            displaySearchResults(results);
            searchBtn.classList.remove('loading');
        }, 300);
    }

    function displaySearchResults(results) {
        // Remove existing results
        const existingResults = document.querySelector('.search-results');
        if (existingResults) {
            existingResults.remove();
        }

        // Create results container
        const resultsContainer = document.createElement('div');
        resultsContainer.className = 'search-results';
        resultsContainer.style.display = 'block';

        if (results.length === 0) {
            resultsContainer.innerHTML = '<div class="no-results">No results found. Try different keywords or <a href="/contact">contact support</a> for help.</div>';
        } else {
            results.forEach(result => {
                const resultItem = document.createElement('div');
                resultItem.className = 'search-result-item';
                resultItem.innerHTML = `
                    <div class="search-result-category">${escapeHtml(result.category)}</div>
                    <div class="search-result-title">${escapeHtml(result.title)}</div>
                    <div class="search-result-excerpt">${escapeHtml(result.excerpt)}</div>
                `;
                resultItem.addEventListener('click', () => {
                   console.log('Navigate to:', result.title);
                    hideSearchResults();
                });
                resultsContainer.appendChild(resultItem);
            });
        }

        searchBox.appendChild(resultsContainer);
    }

    function hideSearchResults() {
        const existingResults = document.querySelector('.search-results');
        if (existingResults) {
            existingResults.remove();
        }
    }

    // Search input events
    searchInput.addEventDead('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            performSearch(this.value);
        }, 300);
    });

    searchInput.addEventListener('focus', function() {
        if (this.value.trim()) {
            performSearch(this.value);
        }
    });

    // Search button click
    searchBtn.addEventListener('click', function() {
        performSearch(searchInput.value);
    });

    // Handle Enter key
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            performSearch(this.value);
        }
    });

    // Hide results when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchBox.contains(e.target)) {
            hideSearchResults();
        }
    });

    // Topic card interactions
    const topicCards = document.querySelectorAll('.topic-card');
    topicCards.forEach(card => {
        card.addEventListener('click', function() {
            const topic = this.dataset.topic;
            // In real implementation, navigate to topic page
            console.log('Navigate to topic:', topic);
        });

        // Add keyboard support
        card.setAttribute('tabindex', '0');
        card.setAttribute('role', 'button');
        card.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });

    // Live chat function (placeholder)
    window.openLiveChat = function() {
        // In real implementation, integrate with chat service
        alert('Live chat would open here. Integration with chat service like Intercom, Zendesk Chat, etc.');
    };

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add hover effects for better interactivity
    const interactiveCards = document.querySelectorAll('.topic-card, .action-card, .article-card');
    interactiveCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Initialize tooltips for interactive elements
    const actionLinks = document.querySelectorAll('.action-link');
    actionLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(3px)';
        });
        
        link.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });

    // Search input placeholder animation
    const searchPlaceholders = [
        'Search for help articles...',
        'Find tutorials and guides...',
        'How to book a session?',
        'Payment and billing help...',
        'Technical support...'
    ];
    
    let placeholderIndex = 0;
    setInterval(() => {
        if (!searchInput.value && document.activeElement !== searchInput) {
            placeholderIndex = (placeholderIndex + 1) % searchPlaceholders.length;
            searchInput.placeholder = searchPlaceholders[placeholderIndex];
        }
    }, 3000);
});
</script>