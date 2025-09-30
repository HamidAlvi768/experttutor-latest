<?php
use app\components\Helper;
use app\models\JobApplications;
use yii\helpers\Html;
?>
<section class="jobs-navigation" id="jobs-navigation">
    <div class="container">
        <nav class="jobs-tabs">
            <a href="<?= Helper::baseUrl('/tutor/dashboard') ?>" class="tab-link<?= $actionId == 'dashboard' ? ' active' : '' ?>">Best Matches</a>
              <a href="<?= Helper::baseUrl('/tutor/online-jobs') ?>" class="tab-link<?= $actionId == 'online-jobs' ? ' active' : '' ?>">OnlineTutoring</a>
            <a href="<?= Helper::baseUrl('/tutor/home-jobs') ?>" class="tab-link<?= $actionId == 'home-jobs' ? ' active' : '' ?>">Home Tutoring</a>
            <a href="<?= Helper::baseUrl('/tutor/assigmnet-jobs') ?>" class="tab-link<?= $actionId == 'assigmnet-jobs' ? ' active' : '' ?>">Assignment Help</a>
            <?php /*?><a href="<?= Helper::baseUrl('/tutor/recent-jobs#jobs-navigation') ?>" class="tab-link<?= $actionId == 'recent-jobs' ? ' active' : '' ?>">Recent</a>
            <a href="<?= Helper::baseUrl('/tutor/saved-jobs#jobs-navigation') ?>" class="tab-link<?= $actionId == 'saved-jobs' ? ' active' : '' ?>">Saved Jobs</a>
            <a href="<?= Helper::baseUrl('/tutor/applied-jobs#jobs-navigation') ?>" class="tab-link<?= $actionId == 'applied-jobs' ? ' active' : '' ?>">Applied Jobs</a>
             <?php */?>
            
        </nav>
        <p class="jobs-description">
            <?php if ($actionId == 'dashboard'): ?>
                Explore job opportunities that align with your experience and the clients' hiring criteria, sorted by relevance.
            <?php elseif ($actionId == 'recent-jobs'): ?>
                See the most recently posted jobs for tutors.
            <?php elseif ($actionId == 'saved-jobs'): ?>
                Review jobs you have saved.
            <?php elseif ($actionId == 'applied-jobs'): ?>
                Review jobs you have applied to.
            <?php endif; ?>
        </p>
    </div>
</section>