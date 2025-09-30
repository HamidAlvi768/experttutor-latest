<?php

/** @var yii\web\View $this */

use app\components\Helper;

$this->title = 'Frequently Asked Questions - Assignly';
?>

<!-- FAQ Hero Section -->
<section class="faq-hero py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="hero-title">Frequently Asked Questions</h1>
                <p class="hero-subtitle">Find answers to common questions about our tutoring platform, services, and how to get started.</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Content Section -->
<section class="faq-content py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <!-- For Students Category -->
                <div class="faq-category mb-5">
                    <h2 class="category-title">For Students</h2>
                    <div class="faq-accordion" id="faqStudentsAccordion">
                        
                        <div class="faq-item">
                            <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="false" aria-controls="faq1">
                                <h3>How do I find a tutor on Assignly?</h3>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div id="faq1" class="collapse" data-bs-parent="#faqStudentsAccordion">
                                <div class="faq-answer">
                                    <p>Finding a tutor on our platform is easy. Simply use our tutor search feature to browse through available tutors, read their profiles, and select the one that suits your needs.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                                <h3>Can I schedule online tutoring sessions?</h3>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div id="faq2" class="collapse" data-bs-parent="#faqStudentsAccordion">
                                <div class="faq-answer">
                                    <p>Yes! We offer both in-person and online tutoring sessions. You can use any medium for online tutoring that suits your convenience.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                                <h3>Can I switch my student account to a tutor account?</h3>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div id="faq3" class="collapse" data-bs-parent="#faqStudentsAccordion">
                                <div class="faq-answer">
                                    <p>To become a tutor, go to your student account and click “Switch to Tutor.” Complete your tutor profile, and then you’ll be able to log in as both a student and a tutor using the same account.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
                                <h3>What subjects do your tutors cover?</h3>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div id="faq4" class="collapse" data-bs-parent="#faqStudentsAccordion">
                                <div class="faq-answer">
                                    <p>Our platform covers a wide range of subjects including Mathematics, Sciences (Physics, Chemistry, Biology), Languages (English, Spanish, French), Computer Science, History, Literature, and many more.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq5" aria-expanded="false" aria-controls="faq5">
                                <h3>How do I know if a tutor is qualified and reliable?</h3>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div id="faq5" class="collapse" data-bs-parent="#faqStudentsAccordion">
                                <div class="faq-answer">
                                    <p>All our tutors undergo a thorough verification process including background checks, qualification verification, and reference checks. You can view their credentials, experience, ratings, and reviews from previous students.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq6" aria-expanded="false" aria-controls="faq6">
                                <h3>How do Student post a job request ?</h3>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div id="faq6" class="collapse" data-bs-parent="#faqStudentsAccordion">
                                <div class="faq-answer">
                                    <p>From your dashboard, go to Post a Job, fill in the subject, budget, preferences (online/home/assignment), and any requirements. Review and submit to publish your job request for tutors to apply.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- For Tutors Category -->
                <div class="faq-category mb-5">
                    <h2 class="category-title">For Tutors</h2>
                    <div class="faq-accordion" id="faqTutorsAccordion">
                        
                        <div class="faq-item">
                            <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq7" aria-expanded="false" aria-controls="faq7">
                                <h3>How do I become a tutor on the platform?</h3>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div id="faq7" class="collapse" data-bs-parent="#faqTutorsAccordion">
                                <div class="faq-answer">
                                    <p>To become a tutor, create an account and select the "Tutor" role. Complete your profile with your qualifications, experience, and subjects taught.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq8" aria-expanded="false" aria-controls="faq8">
                                <h3>What are the requirements to become a tutor?</h3>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div id="faq8" class="collapse" data-bs-parent="#faqTutorsAccordion">
                                <div class="faq-answer">
                                    <p>We require tutors to have relevant educational qualifications, teaching experience, and subject expertise. </p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq10a" aria-expanded="false" aria-controls="faq10a">
                                <h3>How do tutors buy coins?</h3>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div id="faq10a" class="collapse" data-bs-parent="#faqTutorsAccordion">
                                <div class="faq-answer">
                                    <p>Tutors can purchase coins directly from their wallet using the available payment options.</p>
                                </div>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq10b" aria-expanded="false" aria-controls="faq10b">
                                <h3>How do tutors apply for a job?</h3>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div id="faq10b" class="collapse" data-bs-parent="#faqTutorsAccordion">
                                <div class="faq-answer">
                                    <p>Tutors can browse available job requests on the platform and use their coins to apply directly to the ones that match their expertise.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Contact Support Section -->
