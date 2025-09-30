<?php

use app\models\GenericRecords;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\GenericRecordsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Generic Records';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-wrapper">
    <div class="content">
<div class="generic-records-index ">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Add New Record', ['create'], ['class' => 'btn btn-success float-end mb-2']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'parent_id',
            'type',
            'title',
            'description:ntext',
            //'active',
            //'created_by',
            //'updated_by',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'template' => '{edit} {delete}',
                'buttons' => [
                    'edit' => function ($url, $model, $key) {
                        return Html::a('Edit', ['update', 'id' => $model->id], [
                            'class' => 'btn btn-sm btn-primary',
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-sm btn-danger',
                            'data-confirm' => 'Are you sure you want to delete this record?',
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
