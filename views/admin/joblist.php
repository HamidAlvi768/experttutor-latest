<?php

use app\components\Helper;
use app\models\UserVerifications;
use yii\helpers\Html;
use yii\widgets\ListView;

/** @var yii\data\ActiveDataProvider $models */

$this->title = 'All Job Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .card {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border-radius: 12px;
        border: 1px solid #e5e9f2;
        background: #fff;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.13);
    }

    .card-title {
        color: #1a2233;
        font-weight: 500;
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
        letter-spacing: 0.01em;
    }

    .card-text {
        color: #5a6270;
        font-size: 1rem;
        margin-bottom: 1rem;
        min-height: 48px;
    }

    .card-meta {
        background: #f7fafd;
        border-radius: 6px;
        padding: 0.5rem 0.75rem;
        margin-bottom: 1rem;
    }

    .card-meta li {
        font-size: 0.97rem;
        color: #7b8a99;
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
    }

    .card-meta li i {
        margin-right: 8px;
        color: #2196f3;
        font-size: 1.1em;
        min-width: 18px;
        text-align: center;
    }

    .card-footer {
        border-top: 1px solid #e5e9f2;
        background: #f9fbfd;
        border-radius: 0 0 12px 12px;
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }

    .btn-sm {
        font-size: 0.97rem;
        padding: 0.4rem 1.1rem;
        border-radius: 5px;
    }
</style>
<div class="page-wrapper">
    <div class="content">
        <div class="student-job-posts-list">
            <div class="container2">
                <?php
                $isNumberVerified = false;
                $userVerification = UserVerifications::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
                // $isNumberVerified = $userVerification->phone_verified == 1 ? true : false;
                ?>



                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0"><?= Html::encode($this->title) ?></h2>
                    <?php /*//if ($isNumberVerified): ?>
                <div>
                    <?= Html::a('Create Job Post', ['create'], ['class' => 'btn btn-success']) ?>
                </div>
            <?php //; */ ?>

                </div>
                <?php use yii\widgets\Pjax;

Pjax::begin([
    'id' => 'jobs-pjax',
    'timeout' => 5000,
    'enablePushState' => true, // so URL updates with filters
]);
 ?>
<div class="card mb-4">
    <div class="card-body">

    
        <form method="get" action="" data-pjax="true">

            <div class="row g-3 align-items-end">
                <!-- Search -->
                <div class="col-md-4">
                    <label for="search" class="form-label">Search Title</label>
                    <input type="text" name="search" id="search" class="form-control"
                           value="<?= Html::encode($_GET['search'] ?? '') ?>"
                           placeholder="Enter keyword...">
                </div>

                <?php /*?>
                <!-- Location -->
                <div class="col-md-4">
                    <label for="location" class="form-label">Job Location</label>
                    <select name="location" id="location" class="form-select">
                        <option value="">All Locations</option>
                        <?php foreach ($locations as $loc): ?>
                            <option value="<?= Html::encode($loc) ?>"
                                <?= (($_GET['location'] ?? '') == $loc) ? 'selected' : '' ?>>
                                <?= Html::encode($loc) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php */?>
                <!-- Budget -->
 
<div class="col-md-4">
    <label for="budget" class="form-label">Job Budget (<?= Helper::getCurrency()?>)</label>
    <select name="budget" id="budget" class="form-select">
        <option value="">All Budgets</option>
        <?php
        // Predefined ranges
        $ranges = [
            "0-500"      => "0 - 500",
            "501-1000"   => "501 - 1,000",
            "1001-2000"  => "1,001 - 2,000",
            "2001-5000"  => "2,001 - 5,000",
            "5001-10000" => "5,001 - 10,000",
            "10001+"     => "10,001+"
        ];

        $selectedBudget = $_GET['budget'] ?? '';

        foreach ($ranges as $value => $label) {
            $selected = ($selectedBudget == $value) ? 'selected' : '';
            echo "<option value=\"$value\" $selected>$label</option>";
        }
        ?>
    </select>
</div>



                <!-- Subject -->
                <div class="col-md-4">
                    <label for="subject" class="form-label">Job Subject</label>
                    <select name="subject" id="subject" class="form-select">
                        <option value="">All Subjects</option>
                        <?php foreach ($subjects as $sub): ?>
                            <option value="<?= Html::encode($sub) ?>"
                                <?= (($_GET['subject'] ?? '') == $sub) ? 'selected' : '' ?>>
                                <?= Html::encode($sub) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Buttons -->
                <div class="col-md-12 text-end mt-2">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-funnel"></i> Apply Filters
                    </button>
                    <a href="<?= \yii\helpers\Url::to(['']) ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>


                <div class="row g-4">
                    <?php foreach ($dataProvider->getModels() as $model): ?>
                        <div class="col-md-12">
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title flex-shrink-0"><?= Html::encode($model->title ?? "Not Provided") ?></h5>
                                    <p class="card-text flex-shrink-0">
                                        <?= Html::encode(substr($model->details ?? "", 0, 150)) . '...' ?>
                                    </p>
                                    <ul class="card-meta list-unstyled flex-shrink-0 mb-2">
                                        <li><i class="fa fa-money"></i> <span><strong>Budget:</strong> <?= Helper::getCurrency() ?> <?= Html::encode($model->budget ?? 0) ?></span></li>
                                        <?php if ($model->post_code ?? ""): ?>
                                            <li><i class="fa fa-map-marker"></i> <span><strong>Location:</strong> <?= Html::encode($model->location ?? "") ?></span></li>
                                        <?php endif; ?>
                                        <li><i class="fa fa-book"></i> <span><strong>Subject:</strong> <?= Html::encode($model->subject ?? "") ?></span></li>
                                    </ul>
                                </div>
                                <div class="card-footer bg-transparent text-end">
                                    <?= Html::a('View Details', ['post/view', 'id' => $model->id ?? 0], ['class' => 'btn btn-primary btn-sm ms-2']) ?>
                                </div>
                            </div>
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
                </div>
                <?php Pjax::end(); ?>

            </div>
        </div>
    </div>
    
</div>