<?php

use app\components\Helper;
use yii\helpers\Html;

?>
<style>
    .header {
        background-color: transparent;
        color: white;
        padding: 10px 20px;
    }

    .nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .brand a {
        color: white;
        text-decoration: none;
        display: flex;
    }

    .brand a p {
        margin: 0px;
        font-size: 24px;
        background: -webkit-linear-gradient(90deg, #051391 0%, #5868FF 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 700;
    }

    .brand a small {
        font-size: 14px;
        margin: 0px;
        background: -webkit-linear-gradient(90deg, #051391 0%, #5868FF 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }


    .navigation a {
        text-decoration: none;
        margin-right: 20px;
        color: #333;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-toggle {
        color: white;
        text-decoration: none;
        margin-right: 20px;
        cursor: pointer;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        background-color: white;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
        border-radius: 4px;
        margin-top: 10px;
    }

    .dropdown-menu a {
        color: #333;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        margin: 0;
    }

    .dropdown-menu a:hover {
        background-color: #f1f1f1;
    }

    .dropdown:hover .dropdown-menu {
        display: block;
    }

    .auth a {
        width: 199px;
        padding: 10px 15px;
        background-color: #564FFD;
        color: white;
        text-decoration: none;
        margin-left: 20px;
        border-radius: 11px;
    }
</style>
<header class="header">
    <nav class="nav">
        <div class="brand">
            <a href="<?php echo Helper::baseUrl("/") ?>" class="">
                <!-- <img src="<?php //Helper::logo(); ?>" alt="" class="logo" width="60" height="60"> -->
                <div>
                    <p class="brand-name">Assignment</p>
                    <small>& Tutors</small>
                </div>
            </a>
        </div>
        <div class="navigation">
            <a href="<?php echo Helper::baseUrl("") ?>">Home</a>
            <a href="<?php echo Helper::baseUrl("/tutors") ?>">Tutors</a>
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
                        
                        <a href="#" class="dropdown-toggle"><?= Yii::$app->user->identity->username ?> (<small class="text-white"><?= Yii::$app->user->identity->role ?></small>)</a>
                    </div>
                    <div class="dropdown-menu" >
                        <?php if (Yii::$app->user->identity->role == "student"): ?>
                            <a href="<?php echo Helper::baseUrl("/profile") ?>">Profile</a>
                            <a href="<?php echo Helper::baseUrl("/profile/edit") ?>">Edit Profile</a>
                            <a href="<?php echo Helper::baseUrl("/peoples") ?>">Peoples & Messages</a>
                            <a href="<?php echo Helper::baseUrl("/post/list") ?>">Post</a>
                            <a href="<?php echo Helper::baseUrl("/post/create") ?>">Create</a>
                        <?php elseif (Yii::$app->user->identity->role == "tutor"): ?>
                            <a href="<?php echo Helper::baseUrl("/tutor/dashboard") ?>">Dashboard</a>
                            <a href="<?php echo Helper::baseUrl("/tutor/wallet") ?>">Wallet</a>
                            <a href="<?php echo Helper::baseUrl("/tutor/profile") ?>">Profile</a>
                            <a href="<?php echo Helper::baseUrl("/tutor/profile") ?>">Edit Profile</a>
                            <a href="<?php echo Helper::baseUrl("/peoples") ?>">Peoples & Messages</a>
                            <a href="<?php echo Helper::baseUrl("/post/list") ?>">Post</a>
                            <a href="<?php echo Helper::baseUrl("/post/create") ?>">Create</a>
                             <?php elseif (Yii::$app->user->identity->role == "superadmin"): ?>
                            <a href="<?php echo Helper::baseUrl("/admin/dashboard") ?>">Dashboard</a>
                        
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