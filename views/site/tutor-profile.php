<?php

/** @var yii\web\View $this */

use app\components\Helper;
use app\models\User;
use PHPUnit\TextUI\Help;
use yii\helpers\BaseUrl;

$this->title = 'Tutors';
?>
<link rel="stylesheet" href="<?= Helper::baseUrl('/') ?>custom/css/components/teacher-reviews.css">


<style>
    /* Page-specific styles */
    .reviews-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .reviews-header h2 {
        font-size: 2.5rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .reviews-header p {
        font-size: 1.1rem;
        color: var(--text-light);
        max-width: 800px;
        margin: 0 auto;
    }

    .reviews-grid {
        background-color: #F8F9FF;
        padding: 80px 0;
    }

    @media (max-width: 768px) {
        .reviews-header h2 {
            font-size: 2rem;
        }

        .reviews-header p {
            font-size: 1rem;
        }

        .reviews-grid {
            padding: 40px 0;
        }
    }

    .tutor-image img {
        width: 200px !important;
        height: 200px !important;
    }

    .tutor-profile-section {

        /* align-items: normal !important; */
        
    }

    /* Tutor Details Section Styles */
    .tutor-details-section {
        background: #f8f9fa;
    }

    .detail-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        height: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .detail-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .detail-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
        gap: 0.75rem;
    }
    
    .header-left {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .header-right {
        display: flex;
        align-items: center;
    }
    
    .tutor-rating {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(86, 79, 253, 0.1);
        padding: 0.5rem 0.75rem;
        border-radius: 20px;
        border: 1px solid rgba(86, 79, 253, 0.2);
        flex-wrap: wrap;
    }
    
    .tutor-rating.no-rating {
        background: rgba(108, 117, 125, 0.1);
        border-color: rgba(108, 117, 125, 0.2);
    }
    
    .stars {
        display: flex;
        gap: 0.2rem;
    }
    
    .stars .fa-star {
        font-size: 0.9rem;
        color: #ddd;
    }
    
    .stars .fa-star.filled {
        color: #ffc107;
    }
    
    .stars .fa-star.empty {
        color: #e9ecef;
    }
    
    .rating-text {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--primary-color);
    }
    
    .tutor-rating.no-rating .rating-text {
        color: #6c757d;
    }

    .detail-header i {
        font-size: 1.8rem;
        color: var(--primary-color);
        background: rgba(86, 79, 253, 0.1);
        padding: 0.8rem;
        border-radius: 50%;
        width: 3.5rem;
        height: 3.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .detail-header h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
    }

    .detail-content p {
        color: var(--text-light);
        line-height: 1.6;
        margin-bottom: 0.75rem;
    }

    .profile-highlights {
        padding: 0;
        margin: 0;
    }

    .highlight-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.75rem;
    }

    .highlight-row:last-child {
        margin-bottom: 0;
    }

    .highlight-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-light);
        flex: 1;
        font-size: 0.9rem;
    }

    .highlight-item i {
        color: var(--success-color);
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .subject-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }

    .subject-tag {
        background: var(--primary-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .subject-description {
        color: var(--text-light);
        line-height: 1.6;
        margin: 0;
    }

    .education-item, .experience-item {
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e9ecef;
    }

    .education-item:last-child, .experience-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .education-item h4, .experience-item h4 {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.4rem;
    }

    .institution {
        color: var(--primary-color);
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .year, .duration {
        color: var(--text-light);
        font-size: 0.9rem;
        margin-bottom: 0.4rem;
    }

    .description {
        color: var(--text-light);
        line-height: 1.5;
        margin: 0;
    }

    @media (max-width: 768px) {
        .detail-card {
            padding: 1.25rem;
        }
        
        .detail-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .header-left {
            width: 100%;
        }
        
        .header-right {
            width: 100%;
            justify-content: flex-start;
        }
        
        .detail-header h3 {
            font-size: 1.3rem;
        }
        
        .subject-tags {
            gap: 0.4rem;
        }
        
        .subject-tag {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
        }

        .highlight-row {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .highlight-item {
            font-size: 0.85rem;
        }
    }

.detail-header .avg_review{
width: 1.5rem;
height: 1.5rem;
}

 .btn-message {
    padding: 12px 30px;
    border-radius: var(--border-radius);
    font-weight: 500;
    cursor: pointer;
    border: none;
    color: white;
    transition: var(--transition);
    text-transform: capitalize;
    min-width: 140px;
    text-align: center;
    flex: 1;
    max-width: 160px;
}
</style>
<?php


// Default values
$default_props = [
    'background_image' => Helper::baseUrl() . '/custom/images/tutor-summary-bg.jpg',
    'layout_type' => 'full',
    'show_info_panel' => false,
    'show_profile_image' => true,
    'profile' => [
        'first_name' => '',
        'last_name' => '',
        'description' => '',
        'image' => Helper::baseUrl() . '/custom/images/profiles/teacher-1.jpg'
    ],
    'actions' => [
        'buttons' => []
    ],
    'info_panel' => null
];

// If Yii2 user is available, use it for dynamic data
    $_GET['id']=Helper::getuseridfromslug($_GET['id']);
    $user = \app\models\User::findOne($_GET['id']);
    $fullName = isset($user->username) ? $user->username : '';
    $nameParts = explode(' ', $fullName, 2);
    $firstName = $nameParts[0];
    $lastName = isset($nameParts[1]) ? $nameParts[1] : '';
    $profileImage = isset($user->profile_image) && $user->profile_image ? $user->profile_image : Helper::baseUrl() . '/custom/images/profiles/teacher-1.jpg';
    $default_props['profile']['first_name'] = $firstName;
    $default_props['profile']['last_name'] = $lastName;
    $default_props['profile']['image'] = $profileImage;


// Merge provided props with defaults
$props = isset($profile_props) ? array_merge($default_props, $profile_props) : $default_props;

// Ensure we have both first and last names
if (isset($props['profile']['full_name']) && !isset($props['profile']['first_name'])) {
    $name_parts = explode(' ', $props['profile']['full_name'], 2);
    $props['profile']['first_name'] = $name_parts[0];
    $props['profile']['last_name'] = isset($name_parts[1]) ? $name_parts[1] : '';
}




$profile_image = Helper::getuserimage($user->id);
if ($profile_image) {
    $profile_image = Helper::baseUrl(Helper::getuserimage($user->id));
} else {
    $profile_image = NULL;
}
//echo $profile_image;
?>


<!-- Tutor Hero Section Styles -->
<link rel="stylesheet" href="<?= Helper::baseUrl("/") ?>custom/css/components/tutor-hero.css">

<!-- Tutor Hero Section -->
<div class="tutor-hero-section <?php echo $props['layout_type']; ?>"
    style="background-image: url('<?php echo $props['background_image']; ?>')">
    <div class="main-container container">
        <?php if ($props['layout_type'] === 'full'): ?>
            <!-- Include the header component for full layout -->
            <?php //include 'includes/components/tutor-header.php'; 
            ?>
        <?php endif; ?>

        <!-- Tutor Profile Section -->
        <section class="tutor-profile-section full pt-4">
            <div class="tutor-info">
                <h1 class="tutor-name">
                    <span class="first-name"><?php echo $props['profile']['first_name']; ?></span>
                    <span class="last-name"><?php echo $props['profile']['last_name']; ?></span>
                </h1>
                <?php if (!empty($tutor->description->description)): ?>
                    <p class="tutor-short-bio"><?php echo mb_strimwidth($tutor->description->description,0, 500 , '...') ?></p>
                <?php endif; ?>
                <div class="tutor-actions">
                    <a class="btn-message" href="<?=Helper::BaseUrl().'peoples/chat?other='.Helper::getuserslugfromid($user->id) ?>" >Message</a>
                    <!-- <button class="btn-review" type="button">Review(<?php //echo isset($user->rating) ? $user->rating : '0'; ?>)</button> -->
                </div>
            </div>
            
            <div class="tutor-profile-right">
                <div class="tutor-image">
                    <img src="<?= $profile_image ? $profile_image : $props['profile']['image']; ?>" alt="<?php echo $props['profile']['first_name'] . ' ' . $props['profile']['last_name']; ?>" loading="lazy">
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Tutor Details Section -->
<section class="tutor-details-section py-5">
    <div class="container">
        <div class="row">
            <!-- Teacher Profile -->
            <div class="col-lg-6 mb-4">
                <div class="detail-card">
                    <div class="detail-header">
                        <div class="header-left">
                            <i class="fas fa-user-graduate"></i>
                            <h3>Teacher Profile</h3>
                        </div>
                        <?php //print_r($user) ?>
                        <div class="header-right">
                            <?php
                            $avgRating = 0;
                            $reviewCount = 0;
                            if (!empty($tutor->reviews)) {
                                $sum = 0;
                                foreach ($tutor->reviews as $review) {
                                    if (isset($review->star_rating)) {
                                        $sum += $review->star_rating;
                                        $reviewCount++;
                                    }
                                }
                                if ($reviewCount > 0) {
                                    $avgRating = $sum / $reviewCount;
                                }
                            }
                            ?>
                            <?php if ($reviewCount > 0): ?>
                                <div class="tutor-rating">
                                    <div class="stars">
                                        <?php
                                        $fullStars = floor($avgRating);
                                        $halfStar = ($avgRating - $fullStars) >= 0.5 ? 1 : 0;
                                        $emptyStars = 5 - $fullStars - $halfStar;
                                        for ($i = 0; $i < $fullStars; $i++) {
                                            echo '<i class="fas fa-star filled avg_review"></i>';
                                        }
                                        if ($halfStar) {
                                            echo '<i class="fas fa-star fa-star-half-alt filled avg_review"></i>';
                                        }
                                        for ($i = 0; $i < $emptyStars; $i++) {
                                            echo '<i class="fas fa-star empty avg_review"></i>';
                                        }
                                        ?>
                                    </div>
                                    <span class="rating-text"><?= number_format($avgRating, 1) ?> (<?= $reviewCount ?> review<?= $reviewCount > 1 ? 's' : '' ?>)</span>
                                </div>
                            <?php else: ?>
                                <div class="tutor-rating no-rating">
                                    <span class="rating-text">No rating yet</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="detail-content">
                        <?php /* ?>
                        <?php if (!empty($user->description->description)): ?>
                            <p><?= htmlspecialchars($user->description->description) ?></p>
                        <?php else: ?>
                            <p>No profile description available.</p>
                        <?php endif; ?>
                        <?php */ ?>
                        <div class="profile-highlights">
                            <div class="highlight-row">
                                <div class="highlight-item"><i class="fas fa-check-circle"></i> Total Experience: <?= isset($user->details->total_experience) ? (int)$user->details->total_experience.'years' : '-' ?> </div>
                                <div class="highlight-item"><i class="fas fa-check-circle"></i> Teaching Experience: <?= isset($user->details->teaching_experience) ? (int)$user->details->teaching_experience. 'years' : '-' ?> </div>
                            </div>
                            <div class="highlight-row">
                                <div class="highlight-item"><i class="fas fa-check-circle"></i> Communication Language: <?= isset($user->details->communication_language) ? htmlspecialchars($user->details->communication_language) : '-' ?></div>
                                <div class="highlight-item"><i class="fas fa-check-circle"></i> Charge Type: <?= isset($user->details->charge_type) ? htmlspecialchars($user->details->charge_type) : '-' ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subject -->
            <div class="col-lg-6 mb-4">
                <div class="detail-card">
                    <div class="detail-header">
                        <i class="fas fa-book-open"></i>
                        <h3>Subjects</h3>
                    </div>
                    <div class="detail-content">
                        <div class="subject-tags">
                            <?php if (!empty($user->subjects)): ?>
                                <?php foreach ($user->subjects as $subject): ?>
                                    <span class="subject-tag">
                                        <?= htmlspecialchars($subject->subject) ?>
                                        <?php if (!empty($subject->from_level) && !empty($subject->to_level)): ?>
                                            (<?= htmlspecialchars($subject->from_level) ?> - <?= htmlspecialchars($subject->to_level) ?>)
                                        <?php endif; ?>
                                    </span>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span class="subject-tag">No subjects listed</span>
                            <?php endif; ?>
                        </div>
                       
                    </div>
                </div>
            </div>

            <!-- Education -->
            <div class="col-lg-6 mb-4">
                <div class="detail-card">
                    <div class="detail-header">
                        <i class="fas fa-graduation-cap"></i>
                        <h3>Education</h3>
                    </div>
                    <div class="detail-content">
                        <?php if (!empty($user->educations)): ?>
                            <?php foreach ($user->educations as $edu): ?>
                                <div class="education-item">
                                    <h4><?= htmlspecialchars($edu->degree_name) ?></h4>
                                    <p class="institution"><?= htmlspecialchars($edu->institute_name) ?></p>
                                    <p class="year">
                                        <?= !empty($edu->start_date) ? date('Y', strtotime($edu->start_date)) : '' ?>
                                        <?php if (!empty($edu->end_date)): ?> - <?= date('Y', strtotime($edu->end_date)) ?><?php endif; ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="education-item">No education records found.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Professional Experience -->
            <div class="col-lg-6 mb-4">
                <div class="detail-card">
                    <div class="detail-header">
                        <i class="fas fa-briefcase"></i>
                        <h3>Professional Experience</h3>
                    </div>
                    <div class="detail-content">
                        <?php if (!empty($user->experiences)): ?>
                            <?php foreach ($user->experiences as $exp): ?>
                                <div class="experience-item">
                                    <h4><?= htmlspecialchars($exp->designation) ?></h4>
                                    <p class="institution"><?= htmlspecialchars($exp->organization) ?></p>
                                    <p class="duration">
                                        <?= !empty($exp->start_date) ? date('Y', strtotime($exp->start_date)) : '' ?>
                                        <?php if (!empty($exp->end_date)): ?> - <?= date('Y', strtotime($exp->end_date)) ?><?php endif; ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="experience-item">No professional experience found.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reviews Section -->
<section class="reviews-grid">
    <div class="container">
        <div class="reviews-header">
            <h2>Students Reviews</h2>
            <p>Read what our students have to say about their learning experience and success stories with our dedicated tutors.</p>
        </div>
        <div id="reviews-container" class="row g-3">
            <?php
            $this->render('/includes/components/review-card.php');
            if (!empty($tutor->reviews)) {
                foreach ($tutor->reviews as $review) {
                    $review_date = date('j M Y', strtotime($review->created_at));
                    $profile_image = Helper::getuserimage($review->user_id);
                    if ($profile_image) {
                        $profile_image = Helper::baseUrl($profile_image);
                    } else {
                        $profile_image = NULL;
                    }
                    $use_name = User::getusername($review->user_id);

                    renderReviewCard(
                        $profile_image ?: 'https://ui-avatars.com/api/?name=' . $use_name,
                        $use_name ?: 'Student',
                        $review_date ?: '',
                        $review->star_rating ?: '',
                        $review->review_text ?: ''
                    );
                }
            } else {
                echo '<p>No reviews yet.</p>';
            }
            ?>
        </div>

        <div class="text-center mt-3">
            <button id="load-more" class="btn btn-primary" style="display:none;">Load More</button>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const reviews = document.querySelectorAll("#reviews-container .col-lg-4");
    const loadMoreBtn = document.getElementById("load-more");
    let visibleCount = 10; // show first 10

    // Hide all reviews beyond the first 10
    reviews.forEach((review, index) => {
        if (index >= visibleCount) {
            review.style.display = "none";
        }
    });

    // Show load more button only if more than 10
    if (reviews.length > visibleCount) {
        loadMoreBtn.style.display = "inline-block";
    }

    loadMoreBtn.addEventListener("click", function () {
        let nextCount = visibleCount + 10;

        reviews.forEach((review, index) => {
            if (index < nextCount) {
                review.style.display = "block";
            }
        });

        visibleCount = nextCount;

        // Hide button if no more reviews
        if (visibleCount >= reviews.length) {
            loadMoreBtn.style.display = "none";
        }
    });
});
</script>
