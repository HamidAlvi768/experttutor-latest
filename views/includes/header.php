<?php

use app\components\Helper;
use app\models\GeneralSetting;
use yii\helpers\Html;

?>
<?php
// Only start session if one hasn't been started already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$site_setting = GeneralSetting::find()->one();


// Default logo settings if not provided
$logo_src = !empty($site_setting->site_logo) ? Helper::baseUrl('/') . $site_setting->site_logo : Helper::baseUrl() . "custom/images/logo.png";
$logo_alt = !empty($site_setting->site_name) ? $site_setting->site_name : 'Assignment Connect';
?>
<style>
    @media (max-width: 991px) {
        #navbarMain {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
            /* box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); */
        }

        /* Mobile-specific dropdown styling */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            margin-top: 0.5rem;
        }

        /* Role switching section styling */
        .dropdown-item[href="#"] {
            color: var(--text-dark);
            font-weight: 400;
        }

        /* Role switch buttons styling */
        .dropdown-item[href*="switch-role"] {
            padding: 0.75rem 1rem;
            transition: background-color 0.2s ease;
        }

        .dropdown-item[href*="switch-role"]:hover {
            background-color: #e9ecef;
        }

        /* Divider styling */
        .dropdown-divider {
            margin: 0.5rem 0;
            border-color: #dee2e6;
        }

        /* Logout button styling */
        .dropdown-item.logout {
            color: #dc3545;
            font-weight: 500;
        }

        .dropdown-item.logout:hover {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Auth button mobile optimization */
        .auth .btn {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }

        /* Ensure dropdown is properly positioned on mobile */
        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            right: 0;
            left: auto;
            min-width: 200px;
        }
    }

    /* Desktop styling improvements */
    @media (min-width: 992px) {
        .dropdown-menu {
            min-width: 220px;
        }

        .dropdown-item[href="#"] {
            color: var(--text-dark);
            font-weight: 400;
        }

        .dropdown-item[href*="switch-role"]:hover {
            background-color: #e9ecef;
        }
    }
    .navbar-nav{
            margin-left: 0;
    white-space: nowrap;
    }
</style>

