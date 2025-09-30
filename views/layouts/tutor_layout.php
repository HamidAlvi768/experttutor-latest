<?php

namespace app\controllers;

use Yii;
use app\components\Helper;
?>
<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\BaseUrl;

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
    <link rel="stylesheet" href="<?= Helper::baseUrl('/') ?>custom/css/utils/utilities.css">
    <link rel="stylesheet" href="<?= Helper::baseUrl('/') ?>custom/css/style.css">
    <link rel="stylesheet" href="<?= Helper::baseUrl('/') ?>custom/css/profile-navigation.css">
    <link rel="stylesheet" href="<?= Helper::baseUrl('/') ?>custom/css/wizard-common.css">
    <link rel="stylesheet" href="<?= Helper::baseUrl('/') ?>custom/css/components/jobs.css">
    <link rel="stylesheet" href="<?= Helper::baseUrl('/') ?>custom/css/components/tutor-hero.css">
    <link rel="stylesheet" href="<?= Helper::baseUrl('/') ?>custom/css/components/tutor-header.css">
    <link rel="stylesheet" href="<?= Helper::baseUrl('/') ?>custom/css/components/job-application.css">
    <link rel="stylesheet" href="<?= Helper::baseUrl('/') ?>custom/css/request-tutor.css">
    <link rel="stylesheet" href="<?= Helper::baseUrl('/custom/css/tutors.css') ?>">



    <!-- IntlTelInput CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/css/intlTelInput.min.css">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- jQuery (required for ActiveForm and intl-tel-input) -->
    <script src="<?= Helper::baseUrl('/') ?>custom/theme/js/jquery-3.2.1.min.js"></script>


       <?php
$this->registerCssFile('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>



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

        .wizard-section-title {
            font-size: 24px;
            font-weight: 600;
            color: #1B1B3F;
            margin-bottom: 30px;
        }

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
            font-size: clamp(0.75rem, 2vw, 1rem);
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

        .subject-select,
        .level-select {
            background-color: #f8f9fa;
            color: #6c757d;
            height: 50px;
        }

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

        .help-block {
            color: red;
        }

        .iti {
            width: 100%;
        }

        .profile-main-nav {
            z-index: 999 !important;
        }
        
    .star-rating {
        font-size: 24px;
        cursor: pointer;
        text-align: center;
        margin-bottom: 1rem;
    }

    .star-rating i {
        color: #ccc;
        transition: color 0.3s;
    }

    .star-rating i.active {
        color: #ffd700;
    }
    /* Adds red asterisk to all required Yii2 labels */
.form-group.required > label::after {
    content: " *";
    color: red;
}

/* Select 2 css */


.select2-container--default .select2-selection--single {
    height: 52px !important;
    padding: 0 20px !important;
    border: 1px solid var(--request-tutor-border) !important;
    border-radius: 8px !important;
    font-size: 15px !important;
    color: var(--request-tutor-text-dark) !important;
    background-color: var(--request-tutor-white) !important;
    display: flex;
    align-items: center;
}

/* Remove the extra arrow box styling */
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 100% !important;
    right: 15px !important;
}

/* Match text style */
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: normal !important;
    color: var(--request-tutor-text-dark) !important;
    padding-left: 0 !important;
}

/* Style the Select2 dropdown search bar */
.select2-container .select2-search--dropdown .select2-search__field {
    height: 42px;
    padding: 0 15px;
    border: 1px solid var(--request-tutor-border);
    border-radius: 6px;
    font-size: 15px;
    width: 100% !important;
    box-sizing: border-box;
    color: var(--request-tutor-text-dark);
    outline: none;
    transition: all 0.3s ease;
}

/* On focus */
.select2-container .select2-search--dropdown .select2-search__field:focus {
    border-color: #4a90e2; /* highlight color */
    box-shadow: 0 0 5px rgba(74, 144, 226, 0.3);
}

