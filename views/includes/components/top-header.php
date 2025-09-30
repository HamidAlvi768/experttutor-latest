<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- Top Header -->
<header class="profile-top-header">
    <div class="profile-container">
        <div class="profile-header-content">
            <div class="profile-top-nav">
                <a href="login.php" class="profile-nav-link">Sign In</a>
                <a href="support.php" class="profile-nav-link">Support</a>
                <a href="contact.php" class="profile-nav-link">Contact Sales</a>
            </div>
        </div>
    </div>
</header> 