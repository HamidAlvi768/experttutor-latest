<?php
/** @var array $tutors */
/** @var \yii\data\Pagination $pages */
/** @var string $search */

use app\components\Helper;
use yii\helpers\Url;
use yii\widgets\LinkPager;

?>
<style>
    .disabled span{
        position: relative !important;
    display: block !important;
    padding: var(--bs-pagination-padding-y) var(--bs-pagination-padding-x) !important;
        border: var(--bs-pagination-border-width) solid var(--bs-pagination-border-color) !important;

    
    }
    
</style>
<div id="tutors-container">
    <?php if ($tutors): ?>
        <div class="tutors-page-grid-wrapper">
            <?php foreach ($tutors as $tutor): ?>
                <?php $user_slug= Helper::getuserslugfromid($tutor->id);?>
                <a href="<?= Helper::baseUrl("/tutor-profile?id={$user_slug}") ?>" style="text-decoration: none;" class="tutor-card">
                    <div class="tutors-page-card">
                        <div class="tutors-page-card-header">
                            <?php $user_img = Helper::getuserimage($tutor->id); ?>
                            <?php $profile_image = Helper::baseUrl($user_img); ?>
                            <img src="<?= ($user_img) ? $profile_image : 'https://ui-avatars.com/api/?name=' . $tutor->username ?>"
                                 alt="<?= $tutor->username ?>"
                                 class="tutors-page-tutor-image">
                            <div class="tutors-page-rating">
                                <i class="fas fa-star"></i>
                                <span><?= count($tutor->reviews) ?></span>
                            </div>
                        </div>
                        <div class="tutors-page-card-info">
                            <h3 class="tutors-page-tutor-name" data-rating="<?= count($tutor->reviews) ?>"><?= $tutor->username ?></h3>
                            <div class="tutor-location"><?= isset($tutor->profile->country) ? $tutor->profile->country : '' ?></div>
                            <div class="tutors-page-subjects mt-2" style="display: block;">
                                <?php foreach ($tutor->subjects as $subject): ?>
                                    <span class="tutors-page-subject-tag mb-2"><?= $subject->subject ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<div class="no-results-message" id="no-results" style="<?= $tutors ? 'display:none;' : 'display:block;' ?>">
    <h3>No Tutors Found</h3>
    <p>Try searching with different keywords.</p>
</div>
<?php if ($tutors): ?>
    <div class="pagination-wrapper mt-4">
        <?= LinkPager::widget([
            'pagination' => $pages,
            'options' => ['class' => 'pagination justify-content-center'],
            'linkOptions' => ['class' => 'page-link'],
            'pageCssClass' => 'page-item',
        ]) ?>
    </div>
<?php endif; ?>