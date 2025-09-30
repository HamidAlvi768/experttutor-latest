<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\components\Helper;
use app\models\GeneralSetting;
use yii\helpers\Html;

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Get the current page name to highlight active link
$current_page = basename($_SERVER['PHP_SELF'], '.php');
$currentRoute = Yii::$app->controller->route;
$user = Yii::$app->user->identity;
$profile_image=Helper::getuserimage($user->id);
if($profile_image){
$profile_image = Helper::baseUrl(Helper::getuserimage($user->id));
}else{
 $profile_image=NULL;
}



$site_setting = GeneralSetting::find()->one();

?>

<style>
    .profile-user-dropdown-wrapper {
        position: relative;
        display: inline-block;
    }

    .profile-user-dropdown-toggle2{
        background: none;
        border: none;
        cursor: pointer;
        padding: 0 6px;
        font-size: 1.1rem;
    }

    .profile-user-dropdown-toggle {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0 6px;
        font-size: 1.1rem;
        color: #333;
    }

    /* Ensure mobile navigation is properly styled */
    .profile-mobile-toggle {
        display: none;
        background: none;
        border: none;
        cursor: pointer;
        padding: 10px;
        margin-left: auto;
        position: relative;
        z-index: 1001;
    }

    .hamburger-line {
        display: block;
        width: 24px;
        height: 2px;
        background-color: #333;
        margin: 5px 0;
        transition: all 0.3s ease;
    }

    /* Mobile navigation container */
    .profile-nav-links-container {
        display: flex;
        align-items: center;
        gap: 48px;
    }

    /* Mobile-specific styles */
    @media (max-width: 991.98px) {
        .profile-mobile-toggle {
            display: block;
        }

        .profile-nav-links-container {
            position: fixed;
            top: 0;
            right: -300px;
            width: 300px;
            height: 100vh;
            background: white;
            padding: 80px 20px 20px;
            z-index: 1120;
            flex-direction: column;
            opacity: 0;
            visibility: hidden;
            transform: translateX(100%);
            transition: all 0.3s ease;
            overflow-y: auto;
            display: none;
        }

        .profile-nav-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: none;
            border: none;
            cursor: pointer;
            width: 30px;
            height: 30px;
            display: none;
            align-items: center;
            justify-content: center;
            color: #333;
            font-size: 24px;
            z-index: 1121;
        }

        .profile-mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease;
            display: none;
        }

        /* Active states */
        body.mobile-menu-active .profile-nav-links-container {
            display: flex !important;
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
            right: 0;
            z-index: 1000;
        }

        body.mobile-menu-active .profile-nav-close {
            /* display: flex; */
            /* z-index: -1; */
            display: none;
        }

        body.mobile-menu-active .profile-mobile-overlay {
            display: block;
            opacity: 1;
            visibility: visible;
            z-index: 1;
        }

        .profile-nav-links {
            display: flex !important;
            flex-direction: column;
            gap: 10px;
            width: 100%;
        }

        .profile-nav-links a {
            width: 100%;
            padding: 12px 0;
            border-bottom: 1px solid #e7e7e7;
        }

        .profile-user-info.mobile-only {
            display: none;
            padding: 20px 0;
            border-top: 1px solid #e7e7e7;
            margin-top: 20px;
            width: 100%;
        }

        body.mobile-menu-active .profile-user-info.mobile-only {
            display: flex;
        }
    }

    /* Desktop styles */
    @media (min-width: 992px) {
        .profile-nav-links-container {
            position: relative;
            z-index: 1;
            display: flex !important;
            opacity: 1 !important;
            visibility: visible !important;
            transform: none !important;
            padding: 0;
            height: auto;
            background: none;
            overflow: visible;
        }

        .profile-mobile-toggle,
        .profile-nav-close,
        .profile-mobile-overlay {
            display: none !important;
        }

        .profile-nav-links {
            display: flex !important;
            flex-direction: row;
            gap: 32px;
        }
    }
