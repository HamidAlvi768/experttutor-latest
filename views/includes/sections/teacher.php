<?php
use app\components\Helper;
use PHPUnit\TextUI\Help;

?><section class="teacher-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="teacher-image-wrapper">
                    <img src="<?= Helper::baseUrl("/")?>custom/images/teacher.png" alt="Our Expert Teachers" class="img-fluid rounded">
                </div>
            </div>
            <div class="col-lg-6">
                <h2>Find The Best Teacher Here for your work</h2>
                <p>Focus on what's really in their mind, whether it's foundational knowledge or advanced skills. Take our expert advice to address their individual needs.</p>
                <a href="<?= Helper::baseUrl('tutors') ?>" class="btn btn-primary">Find Best Teacher</a>
            </div>
        </div>
    </div>
</section> 