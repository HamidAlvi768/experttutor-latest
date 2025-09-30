<?php
// Start session
session_start();

// Initialize response array
$response = [
    'success' => false,
    'message' => '',
    'data' => []
];

// Check if wizard_data exists in session, if not create it
if (!isset($_SESSION['wizard_data'])) {
    $_SESSION['wizard_data'] = [];
}

// Get the current step from session
$currentStep = isset($_SESSION['current_wizard_step']) ? $_SESSION['current_wizard_step'] : '';

if (empty($currentStep)) {
    $response['message'] = 'Current step not found in session';
    echo json_encode($response);
    exit;
}

// Initialize step data if not exists
if (!isset($_SESSION['wizard_data'][$currentStep])) {
    $_SESSION['wizard_data'][$currentStep] = [];
}

// Process POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Remove some internal values that shouldn't be saved
    unset($_POST['_method']);
    unset($_POST['_token']);
    
    // Handle additional subjects for subject-teach step
    if ($currentStep === 'subject-teach' && isset($_POST['additional_subjects'])) {
        $additionalSubjectsJson = $_POST['additional_subjects'];
        unset($_POST['additional_subjects']);
        
        $additionalSubjects = json_decode($additionalSubjectsJson, true);
        if (is_array($additionalSubjects)) {
            $_SESSION['wizard_data'][$currentStep]['additional_subjects'] = $additionalSubjects;
        }
    }
    
    // Save all other form fields
    foreach ($_POST as $key => $value) {
        $_SESSION['wizard_data'][$currentStep][$key] = $value;
    }
    
    // Handle file uploads if present
    if (!empty($_FILES)) {
        foreach ($_FILES as $key => $file) {
            if ($file['error'] === UPLOAD_ERR_OK) {
                // Define upload directory (create if it doesn't exist)
                $uploadDir = '../../uploads/wizard/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                // Generate unique filename
                $filename = uniqid() . '_' . basename($file['name']);
                $uploadPath = $uploadDir . $filename;
                
                // Move the uploaded file
                if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    $_SESSION['wizard_data'][$currentStep][$key . '_path'] = 'uploads/wizard/' . $filename;
                }
            }
        }
    }
    
    // Success response
    $response['success'] = true;
    $response['message'] = 'Data saved successfully';
    $response['data'] = $_SESSION['wizard_data'][$currentStep];
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response); 