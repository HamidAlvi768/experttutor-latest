<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Coins $model */

$this->title = 'Update Coins';
$this->params['breadcrumbs'][] = ['label' => 'Coins', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="page-wrapper">
    <div class="content">
<div class="coins-update col-lg-8 offset-lg-2">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
    </div>
</div>
