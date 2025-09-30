<?php

use app\components\Helper;
use app\models\JobApplications;
use app\models\Reviews;
use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tutor Dashboard';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Prepare profile_props for hero section (dynamic)
$user = Yii::$app->user->identity;
$fullName = isset($user->username) ? $user->username : '';
$nameParts = explode(' ', $fullName, 2);
$firstName = $nameParts[0];
$lastName = isset($nameParts[1]) ? $nameParts[1] : '';
$profileImage = isset($user->profile_image) && $user->profile_image ? $user->profile_image :  Helper::baseUrl('/custom/custom/images/profiles/teacher-2.jpg');
$bg_image = Helper::baseUrl('/custom/custom/images/tutor-summary-bg.jpg');

$profile_props = [
    'layout_type' => 'full',
    'background_image' => $bg_image,
    'show_info_panel' => false,
    'show_profile_image' => false,
    'profile' => [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'image' => $profileImage
    ]
];
$actionId = Yii::$app->controller->action->id;



$jobs_data = $dataProvider->getModels();

if ($actionId == 'recent-jobs') {
    $jobs = $jobs_data ?? [];
} elseif ($actionId == 'saved-jobs') {
    $jobs = $jobs_data ?? [];
} else {
    $jobs = $jobs_data ?? [];
}

?>

