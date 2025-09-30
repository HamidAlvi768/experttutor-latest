<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Manageusers $model */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Manageusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="page-wrapper">
    <div class="content">
        <div class="manageusers-view">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="mb-0"><?= Html::encode($this->title) ?></h1>
                <div>
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary me-2']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>
            </div>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    //'id',
                    'username',
                    'email:email',
                    'role',
                    
                    //'password_hash',
                    'user_status',
                    'verification',
                   // 'authKey',
                   // 'accessToken',
//                    'active',
                   // 'deleted',
                    'created_at',
 
                ],
            ]) ?>

        </div>
    </div>
</div>
