<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Manageusers $model */
if(Yii::$app->request->get('user')){
$role= ucfirst( Yii::$app->request->get('user'));
}else{
    $role='User ';
}
$this->title = 'Update '.$role.': ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Manageusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="page-wrapper">
    <div class="content">
<div class="manageusers-update col-lg-8 offset-lg-2"">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>
</div>