<?php //$this->render('/includes/components/tutor-hero') 
?>
<?= $this->render('_jobs_tabs_nav', ['actionId' => $actionId]) ?>
<section class="jobs-listing">
    <div class="container">
        <?php if (empty($jobs)): ?>
            <div style="text-align:center; color:#888; font-size:1.1rem; padding:40px 0;">No jobs found for this category.</div>
        <?php else: ?>
            <?php foreach ($jobs as $model): ?>
                <?php
                // Check if this job is saved by the current tutor
                $isSaved = false;
                if (class_exists('app\\models\\SavedJobs')) {
                    $isSaved = \app\models\SavedJobs::find()->where(['tutor_id' => Yii::$app->user->id, 'job_id' => $model->id])->exists();
                }
                ?>
                <?php /*?>
                <div class="job-card" data-job-id="<?= $model->id ?>">

                    <div class="job-content">


                        <span class="save-heart <?= $isSaved ? 'saved' : 'unsaved' ?>" title="Save Job">
                            <?= $isSaved
                                ? '<svg width="28" height="28" viewBox="0 0 24 24" fill="#28a745" xmlns="http://www.w3.org/2000/svg"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>'
                                : '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>'
                            ?>
                        </span>


                        <div class="job-header">
                            <h2 class="job-title"><?= Html::encode($model->title) ?></h2>
                            <div class="job-amount">
                                <span style="margin-right: 0.4rem;">Amount: </span>
                                <span class="amount-value"><?= Html::encode($model->budget) ?></span>
                                <span class="amount-currency"><?= Helper::getCurrency() ?></span>
                            </div>
                        </div>
                        <p class="job-description">
                            <?= Html::encode(mb_substr($model->details, 0, 150)) . (mb_strlen($model->details) > 150 ? '...' : '') ?>
                        </p>

                        <div class="" style="

                            align-items: center;
                            display: flex;
                            justify-content: space-between;
                        ">
                            <span><?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></span>
                            <?php $applied = JobApplications::find()->where(['job_id' => $model->id, 'applicant_id' => Yii::$app->user->identity->id])->one(); ?>
                            <?php
                            // Check request status from job_applications table
                            $requestStatus = Yii::$app->db->createCommand("
                                    SELECT application_status FROM job_applications 
                                    WHERE job_id = :post_id AND applicant_id = :tutor_id
                                ", [':post_id' => $model->id, ':tutor_id' => Yii::$app->user->identity->id])->queryScalar();
                            ?>
                            <?php if ($applied && $model->post_status != 'complete'): ?>

                                <?php if ($requestStatus === 'accepted'): ?>
                                    <a href="<?= Helper::baseUrl(['/tutor/job-apply', 'id' => $model->id]) ?>" class="btn-apply applied">Accepted</a>
                                <?php elseif ($requestStatus === 'rejected'): ?>
                                    <span class="btn-apply rejected" style="background-color: #EF4444; color: white;">Rejected</span>
                                <?php else: ?>
                                    <a href="<?= Helper::baseUrl(['/tutor/job-apply', 'id' => $model->id]) ?>" class="btn-apply applied">Applied</a>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if ($model->post_status == 'active'): ?>
                                    <a href="<?= Helper::baseUrl(['/tutor/job-apply', 'id' => $model->id]) ?>" class="btn-apply" <?=  ($model->posted_by == Yii::$app->user->identity->id)? 'disabled=true ':'' ?> >Apply</a>
                                <?php else: ?>


                                    <div>

                                        <span class="btn-apply disabled">Closed</span>
                                        <?php
                                        $reviewd = Reviews::find()
                                            ->where(['job_id' => $model->id])
                                            ->andWhere(['user_id' => Yii::$app->user->identity->id])
                                            ->one();
                                        ?>
                                        <?php if ($requestStatus === 'accepted') { ?>
                                            <?php
                                            $twoDaysPassed = (time() - strtotime($model->updated_at)) > (2 * 24 * 60 * 60);
                                            ?>

                                            <span class="expertTutor_dashboard_status">
                                                <?php if (!$reviewd && !$twoDaysPassed): ?>
                                                    <a href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#reviewModal"
                                                        data-job-id="<?= $model->id ?>"
                                                        data-role="tutor">
                                                        Review
                                                    </a>
                                                <?php else: ?>
                                                    <a href="#"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#reviewModaldisabled"
                                                        data-job-id="<?= $model->id ?>"
                                                        data-role="tutor">
                                                        Reviewed
                                                    </a>
                                                <?php endif; ?>
                                            </span>

                                        <?php } ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
                <?php */ ?>
                <?= $this->render('_job_cards', ['model' => $model, 'isSaved' => $isSaved]) ?>
            <?php endforeach; ?>
            <?= \yii\widgets\LinkPager::widget([
                'pagination' => $dataProvider->getPagination(),
                'options' => ['class' => 'pagination justify-content-center'],
                'linkOptions' => ['class' => 'page-link'],
                'pageCssClass' => 'page-item',
                'prevPageCssClass' => 'page-item',
                'nextPageCssClass' => 'page-item',
                'activePageCssClass' => 'active',
                'disabledPageCssClass' => 'disabled',
                'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link'],
                'prevPageLabel' => '&laquo;',
                'nextPageLabel' => '&raquo;',
            ]) ?>
        <?php endif; ?>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var baseUrl = '<?= addslashes(\app\components\Helper::baseUrl()) ?>';
        var csrfParam = '<?= Yii::$app->request->csrfParam ?>';
        var csrfToken = '<?= Yii::$app->request->csrfToken ?>';

        function setHeartSVG(heartElem, isSaved) {
            if (isSaved) {
                heartElem.innerHTML = '<svg width="28" height="28" viewBox="0 0 24 24" fill="#28a745" xmlns="http://www.w3.org/2000/svg"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>';
            } else {
                heartElem.innerHTML = '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>';
            }
        }
        document.querySelectorAll('.save-heart').forEach(function(heart) {
            heart.addEventListener('click', function(e) {
                e.preventDefault();
                var heartElem = this;
                var jobCard = heartElem.closest('.job-card');
                var jobId = jobCard.getAttribute('data-job-id');
                var isSaved = heartElem.classList.contains('saved');
                var body = 'job_id=' + encodeURIComponent(jobId) + '&' + encodeURIComponent(csrfParam) + '=' + encodeURIComponent(csrfToken);
                fetch(baseUrl + (isSaved ? 'tutor/unsave-job' : 'tutor/save-job'), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: body
                    })
                    .then(response => response.json())
                    .then(resp => {
                        if (resp.success) {
                            heartElem.classList.toggle('saved');
                            heartElem.classList.toggle('unsaved');
                            setHeartSVG(heartElem, !isSaved);
                        }
                    });
            });
        });
    });
</script>