<?php
/**
 * Example of using the tutor-hero component with the info panel enabled
 * This shows how to implement the layout seen in the second reference image
 */

// Mock data - in a real implementation, this would come from your database
$tutorData = [
    'first_name' => 'Bryan',
    'last_name' => 'Eigensection',
    'description' => "Hello,\nMy name is Christopher. I'm a student tutor with a passion for Mathematics and teaching young students. I'm young and vibrant with a passion for teaching and impacting knowledge to students",
    'image' => 'assets/images/profiles/teacher-1.jpg'
];

// Set up props for tutor-hero component with info panel enabled
$profile_props = [
    'layout_type' => 'full',
    'background_image' => 'assets/images/tutor-summary-bg.jpg',
    'show_info_panel' => true, // Enable the info panel
    'profile' => [
        'first_name' => $tutorData['first_name'],
        'last_name' => $tutorData['last_name'],
        'description' => $tutorData['description'],
        'image' => $tutorData['image']
    ],
    'actions' => [
        'buttons' => [
            ['text' => 'Message', 'class' => 'btn-message', 'type' => 'button'],
            ['text' => 'Call', 'class' => 'btn-call', 'type' => 'button'],
            ['text' => 'Review(4.9)', 'class' => 'btn-review', 'type' => 'button']
        ]
    ],
    'info_panel' => [
        [
            'icon' => 'fas fa-map-marker-alt',
            'label' => 'Location',
            'value' => 'Prince and Princess Estate, Kaura, Abuja, Nigeria'
        ],
        [
            'icon' => 'fas fa-car',
            'label' => 'Can travel',
            'value' => 'No'
        ],
        [
            'icon' => 'far fa-clock',
            'label' => 'Last login',
            'value' => '4 mins ago'
        ],
        [
            'icon' => 'fas fa-user-check',
            'label' => 'Registered',
            'value' => '1 hour ago'
        ],
        [
            'icon' => 'fas fa-chalkboard-teacher',
            'label' => 'Total Teaching exp',
            'value' => '2.0 yrs'
        ],
        [
            'icon' => 'fas fa-wifi',
            'label' => 'Teaches online',
            'value' => 'Yes'
        ],
        [
            'icon' => 'fas fa-laptop',
            'label' => 'Online Teaching exp',
            'value' => '0.5 yrs'
        ],
        [
            'icon' => 'fas fa-home',
            'label' => 'Teaches at student\'s home',
            'value' => 'No'
        ],
        [
            'icon' => 'fas fa-book',
            'label' => 'Homework Help',
            'value' => 'Yes'
        ],
        [
            'icon' => 'fas fa-venus-mars',
            'label' => 'Gender',
            'value' => 'Male'
        ],
        [
            'icon' => 'fas fa-user-tie',
            'label' => 'Works as',
            'value' => 'Individual teacher'
        ],
        [
            'icon' => 'fas fa-language',
            'label' => 'Speaks',
            'value' => 'English'
        ]
    ]
];

// This is just for demonstration purposes - in a real implementation, 
// you would include this in a full HTML page structure
include 'includes/components/tutor-hero.php';
?> 