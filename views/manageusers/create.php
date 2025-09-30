<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Manageusers $model */

$role= ucfirst( Yii::$app->request->get('user'));
$this->title = 'Create '.$role.'';
$this->params['breadcrumbs'][] = ['label' => 'Manageusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-wrapper">
    <div class="content">
<div class="manageusers-create col-lg-8 offset-lg-2"">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>

