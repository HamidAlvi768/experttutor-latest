<?php

use app\components\Helper;
use app\models\JobApplications;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Tutor Dashboard';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.tutor-dashboard-container {
    max-width: 1100px;
    margin: 40px auto;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
    padding: 32px 32px 24px 32px;
}
.tutor-dashboard-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(90deg, #e0eafc 0%, #cfdef3 100%);
    border-radius: 12px;
    padding: 32px 24px 24px 24px;
    margin-bottom: 32px;
}
.tutor-dashboard-header .user-info {
    display: flex;
    align-items: center;
    gap: 18px;
}
.tutor-dashboard-header .user-avatar {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #2ecc71;
}
.tutor-dashboard-header .user-meta {
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.tutor-dashboard-header .user-meta .username {
    font-size: 2rem;
    font-weight: 700;
    color: #222;
}
.tutor-dashboard-header .user-meta .role {
    font-size: 1rem;
    color: #666;
}
.tutor-dashboard-header .dashboard-actions {
    display: flex;
    gap: 16px;
}
.tutor-dashboard-header .dashboard-actions a {
    background: #2ecc71;
    color: #fff;
    border-radius: 8px;
    padding: 10px 22px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.2s;
}
.tutor-dashboard-header .dashboard-actions a:hover {
    background: #27ae60;
}
.tutor-dashboard-jobs-nav {
    display: flex;
    gap: 24px;
    margin-bottom: 18px;
    border-bottom: 1px solid #eaeaea;
    padding-bottom: 8px;
}
.tutor-dashboard-jobs-nav a {
    color: #888;
    font-weight: 500;
    text-decoration: none;
    padding: 6px 0;
    border-bottom: 2px solid transparent;
    transition: color 0.2s, border 0.2s;
}
.tutor-dashboard-jobs-nav a.active {
    color: #2ecc71;
    border-bottom: 2px solid #2ecc71;
}
.tutor-dashboard-intro {
    font-size: 1.1rem;
    color: #444;
    margin-bottom: 24px;
}
.tutor-dashboard-job-list {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}
@media (max-width: 900px) {
    .tutor-dashboard-job-list { grid-template-columns: 1fr; }
}
.tutor-dashboard-job-card {
    background: #f8fafc;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    padding: 22px 20px 16px 20px;
    display: flex;
    flex-direction: column;
    height: 100%;
    transition: box-shadow 0.2s;
}
.tutor-dashboard-job-card:hover {
    box-shadow: 0 6px 24px rgba(46,204,113,0.10);
}
.tutor-dashboard-job-card .card-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #222;
    margin-bottom: 8px;
}
.tutor-dashboard-job-card .job-budget {
    color: #2ecc71;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 8px;
}
.tutor-dashboard-job-card .card-text {
    color: #555;
    font-size: 1rem;
    margin-bottom: 12px;
}
.tutor-dashboard-job-card .card-footer {
    margin-top: auto;
    display: flex;
    justify-content: flex-end;
    background: none;
    border: none;
    padding: 0;
}
.tutor-dashboard-job-card .btn-apply {
    background: #2ecc71;
    color: #fff;
    border-radius: 6px;
    padding: 7px 18px;
    font-weight: 600;
    border: none;
    font-size: 1rem;
    transition: background 0.2s;
    text-decoration: none;
}
.tutor-dashboard-job-card .btn-apply.applied {
    background: #b2f7cf;
    color: #2ecc71;
    cursor: default;
}
.tutor-dashboard-job-card .btn-apply:hover:not(.applied) {
    background: #27ae60;
}
</style>
<div class="container">
    <div class="tutor-dashboard-header">
        <div class="user-info">
            <img class="user-avatar" src="<?= Html::encode($user->profile_image ?? '<?= Helper::baseUrl() ?>/assets/images/profile.jpg') ?>" alt="<?= Html::encode($user->username) ?>">
            <div class="user-meta">
                <span class="username"><?= Html::encode($user->username) ?></span>
                <span class="role">Tutor</span>
            </div>
        </div>
        <div class="dashboard-actions">
            <a href="<?= Helper::baseUrl('/tutor/profile') ?>">Edit Profile</a>
            <a href="<?= Helper::baseUrl('/tutor/wallet') ?>">Wallet</a>
        </div>
    </div>
    <?php
    $actionId = Yii::$app->controller->action->id;
    // Determine which jobs to show based on tab
    $jobs = $matched_posts;
    if ($actionId == 'recent-jobs') {
        $jobs = $recent_posts ?? [];
    } elseif ($actionId == 'saved-jobs') {
        $jobs = $saved_posts ?? [];
    }
    ?>
    <div class="tutor-dashboard-jobs-nav">
        <a href="<?= Helper::baseUrl('/tutor/dashboard') ?>" class="<?= $actionId == 'dashboard' ? 'active' : '' ?>">Best Matches</a>
        <a href="<?= Helper::baseUrl('/tutor/dashboard') ?>" class="<?= $actionId == 'recent-jobs' ? 'active' : '' ?>">Recent</a>
        <a href="<?= Helper::baseUrl('/tutor/dashboard') ?>" class="<?= $actionId == 'saved-jobs' ? 'active' : '' ?>">Saved Jobs</a>
    </div>
    <div class="tutor-dashboard-intro">
        <?php if ($actionId == 'dashboard'): ?>
            Explore job opportunities that align with your experience and the clients' hiring criteria, sorted by relevance.
        <?php elseif ($actionId == 'recent-jobs'): ?>
            See the most recently posted jobs for tutors.
        <?php elseif ($actionId == 'saved-jobs'): ?>
            Review jobs you have saved for later consideration.
        <?php endif; ?>
    </div>
    <div class="tutor-dashboard-job-list">
        <?php if (empty($jobs)): ?>
            <div style="grid-column: 1/-1; text-align:center; color:#888; font-size:1.1rem; padding:40px 0;">No jobs found for this category.</div>
        <?php else: ?>
            <?php foreach ($jobs as $model): ?>
                <div class="tutor-dashboard-job-card">
                    <div class="card-title"><?= Html::encode($model->title) ?></div>
                    <div class="job-budget"> <?= Html::encode($model->budget) ?></div>
                    <div class="card-text">
                        <?= Html::encode(mb_substr($model->details, 0, 150)) . (mb_strlen($model->details) > 150 ? '...' : '') ?>
                    </div>
                    <div class="card-footer">
                        <?php $applied = JobApplications::find()->where(['job_id'=>$model->id,'applicant_id'=>Yii::$app->user->identity->id])->one(); ?>
                        <?php if ($applied): ?>
                            <a href="<?= Helper::baseUrl(['/tutor/job-apply', 'id' => $model->id]) ?>" class="btn-apply">Applied</a>
                        <?php else: ?>
                            <a href="<?= Helper::baseUrl(['/tutor/job-apply', 'id' => $model->id]) ?>" class="btn-apply">Apply</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>