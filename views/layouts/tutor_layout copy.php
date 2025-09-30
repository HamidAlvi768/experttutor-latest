<?php

namespace app\controllers;
use Yii;
use app\components\Helper;
?>
<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
        
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Dancing+Script:wght@600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= Helper::baseUrl("/") ?>custom/css/utils/utilities.css">
    <link rel="stylesheet" href="<?= Helper::baseUrl("/") ?>custom/css/style.css">
    <link rel="stylesheet" href="<?= Helper::baseUrl("/") ?>custom/css/profile-navigation.css">
    <link rel="stylesheet" href="<?= Helper::baseUrl("/") ?>custom/css/wizard-common.css">

        <link rel="stylesheet" href="<?= Helper::baseUrl("/") ?>custom/css/components/jobs.css">
    <link rel="stylesheet" href="<?= Helper::baseUrl("/") ?>custom/css/components/tutor-hero.css">
    <link rel="stylesheet" href="<?= Helper::baseUrl("/") ?>custom/css/components/tutor-header.css">
    <link rel="stylesheet" href="<?= Helper::baseUrl("/") ?>custom/css/components/job-application.css">

        <link rel="stylesheet" href="<?= Helper::baseUrl("/") ?>custom/css/request-tutor.css">

            


     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

         <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="<?= Helper::baseUrl("/") ?>custom/theme/js/jquery-3.2.1.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/css/intlTelInput.min.css" />


         <style>
        /* Teacher Profile Wizard Specific Styles */
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        
        .wizard-container {
            display: flex;
            min-height: calc(100vh - 150px);
            margin-top: 20px;
            margin-bottom: 20px;
        }
        
        /* Sidebar Styles */
        .wizard-sidebar {
            width: 300px;
            background-color: transparent;
            border-radius: 10px;
            padding: 0;
            margin-right: 20px;
            font-size: large;
        }
        
        .wizard-steps {
            list-style: none;
            padding: 30px 0;
            margin: 0;
            border-right: 1px solid rgba(0, 0, 0, 0.1);
            height: 80%;
        }
        
        .wizard-step-item {
            padding: 22px 30px;
            display: flex;
            align-items: center;
            color: #6c757d;
            position: relative;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .wizard-step-item.active {
            color: #6366F1;
            font-weight: 600;
        }
        
        .wizard-step-item:hover:not(.active) {
            background-color: #f8f9fa;
        }
        
        .wizard-step-item::before {
            content: '•';
            margin-right: 10px;
            font-size: 20px;
        }
        
        /* Main Content Area */
        .wizard-content {
            flex: 1;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            padding: 30px;
        }
        
        /* Form Styles */
        .wizard-form-container {
            max-width: 900px;
            margin: 0 auto;
        }
        
        /* Section Title */
        .wizard-section-title {
            font-size: 24px;
            font-weight: 600;
            color: #1B1B3F;
            margin-bottom: 30px;
        }
        
        /* Form grid for profile fields */
        
        .wizard-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 30px;
        }
        
        .wizard-form-group {
            margin-bottom: 20px;
        }
        
        .subject-form-container {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        
        .subject-form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 1rem;
        }
        
        .subject-label {
            font-size: 16px;
            font-weight: 500;
            color: #1B1B3F;
        }
        
        .level-form-container {
            display: flex;
            gap: 20px;
        }
        
        .level-form-group {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .wizard-form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
            background-color: #F3F3F3;
            /* color: #140489; */
        }
        
        .wizard-form-control:focus {
            border-color: #6366F1;
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.1);
            outline: none;
        }
        
        .wizard-select-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236c757d' viewBox='0 0 16 16'%3E%3Cpath d='M8 10.5a.5.5 0 0 1-.354-.146l-4-4a.5.5 0 0 1 .708-.708L8 9.293l3.646-3.647a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.354.146z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 12px;
            padding-right: 40px;
            color: gray !important;
        }
        
        .subject-select, .level-select {
            background-color: #f8f9fa;
            color: #6c757d;
            height: 50px;
        }
        
        /* Add Subject Button */
        .btn-add-subject {
            background-color: #564FFD;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 250px;
            margin-top: 10px;
        }
        
        .btn-add-subject i {
            font-size: 10px !important;
            margin-left: unset !important;
            border: 2px solid;
            border-radius: 50%;
            padding: 3px;
        }
        
        .btn-add-subject:hover {
            background-color: #4a43e2;
        }
        
        /* Remove Subject Button */
        .btn-remove-subject {
            background-color: #f8f9fa;
            color: #dc3545;
            border: 1px solid #dc3545;
            border-radius: 8px;
            padding: 8px 15px;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
        }
        
        .btn-remove-subject:hover {
            background-color: #feecef;
        }
        
        .subject-section {
            border-top: 1px solid #e9ecef;
            padding-top: 25px;
            margin-top: 10px;
        }
        
        /* Button Styles */
        .wizard-form-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 50px;
            gap: 15px;
        }
        
        .btn-save {
            background-color: white;
            color: #6366F1;
            border: 1px solid #6366F1;
            padding: 10px 40px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-save:hover {
            background-color: rgba(99, 102, 241, 0.05);
        }
        
        .btn-next {
            background-color: #6366F1;
            color: white;
            border: none;
            padding: 10px 40px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-next:hover {
            background-color: #5152e2;
        }
        
        /* Responsive Styles */
        @media (max-width: 992px) {
            .level-form-container {
                flex-direction: column;
                gap: 15px;
            }
        }
        
        @media (max-width: 768px) {
            .wizard-container {
                flex-direction: column;
            }
            
            .wizard-sidebar {
                width: 100%;
                margin-right: 0;
                margin-bottom: 20px;
            }
            
            .wizard-steps {
                border-right: none;
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
                height: auto;
                padding: 15px 0;
            }
        }
        
        /* Photo Upload Styles */
        .profile-photo-upload {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-bottom: 30px;
            gap: 0.8rem;
        }
        
        .profile-photo-placeholder {
            width: 150px;
            height: 150px;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 15px;
            position: relative;
            background-color: #f0f1ff;
            cursor: pointer;
            background: linear-gradient(135deg, #c471ed, #8a3cda);
        }
        
        .profile-photo-placeholder img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.3s ease;
        }
        
        .upload-your-photo {
            font-size: 15px;
            color: black;
            margin-top: 10px;
        }
    .help-block{
        color:red
    }
    </style>
   
</head>

<body class="request-tutor-page" style="background-color: #fafafa;">


    <?php $this->beginBody() ?>

    <?php /* $this->render('_tutor_header') */?>
    <?php //$this->render('/includes/components/top-header.php') ?>
        <!-- Main Navigation -->

    <!-- TUTOR layout  -->
     <?php if( Yii::$app->user->identity->role=='tutor'){?>
    <?= $this->render('/includes/components/main-nav.php') ?>
    <?php }else{ ?>
    <?= $this->render('/includes/components/main-nav-student.php') ?>
    <?php } ?>

    <?= $content ?>

 <!-- Footer -->
  <?php /* $this->render('/includes/footer.php')  */ ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Navigation JS -->
    <script src="<?= Helper::baseUrl("/") ?>custom/js/profile-nav.js"></script>
        <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <?php
    $flashes = Yii::$app->session->getAllFlashes();
    if (!empty($flashes)) {
        $js = '';
        foreach ($flashes as $type => $message) {
            $toastType = $type === 'error' ? 'error' : ($type === 'success' ? 'success' : ($type === 'info' ? 'info' : 'warning'));
            $js .= "toastr['{$toastType}'](" . json_encode($message) . ");\n";
        }
        $this->registerJs($js, \yii\web\View::POS_READY);
    }
    ?>

    <script>
        var oldTitle = document.title;

        function sendLogTime(data) {
            if (typeof fetch === 'function') {
                // Use Fetch API with keepalive to send data during unload
                fetch('/log-user-leaving', {
                    method: 'POST',
                    body: data,
                    keepalive: true,
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
            } else {
                // Fallback for browsers without fetch support
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/log-user-leaving', false); // Synchronous request
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.send(data);
            }
        }
        document.addEventListener("visibilitychange", () => {
            if (document.hidden) {
                document.title = "Closed";
                // Prepare the data to send
                const data = JSON.stringify({
                    message: 'User left the page',
                    timestamp: Date.now()
                });
                sendLogTime(data);

            } else {
                document.title = "Opened";
            }
        })
        // window.addEventListener('beforeunload', function(event) {
        //     event.returnValue = 'Are you sure you want to leave?'; // Triggers dialog
        // });

        window.addEventListener('unload', function(event) {
            // Prepare the data to send
            const data = JSON.stringify({
                message: 'User left the page',
                timestamp: Date.now()
            });
            sendLogTime(data);
        });
    </script>
    
    <script>
        // Make sidebar steps clickable
        document.addEventListener('DOMContentLoaded', function() {
            const stepItems = document.querySelectorAll('.wizard-step-item');
            
            stepItems.forEach(item => {
                item.addEventListener('click', function() {
                    const step = this.getAttribute('data-step');
                    if (step) {
                        window.location.href = 'teacher-profile-wizard.php?step=' + step;
                    }
                });
            });
        });
    </script>

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/utils.js"></script>
<script>
 const input = document.querySelector("#phone");
const form = input.form;

// initialize intl-tel-input
const iti = window.intlTelInput(input, {
  initialCountry: "auto",
  nationalMode: false,
  formatOnDisplay: true,
  utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
});

// clear existing error
function clearError() {
  const helpBlock = document.querySelector("#phone").closest('.form-group').querySelector('.help-block');
  helpBlock.textContent = "";
  document.querySelector("#phone").classList.remove("is-invalid"); // Optional Bootstrap class
}

// show error in help-block
function showError(message) {
  const helpBlock = document.querySelector("#phone").closest('.form-group').querySelector('.help-block');
  helpBlock.textContent = message;
  document.querySelector("#phone").classList.add("is-invalid"); // Optional Bootstrap class
}

form.addEventListener("submit", function (e) {
  clearError();

  if (!iti.isValidNumber()) {
    e.preventDefault(); // prevent form submission
    showError("Invalid phone number");
    return false;
  }

  // If valid, get full number and set it back to input if needed
  const fullNumber = iti.getNumber(); // e.g., +923405870886
  input.value = fullNumber;

    return true; // allow form submission
});

</script>
    <?php $this->endBody() ?>
 
</body>

</html>
<?php $this->endPage() ?>