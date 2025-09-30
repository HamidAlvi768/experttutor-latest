<?php

use app\components\Helper;
use app\models\JobApplications;
use app\models\Reviews;
use app\models\UserVerifications;
use Stripe\Review;
use yii\helpers\Html;

$this->title = 'Student Job Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .expertTutor_dashboard_container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 0 15px;
    }

    .expertTutor_dashboard_card {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-bottom: 20px;
        cursor: pointer;
        transition: box-shadow 0.2s ease-in-out;
        width: 100%;
    }

    .expertTutor_dashboard_card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .expertTutor_dashboard_header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    @media (max-width: 768px) {
        .expertTutor_dashboard_header {
            margin-bottom: 0.2rem;
        }
    }

    .expertTutor_dashboard_title {
        margin: 0;
        padding-right: 1rem;
        flex: 1;
        font-size: clamp(0.9rem, 3.5vw, 1.1rem) !important;
        color: var(--primary-color) !important;

    }

    .expertTutor_dashboard_price {
        font-weight: 600;
        font-size: clamp(0.75rem, 2.5vw, 0.9rem) !important;
        margin-right: 15px;
        color: var(--text-dark);
    }

    .expertTutor_dashboard_currency {
        display: inline-flex;
        align-items: center;
        margin-right: 4px;
        color: #564FFD;
    }

    .expertTutor_dashboard_currency svg {
        width: auto;
        min-height: 2rem;
        transform: translate(4px, 10px);
    }

    .expertTutor_dashboard_currency svg path {
        stroke: #564FFD;
    }

    .expertTutor_dashboard_location {
        color: #6B7280;
        display: flex;
        align-items: center;
        font-size: clamp(0.54rem, 2.5vw, 0.8rem);
    }

    .expertTutor_dashboard_location .location-icon {
        width: 20px;
        height: 20px;
        margin-right: 8px;
        color: #09B31A;
    }

    .expertTutor_dashboard_status {
        background: #F3F4F6;
        color: #6B7280;
        padding: 10px 25px;
        border-radius: 6px;
        font-size: clamp(0.75rem, 2vw, 0.875rem) !important;
        font-weight: 500;
        margin-right: 12px;
        display: inline-block;
    }

    .expertTutor_dashboard_messageIcon {
        position: relative;
        color: #6B7280;
        font-size: 1.25rem;
        padding: 0.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .expertTutor_dashboard_messageIcon .notification-dot {
        position: absolute;
        top: -3px;
        right: -3px;
        width: 8px;
        height: 8px;
        background: #FF4842;
        border-radius: 50%;
    }

    .expertTutor_dashboard_createPost {
        background-color: #09B31A;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        font-size: clamp(0.7rem, 2.5vw, 0.8rem) !important;
        line-height: 1.5;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 2px 4px rgba(0, 171, 85, 0.08);
        flex-direction: row-reverse;
    }

    .expertTutor_dashboard_createPost:hover {
        background-color: #007B55;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 171, 85, 0.15);
    }

    .expertTutor_dashboard_createPost i {
        margin-top: -1px;
    }

    .expertTutor_dashboard_finishButton {
        background-color: var(--primary-color);
        border: none;
        color: white;
        padding: 10px 25px;
        border-radius: 6px;
        font-weight: 500;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.2s;
        min-width: 100px;
        text-align: center;
        font-size: clamp(0.75rem, 2vw, 0.8rem) !important;
    }

    .expertTutor_dashboard_finishButton:hover {
        background-color: #5249e3;
        color: white;
        text-decoration: none;
    }

    .job-description-text {
        font-size: clamp(0.875rem, 2.5vw, 0.8rem) !important;
        line-height: 1.5;
        margin-bottom: 0;
    }

    @media (max-width: 991.98px) {
        .job-description-text {
            margin-bottom: 0.2rem;
        }
    }

    .tab-link {
        font-size: clamp(0.8rem, 2.5vw, 1rem) !important;
    }

    .no-jobs-message {
        text-align: center;
        color: #888;
        font-size: clamp(0.9rem, 2.5vw, 1.1rem) !important;
        padding: 40px 0;
    }

    .alert {
        font-size: clamp(0.875rem, 2.5vw, 1rem) !important;
    }

    .expertTutor_dashboard_info {
        flex-direction: row;
        gap: 1rem;
    }

    .info-action-container {
        align-items: center;
    }

    @media (max-width: 768px) {
        .expertTutor_dashboard_info {
            flex-direction: column;
            gap: 0.5rem;
        }

        .expertTutor_dashboard_finishButton {
            padding: 10px;
        }

        .expertTutor_dashboard_price {
            align-self: baseline;
        }

        .expertTutor_dashboard_location {
            width: clamp(12rem, 35vw, 20rem);
        }
    }

    @media (max-width: 576px) {
        .expertTutor_dashboard_location {
            width: auto;
        }

        .info-action-container {
            flex-direction: column;
            gap: 0.2rem;
            align-items: unset;
            margin-top: 0;
        }
    }

    .jobs-navigation2 {
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 10px;
    }

    .tab-link.active {
        color: #333333;
        font-weight: 600;
        border-bottom-color: #333333;
    }

    .mark-finish-btn {
        align-self: end;
    }
</style>
<?php
$isNumberVerified = false;
$userVerification = \app\models\UserVerifications::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
$isNumberVerified = true; //$userVerification && $userVerification->phone_verified == 1 ? true : false;
$user_id = Yii::$app->user->identity->id;
$dataProvider_data = $dataProvider->getModels();
?>
<div class="container mt-4 mb-5">
    <?php if (!$isNumberVerified): ?>
        <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
            <div style="width:100%;display:flex;justify-content:space-between;align-items:center;">
                <p class="m-0">
                    <span><i class="fas fa-exclamation-triangle me-2"></i></span>
                    <span>Please verify your phone number before creating a job post.</span>
                </p>
                <?= Html::a('Verify Now', ['/verify-phone'], ['class' => 'btn btn-light text-dark btn-sm ms-3']) ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($isNumberVerified): ?>
        <div class="jobs-navigation2">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 ">
                <?php if ($isNumberVerified): ?>
                    <?php $actionId = '' ?>

                    <nav class="nav jobs-tabs">
                        <a href="<?= Helper::baseUrl('/post/list') ?>" class="tab-link<?= $status == '' ? ' active ' : '' ?>">All Jobs</a>
                        <a href="<?= Helper::baseUrl('/post/list?status=open') ?>" class="tab-link<?= $status == 'open' ? ' active' : '' ?>">Open Jobs</a>
                        <a href="<?= Helper::baseUrl('/post/list?status=closed') ?>" class="tab-link<?= $status == 'closed' ? ' active' : '' ?>">Closed Jobs</a>
                    </nav>

                    <div class="text-end mt-sm-2">
                        <?= Html::a('<i class="fas fa-plus me-1"></i> Post Your Assignment', ['create'], ['class' => 'btn btn-primary btn-sm expertTutor_dashboard_createPost']) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    <?php //print_r($models) 
    ?>
    <?php if ($dataProvider_data): ?>
        <?php foreach ($dataProvider_data as $model): ?>
            <div class="expertTutor_dashboard_card">
                <a
                    <?php //if ($model->post_status !== 'complete'): 
                    ?>
                    href="<?= Helper::baseUrl("/post/engagements?id={$model->id}") ?>"
                    <?php // endif; 
                    ?>>
                    <div class="expertTutor_dashboard_header">
                        <h1 class="expertTutor_dashboard_title fs-2 fw-semibold text-dark"><?= Html::encode($model->title) ?></h1>
                        <a
                            href="<?php echo Helper::baseUrl("/peoples") ?>">
                            <div class="expertTutor_dashboard_messageIcon">
                                <i class="far fa-envelope" style="color: #09B31A;"></i>
                                <?php if (count($model->getMessages()->all()) > 0): ?>
                                    <span class="notification-dot"></span>
                                <?php endif; ?>

                            </div>
                        </a>
                    </div>
                    <p class="text-secondary job-description-text">
                        <?= Html::encode(mb_substr($model->details, 0, 200)) . (mb_strlen($model->details) > 200 ? '...' : '') ?>
                    </p>
                    <div class="info-action-container d-flex justify-content-between">
                        <div class="d-flex expertTutor_dashboard_info">
                            <span class="expertTutor_dashboard_price">
                                <span class="expertTutor_dashboard_currency"><?= Helper::getCurrency() ?></span>
                                <?= Html::encode($model->budget) ?>
                            </span>
                            <span class="expertTutor_dashboard_location">
                                <svg class="location-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <?= Html::encode($model->location) ?>
                            </span>
                        </div>
                        <div class="mark-finish-btn d-flex align-items-center">
                            <?php if ($model->post_status === 'complete'): ?>
                                <span class="expertTutor_dashboard_status">
                                    <a href="<?php echo Helper::baseUrl("/post/engagements?id={$model->id}") ?>">
                                        <?= $model->post_status === 'complete' ? 'Post Closed' : '' ?>
                                    </a>
                                </span>
                            <?php endif; ?>
                            <?php
                            $application = JobApplications::findOne([
                                'job_id' => $model->id,
                                'application_status' => 'accepted'
                            ]); ?>
                            <?php if ($model->post_status !== 'complete'): ?>
                                <?= Html::a('Mark Complete', ['finish-post', 'id' => $model->id], [
                                    'class' => 'expertTutor_dashboard_finishButton',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to mark this post as finished?',
                                        'method' => 'post',
                                        'job-id' => $model->id,
                                    ],
                                ]) ?>
                            <?php elseif ($application): ?>

                                <?php $reviewd = Reviews::find()->where(['job_id' => $model->id])->andWhere(['user_id' => Yii::$app->user->identity->id])->one() ?>


                                <?php
                                $twoDaysPassed = (time() - strtotime($model->updated_at)) > (2 * 24 * 60 * 60);
                                ?>

                                <span class="expertTutor_dashboard_status">
                                    <?php if (!$reviewd && !$twoDaysPassed): ?>
                                        <a href="#"
                                            data-bs-toggle="modal"
                                            data-bs-target="#reviewModal"
                                            data-job-id="<?= $model->id ?>">
                                            Review
                                        </a>
                                    <?php else: ?>
                                        <a href="#"
                                            data-bs-toggle="modal"
                                            data-bs-target="#reviewModaldisabled"
                                            data-job-id="<?= $model->id ?>">
                                            Reviewed
                                        </a>
                                    <?php endif; ?>
                                </span>

                            <?php endif; ?>

                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $dataProvider->getPagination(),
            'options' => ['class' => 'pagination justify-content-center'], // <ul class="pagination">
            'linkOptions' => ['class' => 'page-link'],                     // <a class="page-link">
            'pageCssClass' => 'page-item',                                 // <li class="page-item">
            'prevPageCssClass' => 'page-item',
            'nextPageCssClass' => 'page-item',
            'activePageCssClass' => 'active',
            'disabledPageCssClass' => 'disabled',
            'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link'], // For <span class="page-link"> on disabled items
            'prevPageLabel' => '&laquo;',
            'nextPageLabel' => '&raquo;',
        ]) ?>
    <?php else: ?>
        <div class="no-jobs-message">No Jobs Posted Yet.</div>
    <?php endif; ?>
</div>