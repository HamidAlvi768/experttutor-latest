<!-- Welcome Section -->
<section class="welcome-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="section-title">Welcome to Assignly</h2>
                <p class="section-subtitle">Your trusted platform for academic excellence and professional growth</p>
            </div>
        </div>
        <div class="row g-4">
            <!-- Students Column -->
            <div class="col-lg-6">
                <div class="welcome-card student-card">
                    <div class="welcome-card-header">
                        <div class="welcome-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h3>For Students</h3>
                    </div>
                    <div class="welcome-card-body">
                        <ul class="welcome-points">
                            <li>
                                <div class="point-icon">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="point-content">
                                    <h4>Get Expert Support</h4>
                                    <p>Access qualified tutors for assignments, projects, and personalized learning guidance.</p>
                                </div>
                            </li>
                            <li>
                                <div class="point-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="point-content">
                                    <h4>Learn Your Way</h4>
                                    <p>Enjoy flexible, one-on-one sessions tailored to your goals and schedule.</p>
                                </div>
                            </li>
                            <li>
                                <div class="point-icon">
                                    <i class="fas fa-trophy"></i>
                                </div>
                                <div class="point-content">
                                    <h4>Achieve More</h4>
                                    <p>Gain the skills and knowledge you need to excel academically and beyond.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Teachers Column -->
            <div class="col-lg-6">
                <div class="welcome-card teacher-card">
                    <div class="welcome-card-header">
                        <div class="welcome-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h3>For Tutors</h3>
                    </div>
                    <div class="welcome-card-body">
                        <ul class="welcome-points">
                            <li>
                                <div class="point-icon">
                                    <i class="fas fa-lightbulb"></i>
                                </div>
                                <div class="point-content">
                                    <h4>Share Your Expertise</h4>
                                    <p>Connect with motivated students who value your skills and knowledge.</p>
                                </div>
                            </li>
                            <li>
                                <div class="point-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="point-content">
                                    <h4>Work on Your Terms</h4>
                                    <p>Choose assignments, projects, or ongoing tutoring that fits your availability.</p>
                                </div>
                            </li>
                            <li>
                                <div class="point-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div class="point-content">
                                    <h4>Grow Your Impact</h4>
                                    <p>Build your professional profile while helping students achieve their goals.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Welcome Section */
    .welcome-section {
        background: #f8f9fa;
    }

    .section-title {
        font-size: clamp(1.5rem, 5vw, 3rem);
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .section-subtitle {
        font-size: clamp(0.8rem, 2.5vw, 1.3rem);
        color: var(--text-light);
        max-width: 600px;
        margin: 0 auto;
    }

    /* Welcome Cards */
    .welcome-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
        height: 100%;
    }

    .welcome-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 48px rgba(0, 0, 0, 0.15);
    }

    .welcome-card-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, #6c63ff 100%);
        color: white;
        padding: 2rem;
        text-align: center;
        position: relative;
    }

    .welcome-card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="welcomegrain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23welcomegrain)"/></svg>');
        opacity: 0.3;
    }

    .welcome-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1rem;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 1;
    }

    .welcome-icon i {
        font-size: 2.5rem;
        color: white;
    }

    .welcome-card-header h3 {
        font-size: clamp(1.1rem, 3vw, 2.2rem);
        font-weight: 700;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .welcome-card-body {
        padding: 2rem;
    }

    /* Welcome Points */
    .welcome-points {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .welcome-points li {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding: 1rem;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .welcome-points li:hover {
        background: rgba(86, 79, 253, 0.05);
        transform: translateX(5px);
    }

    .welcome-points li:last-child {
        margin-bottom: 0;
    }

    .point-icon {
        flex-shrink: 0;
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--primary-color) 0%, #6c63ff 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .welcome-points li:hover .point-icon {
        transform: scale(1.1);
    }

    .point-icon i {
        font-size: 1.2rem;
        color: white;
    }

    .point-content {
        flex: 1;
    }

    .point-content h4 {
        font-size: clamp(1.1rem, 2vw, 1.3rem);
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .point-content p {
        color: var(--text-light);
        line-height: 1.6;
        margin: 0;
        font-size: 0.95rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .welcome-card-header {
            padding: 1.5rem;
        }

        .welcome-icon {
            width: 70px;
            height: 70px;
            margin-bottom: 0.75rem;
        }

        .welcome-icon i {
            font-size: 2rem;
        }

        .welcome-card-body {
            padding: 1.5rem;
        }

        .welcome-points li {
            padding: 0.75rem;
            margin-bottom: 1rem;
        }

        .point-icon {
            width: 45px;
            height: 45px;
        }

        .point-icon i {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 576px) {
        .welcome-card-header {
            padding: 1.25rem;
        }

        .welcome-card-body {
            padding: 1.25rem;
        }

        .welcome-points li {
            flex-direction: column;
            text-align: center;
            gap: 0.75rem;
        }

        .point-icon {
            margin: 0 auto;
        }
    }
</style>
