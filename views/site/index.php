<?php

/** @var yii\web\View $this */

use app\components\Helper;
use app\models\User;
use yii\helpers\Html;


$this->title = 'My Yii Application';
?>



<div class="hero-wrapper">
    <!-- Hero Section -->
    <?php echo $this->render('/includes/sections/hero.php') ?>
    <?php /* include 'includes/sections/hero.php'; */ ?>


</div>



<!-- Features Section -->
<?php echo $this->render('/includes/sections/features.php') ?>
<?php
// include 'includes/sections/features.php'; 
?>

<!-- Welcome Section -->
<?php echo $this->render('/includes/sections/welcome.php') ?>



<!-- CTA Section -->
<?php echo $this->render('/includes/sections/cta.php') ?>
<?php
// include 'includes/sections/cta.php'; 
?>

<!-- Teacher Section -->
<?php echo $this->render('/includes/sections/teacher.php') ?>
<?php
// include 'includes/sections/teacher.php'; 
?>



