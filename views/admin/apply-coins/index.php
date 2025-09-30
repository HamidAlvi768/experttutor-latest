<?php
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\data\ActiveDataProvider $dataProvider */
?>
<div class="page-wrapper">
    <div class="content">
<div class="coins-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Set Apply Coins', ['apply-coins-add'], ['class' => 'btn btn-success float-end mb-2']) ?>
    </p>
<div class="job-apply-coins-index">
    <h1>Job Apply Coins by Region</h1>
    <h5 class="mb-3">Manage Coins needed to apply for job according to region</h5>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'country',
            'coin_value',
            'member_coin_value',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{edit},{delete}',
                 'buttons' => [
                    'edit' => function ($url, $dataProvider, $key) {
                        return Html::a('Edit', ['admin/apply-coins-update', 'id' => $dataProvider->id], [
                            'class' => 'btn btn-sm btn-primary mb-2',
                        ]);
                    },
                    'delete' => function ($url, $dataProvider, $key) {
                        return Html::a('Delete', ['admin/apply-coins-delete', 'id' => $dataProvider->id], [
                            'class' => 'btn btn-sm btn-danger mb-2',
                            'data-confirm' => 'Are you sure to delete this user?',
                            'data-method' => 'post',
                        ]);
                    },
                  
                ],
            ],
        ],
    ]); ?>
</div>
</div>
    </div>
</div>
