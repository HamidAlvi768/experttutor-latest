<?php
/**
 * Profile Header Configuration
 * 
 * This file provides a configuration for the tutor-header component
 * using the simpler style shown in the second reference image.
 */

// Simple header config with Home, Subjects, Tutor navigation
$header_props = [
    'logo_text' => 'Tutor Expert',
    'logo_link' => 'index.php',
    'nav_items' => [
        ['text' => 'Home', 'url' => 'index.php', 'has_dropdown' => false],
        ['text' => 'Subjects', 'url' => '#', 'has_dropdown' => true],
        ['text' => 'Tutor', 'url' => '#', 'has_dropdown' => true]
    ],
    'show_profile' => false
]; 