div:where(.swal2-container).swal2-center>.swal2-popup{
    width: 550px !important;
    border-top: 14px solid var(--primary-color);
    border-bottom: 5px solid var(--success-color);
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

.profile-user-dropdown-menu {

    min-width:200px !important;

}




    </style>
</head>

<body class="request-tutor-page" style="background-color: #fafafa;">
    <?php $this->beginBody() ?>

    <?php if (Yii::$app->user->identity->role == 'tutor' || Yii::$app->user->identity->role == 'student'  ): ?>
        <?= $this->render('/includes/components/main-nav.php') ?>
    <?php endif; /*?>
        <?= $this->render('/includes/components/main-nav-student.php') ?>
    <?php endif; */ ?>

    <?= $content ?>



    <!-- Review Modal -->
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">We Value Your Feedback!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Please rate your experience</p>
                    <div class="star-rating">
                        <i class="fa fa-star" data-value="1" role="button" aria-label="1 star"></i>
                        <i class="fa fa-star" data-value="2" role="button" aria-label="2 stars"></i>
                        <i class="fa fa-star" data-value="3" role="button" aria-label="3 stars"></i>
                        <i class="fa fa-star" data-value="4" role="button" aria-label="4 stars"></i>
                        <i class="fa fa-star" data-value="5" role="button" aria-label="5 stars"></i>
                    </div>
                    <form id="reviewForm" method="post">

                        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                        <input type="hidden" name="job_id" id="job_id">
                        <input type="hidden" name="rating" id="rating">
                        <input type="hidden" name="role" id="review_role">

                        <div class="mb-3">
                            <textarea class="form-control" name="review_message" rows="8" placeholder="Write your feedback..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-submit w-100">Submit Feedback</button>
                    </form>


                </div>
            </div>
        </div>
    </div>


    <script>
 $(document).ready(function () {
    const stars = $(".star-rating i");
    let selectedRating = 0;

    // Star click
    stars.on("click", function () {
        selectedRating = $(this).data("value");
        $("#rating").val(selectedRating);
        stars.removeClass("active");
        stars.slice(0, selectedRating).addClass("active");
    });

    // Star hover
    stars.on("mouseover", function () {
        let hoverValue = $(this).data("value");
        stars.removeClass("active");
        stars.slice(0, hoverValue).addClass("active");
    }).on("mouseout", function () {
        stars.removeClass("active");
        stars.slice(0, selectedRating).addClass("active");
    });

    // Set job_id when modal opens
    $('#reviewModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        $('#job_id').val(button.data('job-id'));
    });

        // Set job_id when modal opens
    $('#reviewModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        $('#review_role').val(button.data('role'));
    });


    // AJAX submit
    $('#reviewForm').on('submit', function (e) {
        e.preventDefault();

        if (selectedRating === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Please select a rating',
                text: 'Choose a star rating before submitting.',
            });
            return;
        }

        $.ajax({
            url: "<?= Helper::baseUrl('/post/review') ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    $('#reviewModal').modal('hide');

                    var jobId = $('#job_id').val();
                    var reviewBtn = $('[data-job-id="' + jobId + '"]');
                    reviewBtn.text('Reviewed')
                             .removeClass('btn-primary')
                             .addClass('btn-success ')
                             .prop('data-bs-target', null);

                   
                    toastr.success("Review submitted successfully!");
                } else {
                    toastr.error(response.message || "Failed to submit review.");
                }
            },
            error: function () {
                toastr.error("An error occurred. Please try again.");
            }
        });
    });
});

    </script>





    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- IntlTelInput JS -->
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/intlTelInput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/utils.js"></script>

    <script async
  src="https://maps.googleapis.com/maps/api/js?key=<?= Yii::$app->params['google_map_api'] ?>&libraries=places&callback=initAutocomplete">
</script>

 
    <script>
        // Toastr flash messages
        const BASE_URL = "<?= Helper::BaseUrl('log-user-leaving') ?>";

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

        // Page visibility and unload logging
        var oldTitle = document.title;

        // function sendLogTime(data) {
        //     if (typeof fetch === 'function') {
        //         fetch(`${BASE_URL}`, {
        //             method: 'POST',
        //             body: data,
        //             keepalive: true,
        //             headers: {
        //                 'Content-Type': 'application/json'
        //             }
        //         });
        //     } else {
        //         const xhr = new XMLHttpRequest();
        //         xhr.open('POST', `${BASE_URL}`, false);
        //         xhr.setRequestHeader('Content-Type', 'application/json');
        //         xhr.send(data);
        //     }
        // }

        function sendLogTime(data) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (typeof fetch === 'function') {
                fetch(`${BASE_URL}`, {
                    method: 'POST',
                    body: JSON.stringify(data),
                    keepalive: true,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': csrfToken
                    }
                });
            } else {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', `${BASE_URL}`, false);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader('X-CSRF-Token', csrfToken);
                xhr.send(JSON.stringify(data));
            }
        }


        document.addEventListener("visibilitychange", () => {
            if (document.hidden) {
                document.title = "Closed";
                const data = JSON.stringify({
                    message: 'User left the page',
                    timestamp: Date.now()
                });
                sendLogTime(data);
            } else {
                document.title = "Opened";
            }
        });

        window.addEventListener('unload', function(event) {
            const data = JSON.stringify({
                message: 'User left the page',
                timestamp: Date.now()
            });
            sendLogTime(data);
        });

        // Sidebar navigation
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

        // IntlTelInput phone number validation
        $(document).ready(function() {
            const input = document.querySelector("#phone");
            if (input) {
                const iti = window.intlTelInput(input, {
                    initialCountry: "us",
                    nationalMode: false,
                    formatOnDisplay: false,
                    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@17/build/js/utils.js"
                });

                // Clear existing error
                function clearError() {
                    const helpBlock = input.closest('.form-group').querySelector('.help-block');
                    if (helpBlock) {
                        helpBlock.textContent = "";
                    }
                    input.classList.remove("is-invalid");
                }

                // Show error
                function showError(message) {
                    const helpBlock = input.closest('.form-group').querySelector('.help-block');
                    if (helpBlock) {
                        helpBlock.textContent = message;
                    }
                    input.classList.add("is-invalid");
                }

                // Integrate with ActiveForm beforeSubmit
                $('#profile-form').on('beforeSubmit', function(e) {
                    clearError();

                    if (!iti.isValidNumber()) {
                        showError("Invalid phone number");
                        return false; // Prevent form submission
                    }

                    // Set the full international number
                    input.value = iti.getNumber();
                    return true; // Allow form submission
                });
            }
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
                    width: '400px',
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





    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>