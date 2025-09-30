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

        <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">



</head>

<body class="">
    
    <?php $this->beginBody() ?>

    
    

    <?= $content ?>

  
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= Helper::baseUrl("/") ?>custom/js/main.js"></script>
    <script src="<?= Helper::baseUrl("/") ?>custom/js/login-modal.js"></script>
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