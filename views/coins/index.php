<?php

use app\components\Helper;
use app\models\Coins;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;


/** @var yii\web\View $this */
/** @var app\models\CoinsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

Pjax::begin([
    'id' => 'pjax-grid',
    'timeout' => 5000,
]);

$this->title = 'Coins';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-wrapper">
    <div class="content">
<div class="coins-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Coins', ['create'], ['class' => 'btn btn-success float-end mb-2']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'coin_count',
                'label' => 'Coin Count',
            ],
            [
                'attribute' => 'coin_price',
                'value' => function($model) {
                    $attribute = $model->coin_price. ' ' . Helper::getCurrency();
                    return $attribute;
                },
                'label' => 'Coin Price',
            ],
            [
                'attribute' => 'discount',
                'label' => 'Discount (%)',
            ],
            [
                'attribute' => '',
                'value'=>function ($model){

                     $discont_value = ($model->coin_price * $model->discount)/100;
                    //  if($model->discount >0)$after_discount_price= $model->coin_price - $discont_value;else $after_discount_price=0;
                     $after_discount_price= $model->coin_price - $discont_value;

                    return $after_discount_price;

                },
                 'label' => '<a href="#">After Discount</a>',
    'encodeLabel' => false, // 🔑 allow HTML in label
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{edit} {delete}',
                'buttons' => [
                    'edit' => function ($url, $model, $key) {
                        return Html::a('Edit', ['coins/update', 'id' => $model->id], [
                            'class' => 'btn btn-sm btn-primary',
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('Delete', ['coins/delete', 'id' => $model->id], [
                            'class' => 'btn btn-sm btn-danger',
                            'data-confirm' => 'Are you sure you want to delete this coin package?',
                            'data-method' => 'post',
                        ]);
                    },
                ],
            ],
        ],
    ]);
    
    
    Pjax::end();

    
    
    ?>


</div>
    </div>
</div>
