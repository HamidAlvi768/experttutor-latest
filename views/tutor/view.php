<?php

use app\components\Helper;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Profile Details';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profiles-view">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php if (!empty($model->avatar_url)): ?>
            <div class="profile-avatar">
                <?= Html::img(Helper::baseUrl($model->avatar_url), ['class' => 'img-thumbnail', 'style' => 'max-width: 200px;']) ?>
            </div>
        <?php endif; ?>


        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'full_name',
                'nick_name',
                'gender',
                'country',
                'languages',
                [
                    'attribute' => 'timezone',
                    'value' => function ($model) {
                        if ($model->timezone) {
                            $dateTime = new DateTime('now', new DateTimeZone($model->timezone));
                            $offset = $dateTime->format('P');
                            return "(UTC/GMT{$offset}) " . str_replace('_', ' ', $model->timezone);
                        }
                        return null;
                    },
                ],
                'phone_number',
            ],
        ]) ?>

        <div class="form-group"></div>
        <?= Html::a('Update', ['update'], ['class' => 'btn btn-primary']) ?>
    </div>
</div>
</div>