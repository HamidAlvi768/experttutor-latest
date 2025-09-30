<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\GenericRecords $model */

$this->title = 'Create Generic Records';
$this->params['breadcrumbs'][] = ['label' => 'Generic Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-wrapper">
    <div class="content">
<div class="generic-records-create col-lg-8 offset-lg-2">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
