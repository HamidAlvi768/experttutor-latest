<?php
/**
 * Base template for coin-related pages
 * 
 * Required variables before including this template:
 * $page_title - The title of the page
 * $header_props - Header component properties
 */

// Ensure required variables are set
if (!isset($page_title)) {
    $page_title = 'Tutor Expert';
}

if (!isset($header_props)) {
    $header_props = [
        'logo_text' => 'Tutor Expert',
        'logo_link' => 'index.php',
        'nav_items' => [
            ['text' => 'Profile', 'url' => 'profile.php', 'has_dropdown' => false],
            ['text' => 'Messages', 'url' => 'messages.php', 'has_dropdown' => false],
            ['text' => 'Delivery Work', 'url' => 'delivery.php', 'has_dropdown' => false],
            ['text' => 'Manage Finance', 'url' => 'finance.php', 'has_dropdown' => true],
            ['text' => 'Reviews', 'url' => 'reviews.php', 'has_dropdown' => false],
        ],
        'show_profile' => true,
        'profile_name' => 'John Smith',
        'profile_image' => 'custom/images/profiles/teacher-2.png'
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?php echo $page_title; ?> - Tutor Expert</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="custom/css/style.css">
    <link rel="stylesheet" href="custom/css/components/tutor-header.css">
    <link rel="stylesheet" href="custom/css/components/base-coin.css">
    <?php if (isset($additional_css)): ?>
        <?php foreach ($additional_css as $css): ?>
            <link rel="stylesheet" href="<?php echo $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body class="coin-page <?php echo isset($page_class) ? $page_class : ''; ?>">
    <!-- Background Hero Section -->
    <div class="coin-hero">
        <div class="overlay"></div>
    </div>

    <!-- Main Content Wrapper -->
    <div class="main-content-wrapper">
        <!-- Top Header -->
        <div class="top-header">
            <div class="container">
                <div class="d-flex justify-content-end">
                    <a href="#" class="top-link">Sign In</a>
                    <a href="#" class="top-link">Support</a>
                    <a href="#" class="top-link">Contact Sales</a>
                </div>
            </div>
        </div>

        <!-- Include the tutor-header component -->
        <div class="container header-container coin-header">
            <?php include 'includes/components/tutor-header.php'; ?>
        </div>
        
        <!-- Hero Content -->
        <div class="container hero-content-container">
            <div class="hero-content">
                <?php 
                // This is where the custom content for each page will go
                if (isset($hero_content)) {
                    include $hero_content;
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php if (isset($additional_scripts)): ?>
        <?php foreach ($additional_scripts as $script): ?>
            <script src="<?php echo $script; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html> 