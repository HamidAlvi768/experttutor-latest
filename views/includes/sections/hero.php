<?php

use app\components\Helper;
use yii\helpers\BaseUrl;
?>
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <h1 class="hero-title">
                               <div class="title-line-1"><span>CONNECTING</span>INDIVIDUALS<span class="individuals">TO</span></div>
        <div class="title-line-2">EXPERT</div>
                </h1>
                <p class="hero-subtitle">From assignments tutoring to complete learning support - your trusted academic partner.</p>
                <div class="search-box search-container ">
                    <div class="search-input-wrapper">
                    <input type="text" class="form-control" id="tutor-search" placeholder="Search For Talented Tutors By Name Or Subjects" onkeydown="if(event.key==='Enter'){window.location.href='<?= Helper::baseUrl('tutors') ?>?search='+encodeURIComponent(this.value);}"> 
                    <div class="search-suggestions" id="search-suggestions"></div>                      
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 
