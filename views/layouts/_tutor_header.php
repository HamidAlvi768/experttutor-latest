<?php

use app\components\Helper;
use yii\helpers\Html;

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

.swal2-question, .swal2-icon {
    display: none !important;
}

/* .swal2-confirm:first-of-type {
    background-color: var(--primary-color) !important;
} */

.swal2-confirm:nth-of-type(2) {
    background-color: var(--success-color) !important;
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
<header class="header">
    <nav class="nav">
        <div class="navigation">
            <a href="<?php echo Helper::baseUrl("/") ?>" class="" style="font-size:1.5rem;">
                Tutor Expert
            </a>
            <a href="<?php echo Helper::baseUrl("") ?>">Home</a>
            <!-- <div class="dropdown">
                <a href="" class="dropdown-toggle">Subjects <i class="fa fa-chervon-down"></i></a>
                <div class="dropdown-menu">
                    <a href="">Math</a>
                    <a href="">Science</a>
                    <a href="">History</a>
                </div>
            </div> -->
            <!-- <div class="dropdown">
                <a href="" class="dropdown-toggle">Tutor <i class="fa fa-caret-down"></i></a>
                <div class="dropdown-menu">
                    <a href="">Find a Tutor</a>
                    <a href="">Become a Tutor</a>
                </div>
            </div> -->
        </div>
        <div class="auth">
            <?php if (Yii::$app->user->isGuest): ?>
                <a href="<?php Helper::baseUrl("") ?>login">Login</a>
            <?php else: ?>
                <div class="dropdown">
                    <div class="">
                        <small class="text-dark"><?= Yii::$app->user->identity->role ?></small>
                        <a href="#" class="dropdown-toggle"><?= Yii::$app->user->identity->username ?></a>
                    </div>
                    <div class="dropdown-menu" style="">
                        <?php if (Yii::$app->user->identity->role == "student"): ?>
                            <a href="<?php echo Helper::baseUrl("/profile") ?>">Profile</a>
                            <a href="<?php echo Helper::baseUrl("/profile/edit") ?>">Edit Profile</a>
                            <a href="<?php echo Helper::baseUrl("/peoples") ?>">Peoples & Messages</a>
                            <a href="<?php echo Helper::baseUrl("/post/list") ?>">Post</a>
                            <a href="<?php echo Helper::baseUrl("/post/create") ?>">Create</a>
                        <?php elseif (Yii::$app->user->identity->role == "tutor"): ?>
                            <a href="<?php echo Helper::baseUrl("/tutor/dashboard") ?>">Dashboard</a>
                            <a href="<?php echo Helper::baseUrl("/tutor/wallet") ?>">Wallet</a>
                            <a href="<?php echo Helper::baseUrl("/profile") ?>">Profile</a>
                            <a href="<?php echo Helper::baseUrl("/tutor/profile") ?>">Edit Profile</a>
                            <a href="<?php echo Helper::baseUrl("/peoples") ?>">Peoples & Messages</a>
                            <a href="<?php echo Helper::baseUrl("/post/list") ?>">Post</a>
                            <a href="<?php echo Helper::baseUrl("/tutor/referrals") ?>">Referrals</a>
                        <?php endif; ?>
                        <?php
                        echo Html::beginForm(['/logout'], 'post');
                        echo Html::submitButton(
                            'Logout',
                            ['class' => 'btn btn-link logout']
                        );
                        echo Html::endForm();
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </nav>
</header>