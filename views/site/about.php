<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use app\components\Helper;

$this->title = 'About Us - Assignly';
$this->params['meta_description'] = 'Learn about Assignly - the leading online tutoring platform connecting students with expert tutors worldwide. Discover our mission, vision, and commitment to quality education.';
$this->params['meta_keywords'] = 'about us, assignly, online tutoring, education platform, mission, vision, team';
?>

<!-- Hero Section -->
<div class="about-hero-section">
    <div class="hero-background-image"></div>

    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">About Us</h1>
            <nav class="breadcrumb-nav">
                <a href="<?= Helper::baseUrl('/') ?>">Home</a>
                <span class="separator">→</span>
                <span class="current">About</span>
            </nav>
        </div>
    </div>
</div>

<!-- Statistics Section -->
<section class="stats-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number" data-value="<?= $stats['tutors'] ?>" data-suffix="+"><?= $stats['tutors'] ?>+</div>
                        <div class="stat-label">Expert Tutors</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-value="<?= $stats['students'] ?>" data-suffix="+"><?= $stats['students'] ?>+</div>
                        <div class="stat-label">Students Helped</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" data-value="<?= $stats['subjects'] ?>" data-suffix="+"><?= $stats['subjects'] ?>+</div>
                        <div class="stat-label">Subjects</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision Section -->
<section class="mission-vision-section py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="mission-card h-100">
                    <div class="card-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Our Mission</h3>
                    <p>
                        To democratize quality education by providing accessible, personalized tutoring services 
                        that empower students to achieve their academic goals and unlock their full potential.
                    </p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="vision-card h-100">
                    <div class="card-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Our Vision</h3>
                    <p>
                        To become the world's leading platform for personalized education, where every student 
                        has access to expert guidance and every tutor can share their knowledge globally.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- What We Do Section -->
<section class="what-we-do-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">What We Do</h2>
            <p class="section-subtitle">Connecting students with expert tutors for personalized learning experiences</p>
</div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="service-card text-center h-100">
                    <div class="service-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4>Connect Students & Tutors</h4>
                    <p>We match students with qualified tutors based on subject expertise, teaching style, and availability.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card text-center h-100">
                    <div class="service-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h4>Quality Education</h4>
                    <p>All our tutors are verified professionals with proven expertise in their respective subjects.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card text-center h-100">
                    <div class="service-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h4>Flexible Learning</h4>
                    <p>Learn at your own pace with 24/7 access to tutors and flexible scheduling options.</p>
                </div>
            </div>
        </div>
    </div>
</section>





<!-- CTA Section -->
<section class="about-cta-section py-5">
    <div class="container">
        <div class="cta-content text-center">
            <h2>Ready to Start Your Learning Journey?</h2>
            <p>Join thousands of students who are already benefiting from our expert tutoring services</p>
                                <div class="cta-buttons">
                        <a href="<?= Helper::baseUrl('/tutors') ?>" class="btn btn-outline-primary btn-lg">Browse Tutors</a>
                    </div>
        </div>
    </div>
</section>

<style>
/* About Hero Section */
.about-hero-section {
    min-height: 40vh;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
}

.hero-background-image {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: url('<?= Helper::baseUrl('/custom/images/about-us.png') ?>');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    z-index: 1;
}

.hero-content {
    max-width: 600px;
    position: relative;
    z-index: 2;
}

.breadcrumb-nav {
    margin-top: 1rem;
    font-size: clamp(0.9rem, 1.5vw, 1rem);
}

.breadcrumb-nav a {
    color: var(--text-light);
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb-nav a:hover {
    color: var(--primary-color);
}

.breadcrumb-nav .separator {
    margin: 0 0.5rem;
    color: var(--text-light);
}

.breadcrumb-nav .current {
    color: var(--text-dark);
    font-weight: 500;
}

.hero-title {
    font-size: clamp(2.5rem, 5vw, 3.5rem);
    font-weight: 700;
    color: var(--text-dark);
    line-height: 1.2;
    margin: 0;
}



/* Statistics Section */
.stats-section {
    background: #f8f9fa;
    display: none;
}

.stats-grid {
    display: flex;
    gap: clamp(2rem, 4vw, 4rem);
    justify-content: center;
    flex-wrap: wrap;
}

.stats-grid .stat-item {
    text-align: center;
    flex: 1;
    min-width: 150px;
}

.stats-grid .stat-number {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 700;
    color: var(--primary-color);
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stats-grid .stat-label {
    font-size: clamp(0.9rem, 2vw, 1rem);
    color: var(--text-light);
    font-weight: 500;
}



/* Mission & Vision Cards */
.mission-card, .vision-card {
    background: white;
    padding: 2.5rem;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.mission-card:hover, .vision-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.card-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.card-icon i {
    font-size: clamp(1.5rem, 3.5vw, 2rem);
    color: white;
}

.mission-card h3, .vision-card h3 {
    color: var(--text-dark);
    margin-bottom: 1rem;
    font-weight: 600;
    font-size: clamp(1.5rem, 3vw, 1.8rem);
}

.mission-card p, .vision-card p {
    color: var(--text-light);
    line-height: 1.6;
    font-size: clamp(0.9rem, 2.2vw, 1rem);
}

/* Section Titles */
.section-title {
    font-size: clamp(1.8rem, 4vw, 2.5rem);
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 1rem;
}

.section-subtitle {
    font-size: clamp(0.9rem, 2.5vw, 1.1rem);
    color: var(--text-light);
    max-width: 600px;
    margin: 0 auto;
}

/* Service Cards */
.service-card {
    background: white;
    padding: 2rem;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease;
}

.service-card:hover {
    transform: translateY(-5px);
}

.service-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.service-icon i {
    font-size: clamp(1.4rem, 3vw, 1.8rem);
    color: white;
}

.service-card h4 {
    color: var(--text-dark);
    margin-bottom: 1rem;
    font-weight: 600;
    font-size: clamp(1.2rem, 2.8vw, 1.4rem);
}

.service-card p {
    color: var(--text-light);
    line-height: 1.6;
    font-size: clamp(0.85rem, 2vw, 0.95rem);
}





/* CTA Section */
.about-cta-section {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
}

.cta-content {
    padding: 40px 30px;
    max-width: 100%;
}

.cta-content h2 {
    font-size: clamp(1.8rem, 4vw, 2.5rem);
    font-weight: 700;
    margin-bottom: 1rem;
}

.cta-content p {
    font-size: clamp(0.9rem, 2.5vw, 1.1rem);
    margin-bottom: 2rem;
    opacity: 0.9;
}

.cta-buttons .btn {
    padding: 0.75rem 2rem;
    font-weight: 600;
    border-radius: 8px;
    font-size: clamp(0.9rem, 2.2vw, 1rem);
    display: inline-block;
}

.btn-outline-primary {
    color: white;
    border-color: white;
}

.btn-outline-primary:hover {
    background: white;
    color: var(--primary-color);
}

/* Responsive Design - Layout adjustments only */
@media (max-width: 991.98px) {
    .about-hero-section {
        min-height: 50vh;
    }
}

@media (max-width: 767.98px) {
    .about-hero-section {
        min-height: 45vh;
    }
    
    .mission-card, .vision-card {
        padding: 2rem;
    }
    
    .cta-buttons .btn {
        display: block;
        width: 100%;
        margin-bottom: 1rem;
    }
    
    .cta-buttons .btn:last-child {
        margin-bottom: 0;
    }
}

@media (max-width: 575.98px) {
    .about-hero-section {
        min-height: 20vh;
    }
}
</style>
