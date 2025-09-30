<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\components\Helper;
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
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Assignment Connect - Connect Individuals to Assign</title>
    <?php $this->head() ?>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= Helper::baseUrl("/") ?>custom/css/style.css">
    <link rel="stylesheet" href="<?= Helper::baseUrl("/") ?>custom/css/login-modal.css">
    <link rel="stylesheet" href="<?= Helper::baseUrl("/custom/css/form-card.css") ?>">
    <link rel="stylesheet" href="<?= Helper::baseUrl('/custom/css/tutors.css') ?>">
    
    <!-- Prevent zoom and touch gestures -->
    <style>
        html, body {
            touch-action: manipulation;
            -webkit-touch-callout: none;
            -webkit-tap-highlight-color: transparent;
        }
        
        /* Prevent double-tap zoom on iOS */
        * {
            touch-action: manipulation;
        }
        
        /* Allow text selection by default */
        * {
            -webkit-user-select: text;
            -khtml-user-select: text;
            -moz-user-select: text;
            -ms-user-select: text;
            user-select: text;
        }
        
        /* Prevent text selection on buttons and form elements */
        button, input, textarea, select, .btn, .nav-link, .dropdown-item {
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        
        /* Allow text selection in specific areas if needed */
        .allow-select {
            -webkit-user-select: text;
            -khtml-user-select: text;
            -moz-user-select: text;
            -ms-user-select: text;
            user-select: text;
        }
        
        /* Prevent text selection on navigation and interactive elements */
        nav, .navbar, .dropdown-menu, .modal-header, .modal-footer {
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
    </style>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body class="">
    
    <?php $this->beginBody() ?>

    
    <?= $this->render('/includes/header.php') ?>

    <?= $content ?>

    <?= $this->render('/includes/footer.php') ?>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= Helper::baseUrl("/") ?>custom/js/main.js"></script>
    <script src="<?= Helper::baseUrl("/") ?>custom/js/login-modal.js"></script>
    <script src="<?php echo Helper::baseUrl("/ssets/custom/js/enc.js") ?>"></script>
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

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>