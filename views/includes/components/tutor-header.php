<?php

namespace app\controllers;
use Yii;
use app\components\Helper;
?>
<?php
/**
 * Tutor Header Component
 * Flexible header with logo, configurable navigation links, and optional profile section
 * 
 * @param array $header_props {
 *     @type string $logo_text        Logo text (default: 'Tutor Expert')
 *     @type string $logo_link        Logo link URL (default: 'index.php')
 *     @type array  $nav_items        Navigation menu items
 *     @type bool   $show_profile     Whether to show profile section
 *     @type string $profile_name     Profile name text
 *     @type string $profile_image    Profile image URL
 * }
 */

// Default values
$p_imaeg=Helper::baseUrl('custom/images/profiles/profile-placeholder.jpg');
$default_header_props = [
    'logo_text' => 'Tutor Expert',
    'logo_link' => 'index.php',
    'nav_items' => [
        ['text' => 'Home', 'url' => 'index.php', 'has_dropdown' => false],
        ['text' => 'Subjects', 'url' => '#', 'has_dropdown' => true],
        ['text' => 'Tutor', 'url' => '#', 'has_dropdown' => true],
        ['text' => 'Manage Finance', 'url' => '#', 'has_dropdown' => true]
    ],
    'show_profile' => false,
    'profile_name' => 'Profile',
    'profile_image' =>  $p_imaeg
];

// Merge provided props with defaults
$header_props = isset($header_props) ? array_merge($default_header_props, $header_props) : $default_header_props;
?>

<!-- Header Navigation -->
<header class="tutor-expert-header container">
    <div class="tutor-nav-content">
        <div class="tutor-nav-left">
            <a href="<?php echo $header_props['logo_link']; ?>" class="tutor-logo">
                <img src="<?= Helper::baseUrl("/") ?>custom/images/logo-black.png" alt="<?php echo $header_props['logo_text']; ?>" class="tutor-logo-image">
            </a>
            
            <!-- Hamburger Menu Button -->
            <button class="tutor-mobile-toggle" aria-label="Toggle menu" aria-expanded="false">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>

            <!-- Navigation Links Container -->
            <div class="tutor-nav-links-container">
                <!-- Close button for mobile -->
                <button class="tutor-nav-close" aria-label="Close menu">
                    <i class="fas fa-times"></i>
                </button>
                
                <nav class="tutor-nav-links">
                    <ul>
                        <?php foreach ($header_props['nav_items'] as $item): ?>
                            <li class="<?php echo $item['has_dropdown'] ? 'dropdown-nav' : ''; ?>">
                                <a href="<?php echo $item['url']; ?>"><?php echo $item['text']; ?></a>
                                <?php if ($item['text'] === 'Manage Finance'): ?>
                                    <div class="dropdown-menu">
                                        <a href="coin-wallet.php" class="dropdown-item">Coin Wallet</a>
                                        <a href="buy-coin.php" class="dropdown-item">Buy Coin</a>
                                        <a href="add-card.php" class="dropdown-item">Add Card</a>
                                        <a href="invite-friend.php" class="dropdown-item">Invite Friend</a>
                                        <a href="referral.php" class="dropdown-item">Referal</a>
                                    </div>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>

                <?php if ($header_props['show_profile']): ?>
                <!-- Mobile-only profile section -->
                <div class="tutor-user-info mobile-only">
                    <img src="<?php echo $header_props['profile_image']; ?>" alt="Profile" class="tutor-user-pic">
                    <span class="tutor-user-name"><?php echo $header_props['profile_name']; ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if ($header_props['show_profile']): ?>
        <!-- Desktop profile section -->
        <div class="tutor-user-info desktop-only">
            <img src="<?php echo $header_props['profile_image']; ?>" alt="Profile" class="tutor-user-pic">
            <span class="tutor-user-name"><?php echo $header_props['profile_name']; ?></span>
        </div>
        <?php endif; ?>
    </div>
</header>

<!-- Mobile Menu Overlay -->
<div class="tutor-mobile-overlay"></div>

<!-- Include external CSS -->
<link rel="stylesheet" href="<?= Helper::baseUrl("/") ?>custom/css/components/tutor-header.css">

<!-- Include Navigation JS -->
<script src="<?= Helper::baseUrl("/") ?>custom/js/tutor-nav.js"></script> 