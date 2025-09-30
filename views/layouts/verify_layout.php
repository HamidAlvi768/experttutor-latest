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


$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
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

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= Helper::baseUrl("/") ?>custom/css/verification.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
        <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body class="">
    
    <?php $this->beginBody() ?>

    
    

    <?= $content ?>

  
    

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
        // Handle viewport height for mobile browsers
        function setVH() {
            let vh = window.innerHeight * 0.01;
            document.documentElement.style.setProperty('--vh', `${vh}px`);
        }

        // Set initial viewport height
        setVH();

        // Update viewport height on resize and orientation change
        ['resize', 'orientationchange'].forEach(evt =>
            window.addEventListener(evt, () => {
                setVH();
            })
        );
    </script>


    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>