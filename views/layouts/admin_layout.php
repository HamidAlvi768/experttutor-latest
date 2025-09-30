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

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= Helper::baseUrl("/") ?>custom/theme/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= Helper::baseUrl("/") ?>custom/theme/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?= Helper::baseUrl("/") ?>custom/theme/css/style.css">
        <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="<?= Helper::baseUrl("/") ?>custom/theme/js/jquery-3.2.1.min.js"></script>

        <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

           <?php
$this->registerCssFile('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<style>
    @media only screen and (max-width: 991.98px) {
    .sidebar.opened{
         margin-left: 0 !important; 
    
    }
}
/* Adds red asterisk to all required Yii2 labels */
.form-group.required > label::after {
    content: " *";
    color: red;
}
@container swal2-popup style(--swal2-icon-animations: true) {
    div:where(.swal2-icon).swal2-question.swal2-icon-show {
        border-color: hsl(126, 70%, 80%) !important;
    }
}
@container swal2-popup style(--swal2-icon-animations: true) {
    div:where(.swal2-icon).swal2-question.swal2-icon-show .swal2-icon-content {
color:#09B31A !important;    }
}

</style>
</head>

<body class="" style="background-color: #fafafa;">


    <?php $this->beginBody() ?>

    <?= $this->render('_admin_header') ?>
    <div class="main-wrapper">
       
    <?= $content ?>
    </div>

    <?php $this->endBody() ?>
    	<script src="<?= Helper::baseUrl("/") ?>custom/theme/js/popper.min.js"></script>
    <script src="<?= Helper::baseUrl("/") ?>custom/theme/js/bootstrap.min.js"></script>
    <script src="<?= Helper::baseUrl("/") ?>custom/theme/js/jquery.slimscroll.js"></script>
    <script src="<?= Helper::baseUrl("/") ?>custom/theme/js/Chart.bundle.js"></script>
    <!-- <script src="<?= Helper::baseUrl("/") ?>custom/theme/js/chart.js"></script> -->
    <script src="<?= Helper::baseUrl("/") ?>custom/theme/js/app.js"></script>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// 1. PREVENT DEFAULT CONFIRM FLASH
// Override native confirm immediately
window.confirm = function(message) {
    // This is just a placeholder to prevent native confirm
    //console.warn('Native confirm prevented. Use SweetAlert2 instead.');
    return false;
};

// 2. INLINE CONFIRM HANDLER (WITHOUT FLASH)
document.addEventListener('click', function(e) {
    const target = e.target;
    const onclick = target.getAttribute('onclick');
    
    // Check if this is an inline confirm with location.href
    if (onclick && onclick.includes('confirm(') && onclick.includes('location.href')) {
        e.preventDefault();
        e.stopImmediatePropagation();
        
        // Remove the onclick to prevent native execution
        target.removeAttribute('onclick');
        
        // Extract the confirmation message
        const messageMatch = onclick.match(/confirm\(['"]([^'"]+)['"]\)/);
        if (!messageMatch) return;
        const message = messageMatch[1];
        
        // Extract the URL
        const urlMatch = onclick.match(/window\.location\.href\s*=\s*['"]([^'"]+)['"]/);
        if (!urlMatch) return;
        const url = urlMatch[1];
        
        // Show SweetAlert2 confirmation
        Swal.fire({
            title: 'Confirm',
            text: message,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#09B31A',
            cancelButtonColor: '#564FFD',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            } else {
                // Restore onclick if user cancels
                target.setAttribute('onclick', onclick);
            }
        });
    }
});

// 3. YII2 DATA-CONFIRM HANDLER
$(document).on('click', '[data-confirm]', function(e) {
    e.preventDefault();
    const $this = $(this);
    const message = $this.data('confirm');
    const href = $this.attr('href');
    const isPost = $this.data('method') === 'post';
    
    Swal.fire({
        title: 'Confirm',
        text: message,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#09B31A',
        cancelButtonColor: '#564FFD',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            if (isPost) {
                // Create hidden form for POST request
                const $form = $('<form>', {
                    method: 'POST',
                    action: href,
                    style: 'display:none'
                });
                
                // Add CSRF token
                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                if (csrfToken) {
                    $form.append($('<input>', {
                        type: 'hidden',
                        name: '_csrf',
                        value: csrfToken
                    }));
                }
                
                $('body').append($form);
                $form.submit();
            } else {
                window.location.href = href;
            }
        }
    });
});
</script>
</body>

</html>
<?php $this->endPage() ?>