<header class="main-header">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="<?php echo Helper::baseUrl() ?>">
                <img src="<?php echo htmlspecialchars($logo_src); ?>" style="max-height: 65px;" alt="<?= $logo_alt ?>" class="logo">
            </a>
            <!-- Hamburger Menu Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Collapsible Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarMain">
                <!-- Main Navigation Links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo Helper::baseUrl() ?>">Home</a>
                    </li>
                    <!-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="subjectsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Subjects
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="subjectsDropdown">
                            <li><a class="dropdown-item" href="#">Mathematics</a></li>
                            <li><a class="dropdown-item" href="#">Science</a></li>
                            <li><a class="dropdown-item" href="#">English</a></li>
                            <li><a class="dropdown-item" href="#">History</a></li>
                        </ul>
                    </li> --><?php /*?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="tutorDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Tutor
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="tutorDropdown">
                            <li><a class="dropdown-item" href="<?php echo Helper::baseUrl("/tutors") ?>">Find a Tutor</a></li>
                            
                            <li><a class="dropdown-item" href="<?php echo Helper::baseUrl("/tutor/profile") ?>">Become a Tutor</a></li>
                            <li><a class="dropdown-item" href="<?php echo Helper::baseUrl("/post/create") ?>">Request a Tutor</a></li>
                            
                        </ul>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo Helper::baseUrl("/tutors") ?>">Find a Tutor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo Helper::baseUrl("/about") ?>">About Us</a>
                    </li>
                    </li><?php */?>
                    
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo Helper::baseUrl("/signup?tutor") ?>">Register as a Tutor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo Helper::baseUrl("/signup?student") ?>">Register as a Student</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo Helper::baseUrl("/faq") ?>">FAQ</a>
                    </li>
                    

                    
                </ul>
                <!-- Login Button -->



                <ul class="navbar-nav">
                    <li class="nav-item">
                        <div class="auth">
                            <?php if (Yii::$app->user->isGuest): ?>
                                <a class="btn btn-primary w-100 " href="<?php Helper::baseUrl("") ?>login">Login</a>
                            <?php else: ?>
                                <div class="dropdown">


                                    <a class="btn btn-primary w-100 dropdown-toggle" href="#" id="menuDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= Yii::$app->user->identity->username ?> (<small class="text-white"><?= Yii::$app->user->identity->role ?></small>)</a>

                                    <ul class="dropdown-menu w-100" aria-labelledby="menuDropdown">
                                        <!-- <li><hr class="dropdown-divider"></li> -->

                                        <?php /* if (Yii::$app->user->identity->role == "student"): ?>
                            <li><a class="dropdown-item" href="<?php echo Helper::baseUrl("/profile/edit") ?>">Profile</a></li>
                        
                            <li><a class="dropdown-item" href="<?php echo Helper::baseUrl("/peoples") ?>">Messages</a></li>
                            <li><a class="dropdown-item" href="<?php echo Helper::baseUrl("/post/list") ?>">Post Jobs</a></li>

                            <li><hr class="dropdown-divider"></li>
                            <!-- Role Switching Section -->
                            <li><a class="dropdown-item" href="#">Switch To Tutor</a></li>
                            
                            <?php elseif (Yii::$app->user->identity->role == "tutor"): ?>
                            <li><a class="dropdown-item" href="<?php echo Helper::baseUrl("/tutor/dashboard") ?>">Dashboard</a></li>
                            <li><a class="dropdown-item" href="<?php echo Helper::baseUrl("/tutor/wallet") ?>">Wallet</a></li>
                            <li><a class="dropdown-item" href="<?php echo Helper::baseUrl("/tutor/profile") ?>">Profile</a></li>
                            <li><a class="dropdown-item" href="<?php echo Helper::baseUrl("/tutor/profile") ?>">Edit Profile</a></li>
                            <li><a class="dropdown-item" href="<?php echo Helper::baseUrl("/peoples") ?>">Peoples & Messages</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <!-- Role Switching Section -->
                            <li><a class="dropdown-item" href="#">Switch To Student</a></li><?php */ ?>
                                        <?php $role = Yii::$app->user->identity->role ?>


                                        <?php if ($role === 'student'): ?>


                                            <li><a class="dropdown-item" href="<?php echo Helper::baseUrl("/post/list") ?>">Dashboard</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>


                                            <li><a class="dropdown-item" href="<?= \yii\helpers\Url::to(['site/switch-role', 'role' => 'tutor']) ?>">Switch to Tutor</a></li>



                                        <?php elseif ($role === 'tutor'): ?>
                                            
                                            <li><a class="dropdown-item" href="<?php echo Helper::baseUrl("/tutor/dashboard") ?>">Dashboard</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>

                                            <li><a class="dropdown-item" href="<?= \yii\helpers\Url::to(['site/switch-role', 'role' => 'student']) ?>">Switch to Student</a></li>



                                        <?php elseif (Yii::$app->user->identity->role == "superadmin"): ?>

                                            <li><a class="dropdown-item" href="<?php echo Helper::baseUrl("/admin/dashboard") ?>">Dashboard</a></li>

                                        <?php endif; ?>

                                        <li>
                                            <?php
                                            echo Html::beginForm(['/logout'], 'post');
                                            echo Html::submitButton(
                                                'Logout',
                                                ['class' => 'btn btn-link dropdown-item logout']
                                            );
                                            echo Html::endForm();
                                            ?>
                                        </li>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile dropdown enhancement
        const dropdownToggle = document.querySelector('#menuDropdown');
        const dropdownMenu = document.querySelector('.dropdown-menu');

        if (dropdownToggle && dropdownMenu) {
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownToggle.classList.remove('show');
                    dropdownMenu.classList.remove('show');
                }
            });

            // Handle mobile touch events
            if ('ontouchstart' in window) {
                dropdownToggle.addEventListener('touchstart', function(e) {
                    e.preventDefault();
                    dropdownToggle.classList.toggle('show');
                    dropdownMenu.classList.toggle('show');
                });
            }

            // Ensure dropdown closes on role switch
            const roleSwitchLinks = document.querySelectorAll('a[href*="switch-role"]');
            roleSwitchLinks.forEach(link => {
                link.addEventListener('click', function() {
                    // Close dropdown after role switch
                    setTimeout(() => {
                        dropdownToggle.classList.remove('show');
                        dropdownMenu.classList.remove('show');
                    }, 100);
                });
            });
        }

        // Add visual feedback for role switching
        const currentRole = '<?php //Yii::$app->user->identity->role ?? "" ?>';
        if (currentRole) {
            const roleSwitchLinks = document.querySelectorAll('a[href*="switch-role"]');
            roleSwitchLinks.forEach(link => {
                if (link.href.includes(currentRole.toLowerCase())) {
                    link.style.opacity = '0.5';
                    link.style.pointerEvents = 'none';
                    link.innerHTML += ' (Current)';
                }
            });
        }
    });
</script> -->