</style>
<?php //echo  var_dump($user->id);die; ?>
<!-- Main Navigation -->
<nav class="profile-main-nav">
    <div class="profile-container">
        <div class="profile-nav-content">
            <div class="profile-nav-left">
                <h5 class="mb-0">
                <a href="<?= Helper::baseUrl("") ?>" class="profile-logo">
                    <?php /*?><img src="<?= Helper::baseUrl("/") ?>custom/images/profile-logo.png" alt="Tutor Expert" class="profile-logo-image">
                    <?php */
                    ?>
                    <?= $site_setting->site_name ?> 
                </a>
                </h5>
                <!-- Hamburger Menu Button -->
                <button class="profile-mobile-toggle" aria-label="Toggle menu" aria-expanded="false">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>

                <!-- Navigation Links - Now wrapped in a container for mobile -->
                <div class="profile-nav-links-container">
                    <!-- Close button for mobile -->
                    <button class="profile-nav-close" aria-label="Close menu">
                        <i class="fas fa-times"></i>
                    </button>

                    <div class="profile-nav-links">
                        <a href="<?= Helper::baseUrl('/post/list') ?>" class="<?= str_contains($currentRoute, 'list') ? 'active' : '' ?>">Post Jobs</a>
                        <?php /*?>
                        <a href="<?= Helper::baseUrl('profile') ?>"
                            class="<?= (str_contains($currentRoute, 'profile') || str_contains($currentRoute, 'subject') || str_contains($currentRoute, 'education') || str_contains($currentRoute, 'professional-experience') || str_contains($currentRoute, 'teaching-details') || (str_contains($currentRoute, 'description'))) ? 'active' : '' ?>">
                            Profile
                        </a>
                        <?php */?>

                        <a href="<?= Helper::baseUrl('/peoples') ?>" class="<?= str_contains($currentRoute, 'peoples') || str_contains($currentRoute, 'chat')  ? 'active' : '' ?>">Messages</a>
                        
                        <?php /* ?><a href="<?= Helper::baseUrl('/post/create') ?>" class="<?= str_contains($currentRoute, 'create') ? 'active' : '' ?>">Request a Tutor</a><?php */?>
                    </div>

                    <!-- Mobile-only user info -->
                    <div class="profile-user-info mobile-only">
                        <img src="<?= Html::encode($profile_image ??  Helper::baseUrl("custom/images/profile.jpg") ) ?>" alt="<?= Html::encode($user->username) ?>" class="profile-user-pic">
                        <span class="profile-user-name"><?= Html::encode($user->username) ?><br>(<?= Html::encode($user->role ?? '') ?>)</span>
                        <!-- <i class="fas fa-user profile-verification-badge"></i> -->
                        <div class="profile-user-dropdown-wrapper">
                            <button class="profile-user-dropdown-toggle" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="profile-user-dropdown-menu">
                                
                        
                    
                            <a  href="<?php echo Helper::baseUrl("/profile/edit") ?>">Profile</a>
                            <a  href="<?php echo Helper::baseUrl("/peoples") ?>"> Messages</a>


                                <?= Html::beginForm(['/logout'], 'post') . Html::submitButton('Logout', ['class' => 'dropdown-item logout']) . Html::endForm() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desktop user info -->
            <div class="profile-user-info desktop-only">
                <img src="<?= Html::encode($profile_image  ?? Helper::baseUrl('custom/images/profile.jpg') ) ?>" alt="<?= Html::encode($user->username) ?>" class="profile-user-pic">
                <span class="profile-user-name"><?= Html::encode($user->username) ?><br>(<?= Html::encode($user->role ?? '') ?>)</span>
                <!-- <i class="fas fa-user profile-verification-badge"></i> -->
                <div class="profile-user-dropdown-wrapper">
                    <button class="profile-user-dropdown-toggle2" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="profile-user-dropdown-menu">

                    <?php $role= Yii::$app->user->identity->role ?>
<?php if ($role === 'student'): ?>
    <a href="<?= \yii\helpers\Url::to(['site/switch-role', 'role' => 'tutor']) ?>">Switch to Tutor</a>
<?php elseif ($role === 'tutor'): ?>
    <a href="<?= \yii\helpers\Url::to(['site/switch-role', 'role' => 'student']) ?>">Switch to Student</a>
<?php endif; ?>

                        
                        
                        
             
    

                           
                           <?php /*?> 
                            <a  href="<?php echo Helper::baseUrl("/peoples") ?>"> Messages</a>
                            <hr/>
                            <a  href="<?php echo Helper::baseUrl("/profile/edit") ?>">Profile</a>
                            <?php */?>
                            
                        <?= Html::beginForm(['/logout'], 'post') . Html::submitButton('Logout', ['class' => 'dropdown-item logout']) . Html::endForm() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Menu Overlay -->
<div class="profile-mobile-overlay"></div>



