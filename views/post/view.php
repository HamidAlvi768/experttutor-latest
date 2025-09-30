<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Job Detail';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-wrapper" style="padding-inline: 6rem;">
    <div class="content">
        <div style="display: flex; justify-content: flex-start; align-items: center; margin-bottom: 1rem;">
            <button style="background: var(--primary-color);" onclick="window.history.back();" class="btn btn-secondary">Go Back</button>
        </div>

<div class="profiles-view">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php if (!empty($model->avatar_url)): ?>
        <div class="profile-avatar">
            <?= Html::img($model->avatar_url, ['class' => 'img-thumbnail', 'style' => 'max-width: 200px;']) ?>
        </div>
        <?php endif; ?>


        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'title',
                'details',
                'subject',
                //'location',
                'other_subject',
                'budget',
                'post_status',
                // [
                //     'attribute' => 'timezone',
                //     'value' => function ($model) {
                //         if ($model->timezone) {
                //             $dateTime = new DateTime('now', new DateTimeZone($model->timezone));
                //             $offset = $dateTime->format('P');
                //             return "(UTC/GMT{$offset}) " . str_replace('_', ' ', $model->timezone);
                //         }
                //         return null;
                //     },
                // ],
                'phone_number',
            ],
        ]) ?>

        <div class="form-group"></div>
        
        <?php /* ?><?= Html::a('Update', ['update'], ['class' => 'btn btn-primary']) ?><?php */ ?>
    </div>
</div>
</div>
</div>