<section class="contact-support py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="support-card">
                    <div class="support-card-header">
                        <i class="fas fa-question-circle"></i>
                        <h2>Still Have Questions?</h2>
                        <p>Can't find the answer you're looking for? Our support team is here to help!</p>
                    </div>
                    <div class="support-card-body">
                        <div class="support-actions">
                            <a href="<?= Helper::baseUrl('/help') ?>" class="btn btn-primary btn-lg me-3">Help Center</a>
                            <a href="<?= Helper::baseUrl('/about') ?>" class="btn btn-outline-primary btn-lg">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* FAQ Hero Section */
    .faq-hero {
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

    /* FAQ Content */
    .faq-content {
        background: #f8f9fa;
    }

    /* FAQ Categories */
    .faq-category {
        margin-bottom: 3rem;
    }

    .category-title {
        font-size: clamp(1.8rem, 3vw, 2.2rem);
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 3px solid var(--primary-color);
        position: relative;
    }

    .category-title::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-color) 0%, #6c63ff 100%);
        border-radius: 2px;
    }

    .faq-accordion {
        max-width: 100%;
        margin: 0;
    }

    .faq-item {
        background: white;
        border-radius: 16px;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
        position: relative;
    }

    .faq-item:hover {
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        transform: translateY(-3px);
        border-color: rgba(86, 79, 253, 0.2);
    }

    .faq-item.active {
        border-color: var(--primary-color);
        box-shadow: 0 8px 32px rgba(86, 79, 253, 0.15);
    }

    .faq-question {
        padding: 2rem;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: white;
        border: none;
        width: 100%;
        text-align: left;
        transition: all 0.3s ease;
        position: relative;
    }

    .faq-question:hover {
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
    }

    .faq-question:focus {
        outline: none;
        background: linear-gradient(135deg, #f0f2ff 0%, #e8ebff 100%);
        box-shadow: 0 0 0 3px rgba(86, 79, 253, 0.1);
    }

    .faq-question[aria-expanded="true"] {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6c63ff 100%);
        color: white;
        transition: all 0.3s ease;
    }

    .faq-question[aria-expanded="true"] h3 {
        color: white;
        transition: color 0.3s ease;
    }

    .faq-question[aria-expanded="true"] i {
        color: white;
        transform: rotate(180deg);
        transition: all 0.3s ease;
    }

    .faq-question h3 {
        font-size: clamp(1.1rem, 2.5vw, 1.3rem);
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
        flex: 1;
        padding-right: 1.5rem;
        line-height: 1.4;
        transition: color 0.3s ease;
    }

    .faq-question i {
        font-size: 1.4rem;
        color: var(--primary-color);
        transition: all 0.3s ease;
        flex-shrink: 0;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(86, 79, 253, 0.1);
        border-radius: 50%;
        padding: 0.5rem;
    }

    .faq-question[aria-expanded="true"] i {
        background: rgba(255, 255, 255, 0.2);
        transform: rotate(180deg);
    }

    .faq-answer {
        padding: 0 2rem 2rem;
        background: white;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .faq-answer p {
        color: var(--text-light);
        line-height: 1.7;
        margin: 0;
        font-size: clamp(1rem, 2vw, 1.1rem);
        padding-top: 1rem;
    }

    /* Active state indicator */
    .faq-item.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, var(--primary-color) 0%, #6c63ff 100%);
        border-radius: 0 2px 2px 0;
        transition: all 0.3s ease;
    }

    /* Ensure smooth transitions for all state changes */
    .faq-item {
        transition: all 0.3s ease;
    }

    .faq-item.active {
        border-color: var(--primary-color);
        box-shadow: 0 8px 32px rgba(86, 79, 253, 0.15);
        transition: all 0.3s ease;
    }

    /* Contact Support Section */
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
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .support-card-header i {
        font-size: 3rem;
        margin-bottom: 1.5rem;
        display: block;
        opacity: 0.9;
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
        padding: 2.5rem 2rem;
        background: white;
    }

    .support-actions {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .support-actions .btn {
        padding: 0.875rem 2.5rem;
        font-weight: 600;
        border-radius: 12px;
        transition: all 0.3s ease;
        font-size: 1.1rem;
        min-width: 180px;
    }

    .support-actions .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .support-actions .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6c63ff 100%);
        border: none;
    }

    .support-actions .btn-outline-primary {
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        background: transparent;
    }

    .support-actions .btn-outline-primary:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .category-title {
            font-size: 1.6rem;
            margin-bottom: 1.5rem;
        }

        .faq-question {
            padding: 1.5rem;
        }

        .faq-answer {
            padding: 0 1.5rem 1.5rem;
        }

        .faq-question h3 {
            font-size: 1.1rem;
        }

        .faq-question i {
            font-size: 1.2rem;
            width: 20px;
            height: 20px;
            padding: 0.4rem;
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

        .support-actions {
            flex-direction: column;
            align-items: center;
        }

        .support-actions .btn {
            width: 100%;
            max-width: 300px;
        }
    }

    @media (max-width: 576px) {
        .faq-question h3 {
            font-size: 1rem;
        }

        .faq-answer p {
            font-size: 0.95rem;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced FAQ functionality
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.collapse');
        
        // Keyboard navigation support
        question.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                question.click();
            }
        });

        // Focus management
        question.addEventListener('focus', function() {
            this.setAttribute('tabindex', '0');
        });

        // ARIA updates - moved to Bootstrap event listeners for proper synchronization
        question.addEventListener('click', function() {
            // Remove active class from all other items when opening
            const isCurrentlyExpanded = this.getAttribute('aria-expanded') === 'true';
            if (!isCurrentlyExpanded) {
                faqItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('active');
                    }
                });
            }
        });
    });

    // Initialize Bootstrap collapse with proper state management
    const collapseElements = document.querySelectorAll('.collapse');
    collapseElements.forEach(collapse => {
        const faqItem = collapse.closest('.faq-item');
        const question = collapse.previousElementSibling;
        
        // When collapse starts showing
        collapse.addEventListener('show.bs.collapse', function() {
            this.style.transition = 'all 0.3s ease';
            
            // Add active class when expanding
            faqItem.classList.add('active');
            
            // Update ARIA attributes
            question.setAttribute('aria-expanded', 'true');
            question.setAttribute('aria-label', 'Collapse answer');
        });
        
        // When collapse starts hiding
        collapse.addEventListener('hide.bs.collapse', function() {
            this.style.transition = 'all 0.3s ease';
            
            // Remove active class when collapsing
            faqItem.classList.remove('active');
            
            // Update ARIA attributes
            question.setAttribute('aria-expanded', 'false');
            question.setAttribute('aria-label', 'Expand answer');
        });
        
        // When collapse is fully shown
        collapse.addEventListener('shown.bs.collapse', function() {
            // Add smooth scroll to expanded answers
            const rect = question.getBoundingClientRect();
            const isInViewport = rect.top >= 0 && rect.bottom <= window.innerHeight;
            
            if (!isInViewport) {
                question.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
            }
        });
    });

    // Add hover effects for better interactivity
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        
        question.addEventListener('mouseenter', function() {
            if (this.getAttribute('aria-expanded') !== 'true') {
                this.style.transform = 'translateX(5px)';
            }
        });
        
        question.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
});
</script>
