<?php

use app\models\Manageusers;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

use yii\widgets\Pjax;

Pjax::begin([
    'id' => 'pjax-grid',
    'timeout' => 5000,
]);


$this->params['breadcrumbs'][] = $title;
?>
<style>
    /* Ensure GridView filter selects look like dropdowns */
    tr.filters select {
        appearance: auto !important;
        -webkit-appearance: auto !important;
        -moz-appearance: auto !important;
        background: #fff !important;
        border: 1px solid #ccc !important;
        border-radius: 4px !important;
        padding: 4px 28px 4px 8px !important;
        min-width: 80px;
        font-size: 15px;
        color: #222;
        box-shadow: none;
        height: 36px;
    }


    .wallet-badge.debit {
        background: #ffeaea;
        color: #e74c3c;
    }

    .wallet-badge.credit {
        background: #e8f9f1;
        color: #2ecc71;
    }

    .wallet-badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 12px;
        /* font-size: 0.98rem;
    font-weight: 600; */
    }
</style>

<div class="page-wrapper">
    <div class="content">
        <div class="manageusers-index">



    <h1><?=  Html::encode($title) ?></h1>

    
            <p>
                
                <?= Html::a('Add New '.ucfirst($role).'', ['create?user='.$role.''], ['class' => 'btn btn-success float-end mb-2']) ?>
                <?= Html::a('Reset Filters', [Yii::$app->controller->action->id], ['class' => 'btn btn-secondary float-end mb-2 mr-2']) ?>

            </p>
            <?php
            // Start with base columns
            $columns = [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'username',
                    'filter' => true,
                     'filterInputOptions' => ['placeholder' => 'Search By Username', 'class' => 'form-control'],
                ],
                [
                    'attribute' => 'email',
                    'filter' => true,
                     'filterInputOptions' => ['placeholder' => 'Search By Email', 'class' => 'form-control'],
                ],
            ];

            // ✅ Only add the role column if $role is falsy
            if (empty($role)) {
                $columns[] = [
                    'attribute' => 'role',
                    'filter' => [
                        'student' => 'Student',
                        'tutor' => 'Tutor',
                    ],
                ];
            }

            // Add the remaining fixed columns
            $columns[] = [
                'attribute' => 'user_status',
                'label' => 'Status',
                'format' => 'raw',
                'value' => function ($model) {
                    return ($model->user_status === 'active')
                        ? '<span class="wallet-badge credit">Active</span>'
                        : '<span class="wallet-badge debit">Not Active</span>';
                },
                'filter' => [
                    'active' => 'Active',
                    'inactive' => 'Not Active',
                ],
                'filterInputOptions' => [
        'prompt' => 'Select Status' // This works like a placeholder
    ],
            ];

            $columns[] = [
                'attribute' => 'verification',
                'label' => 'Verified',
                'value' => function ($model) {
                    return ($model->verification == 1) ? 'Yes' : 'No';
                },
                'filter' => [
                    1 => 'Yes',
                    0 => 'No',
                ],
                     'filterInputOptions' => [
        'prompt' => 'Select Option' // This works like a placeholder
    ],
            ];

            $columns[] = [
                'attribute' => 'created_at',
                'label' => 'Joined Date',
                'format' => ['date', 'php:Y-m-d'],
                'filter' => true,
            ];

            $columns[] = [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{edit} {delete}',
                'buttons' => [
                    'edit' => function ($url, $model, $key) {
                        return Html::a('Edit', ['manageusers/update', 'id' => $model->id,'user'=>$model->role], [
                            'class' => 'btn btn-sm btn-primary mb-2',
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('Delete', ['manageusers/delete', 'id' => $model->id], [
                            'class' => 'btn btn-sm btn-danger mb-2',
                            'data-confirm' => 'Are you sure to delete this user?',
                            'data-method' => 'post',
                        ]);
                    },
                    'verify' => function ($url, $model, $key) {
                        return !$model->verification
                            ? Html::a('Verify', ['manageusers/verify', 'id' => $model->id], [
                                'class' => 'btn btn-sm btn-success',
                            ])
                            : Html::tag('span', 'Verified', [
                                'class' => 'btn btn-sm btn-outline-success disabled',
                            ]);
                    },
                ],
                
            ];
            ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $columns,
            ]); ?>


        </div>
    </div>
</div>
<?php 
Pjax::end();
?>