<style>
    .profile-user-dropdown-wrapper {
        position: relative;
        display: inline-block;
    }

    .profile-user-dropdown-toggle {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0 6px;
        font-size: 1.1rem;
        color: #333;
    }

    .profile-user-dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        top: 120%;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
        min-width: 150px;
        z-index: 100;
        padding: 8px 0;
    }

    .profile-user-dropdown-menu a,
    .profile-user-dropdown-menu .dropdown-item.logout {
        display: block;
        padding: 10px 18px;
        color: #333;
        text-decoration: none;
        font-size: 1rem;
        background: none;
        border: none;
        text-align: left;
        width: 100%;
        cursor: pointer;
    }

    .profile-user-dropdown-menu a:hover,
    .profile-user-dropdown-menu .dropdown-item.logout:hover {
        background: #f5f5f5;
    }

    .profile-user-dropdown-wrapper.open .profile-user-dropdown-menu {
        display: block;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Main nav student script loaded');
        
        // Mobile navigation functionality
        const mobileToggle = document.querySelector('.profile-mobile-toggle');
        const mobileOverlay = document.querySelector('.profile-mobile-overlay');
        const navLinksContainer = document.querySelector('.profile-nav-links-container');
        const navClose = document.querySelector('.profile-nav-close');
        const body = document.body;

        // Debug: Check initial state of elements
        function debugInitialState() {
            console.log('=== Debug: Initial State ===');
            console.log('Mobile toggle found:', !!mobileToggle);
            console.log('Mobile overlay found:', !!mobileOverlay);
            console.log('Nav container found:', !!navLinksContainer);
            console.log('Nav close found:', !!navClose);
            
            if (navLinksContainer) {
                const styles = getComputedStyle(navLinksContainer);
                console.log('Nav container initial styles:');
                console.log('- display:', styles.display);
                console.log('- position:', styles.position);
                console.log('- right:', styles.right);
                console.log('- opacity:', styles.opacity);
                console.log('- visibility:', styles.visibility);
                console.log('- transform:', styles.transform);
                console.log('- z-index:', styles.zIndex);
            }
            
            console.log('Body classes:', body.className);
            console.log('=== End Debug ===');
        }
        
        // Run debug on load
        debugInitialState();
        


        // Toggle mobile menu
        function toggleMobileMenu() {
            console.log('Toggle mobile menu called');
            console.log('Body classes before:', body.className);
            body.classList.toggle('mobile-menu-active');
            const isActive = body.classList.contains('mobile-menu-active');
            console.log('Body classes after:', body.className);
            console.log('Mobile menu active:', isActive);
            mobileToggle.setAttribute('aria-expanded', isActive ? 'true' : 'false');
            
            // Debug: Check if elements are visible
            if (isActive) {
                console.log('Nav container display:', getComputedStyle(navLinksContainer).display);
                console.log('Nav container opacity:', getComputedStyle(navLinksContainer).opacity);
                console.log('Nav container visibility:', getComputedStyle(navLinksContainer).visibility);
                console.log('Nav container transform:', getComputedStyle(navLinksContainer).transform);
            }
        }

        // Close mobile menu
        function closeMobileMenu() {
            console.log('Close mobile menu called');
            body.classList.remove('mobile-menu-active');
            mobileToggle.setAttribute('aria-expanded', 'false');
            console.log('Mobile menu closed');
        }

        // Event listeners for mobile navigation
        if (mobileToggle) {
            console.log('Mobile toggle button found, adding click listener');
            mobileToggle.addEventListener('click', toggleMobileMenu);
        } else {
            console.warn('Mobile toggle button not found');
        }
        
        if (mobileOverlay) {
            console.log('Mobile overlay found, adding click listener');
            mobileOverlay.addEventListener('click', closeMobileMenu);
        } else {
            console.warn('Mobile overlay not found');
        }
        
        if (navClose) {
            console.log('Nav close button found, adding click listener');
            navClose.addEventListener('click', closeMobileMenu);
        } else {
            console.warn('Nav close button not found');
        }

        // Close menu when clicking a navigation link
        document.querySelectorAll('.profile-nav-links a').forEach(link => {
            link.addEventListener('click', closeMobileMenu);
        });

        // Close menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && body.classList.contains('mobile-menu-active')) {
                closeMobileMenu();
            }
        });

        // Handle window resize
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                if (window.innerWidth >= 992 && body.classList.contains('mobile-menu-active')) {
                    closeMobileMenu();
                }
            }, 250);
        });

        // User dropdown functionality
        document.querySelectorAll('.profile-user-dropdown-toggle').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                var wrapper = btn.closest('.profile-user-dropdown-wrapper');
                document.querySelectorAll('.profile-user-dropdown-wrapper').forEach(function(w) {
                    if (w !== wrapper) w.classList.remove('open');
                });
                wrapper.classList.toggle('open');
            });
        });
        document.addEventListener('click', function() {
            document.querySelectorAll('.profile-user-dropdown-wrapper').forEach(function(w) {
                w.classList.remove('open');
            });
        });
    });
</script>
<script>
$(document).ready(function() {
    // Toggle dropdown when .profile-user-info is clicked
    $('.profile-user-info').on('click', function(e) {
        e.stopPropagation(); // Prevent bubbling to document
        $('.profile-user-dropdown-menu').toggle(); // Toggle menu
    });

    // Hide dropdown if clicked outside
    $(document).on('click', function() {
        $('.profile-user-dropdown-menu').hide();
    });
});
</script>