<?php

use app\models\GenericRecords;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\GenericRecords $model */
$this->title = $parentId ? GenericRecords::findOne($parentId)->title : 'Generic Records';

$this->title = 'Update '. Html::encode($this->title). ' : ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Generic Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="page-wrapper">
    <div class="content">
<div class="generic-records-update col-lg-8 offset-lg-2">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
