<?php

namespace app\controllers;

use Yii;
use app\components\Helper;
use app\models\GeneralSetting;
use app\models\Profiles;
use app\models\StudentJobPosts;
use app\models\TeacherSubjects;
use yii\db\Expression as DbExpression;

$site_setting = GeneralSetting::find()->one();


// Default logo settings if not provided
$logo_src = !empty($site_setting->site_logo_white) ? Helper::baseUrl('/') . $site_setting->site_logo_white : Helper::baseUrl("/").'custom/images/logo-white.png';
$logo_alt = !empty($site_setting->site_name) ? $site_setting->site_name : 'Assignment Connect';
?>

<?php $top_subjects = TeacherSubjects::find()
    ->select(['subject', new DbExpression('COUNT(subject) as subjects_count')])
    ->groupBy('subject')
    ->orderBy(['subjects_count' => SORT_DESC])
    ->limit(4)
    ->all(); ?>


<footer class="main-footer bg-dark text-light py-5">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                <img src="<?= $logo_src ?>" alt="Assignment Connect" class="footer-logo mb-4">
                <p>Connecting tutors and students with <?= $logo_alt ?> worldwide.</p>
                <div class="social-icons">
                    <?php if (!empty($site_setting->social_fb)): ?>
                        <a href="<?= $site_setting->social_fb ?>" target="_blank" class="social-icon-link">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($site_setting->social_ig)): ?>
                        <a href="<?= $site_setting->social_ig ?>" target="_blank" class="social-icon-link">
                            <i class="fab fa-instagram"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($site_setting->social_li)): ?>
                        <a href="<?= $site_setting->social_li ?>" target="_blank" class="social-icon-link linkedin">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($site_setting->social_tw)): ?>
                        <a href="<?= $site_setting->social_tw ?>" target="_blank" class="social-icon-link">
                            <i class="fab fa-twitter"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($site_setting->youtube)): ?>
                        <a href="<?= $site_setting->youtube ?>" target="_blank" class="social-icon-link">
                            <i class="fab fa-youtube"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                <h4>TOP 4 CATEGORY</h4>
                <ul class="list-unstyled">
                    <?php foreach ($top_subjects as $subject): ?>
                        <li><a href="<?= Helper::baseUrl("/") ?>tutors?search=<?= $subject->subject ?>"><?= htmlspecialchars($subject->subject) ?></a></li>
                    <?php endforeach; ?>

                </ul>
            </div>

            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                <h4>Quick Links</h4>
                <ul class="list-unstyled">
                    <li><a href="<?= Helper::baseUrl("/about") ?>">About</a></li>
                    <li><a href="<?= Helper::baseUrl("/faq") ?>">FAQs</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                <h4>Support</h4>
                <ul class="list-unstyled">
                    <li><a href="<?= Helper::baseUrl("/help") ?>">Help Center</a></li>
                    <li><a href="<?= Helper::baseUrl("/terms") ?>">Terms & Condition</a></li>
                    <li><a href="<?= Helper::baseUrl("/privacy-policy") ?>">Privacy Policy</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6">
                <h4>Download Our App</h4>
                <div class="app-buttons">
                    <a href="#" class="d-block mb-2">
                        <img src="<?= Helper::baseUrl("/") ?>custom/images/app-store.png" alt="App Store" class="img-fluid">
                    </a>
                    <a href="#" class="d-block">
                        <img src="<?= Helper::baseUrl("/") ?>custom/images/google-play.png" alt="Google Play" class="img-fluid">
                    </a>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="footer-bottom d-flex justify-content-between">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> <?= $logo_alt ?>. All rights reserved.</p>
                    <!-- <div class="language-selector">
                        <select class="form-select bg-dark text-light border-0">
                            <option selected>English</option>
                            <option>Spanish</option>
                            <option>French</option>
                            <option>German</option>
                        </select>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    // Social icon hover functionality
    document.addEventListener('DOMContentLoaded', function() {
        const socialIcons = document.querySelectorAll('.social-icon-link');

        // Set default active state to LinkedIn (middle icon)
        const linkedInIcon = document.querySelector('.social-icon-link.linkedin');

        socialIcons.forEach(icon => {
            icon.addEventListener('mouseenter', function() {
                // Remove active class from all icons
                socialIcons.forEach(i => i.classList.remove('linkedin'));
                // Add active class to hovered icon
                this.classList.add('linkedin');
            });

            icon.addEventListener('mouseleave', function() {
                // Remove active class from all icons
                socialIcons.forEach(i => i.classList.remove('linkedin'));
                // Reset default active state
                linkedInIcon.classList.add('linkedin');
            });
        });
    });
</script>