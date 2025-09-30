<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\Helper;


/** @var yii\web\View $this */
/** @var app\models\Coins $model */
/** @var yii\widgets\ActiveForm $form */
?>

<style>
.card-body .coins-form .form-control {
    background-color: #f7fafd;
    border: 1px solid #d1e3f0;
    border-radius: 6px;
    box-shadow: none;
    transition: border-color 0.2s;
}
.card-body .coins-form .form-control:focus {
    border-color: #80bdff;
    background-color: #f0f7fb;
    outline: none;
}
</style>
<div class="card">
    <div class="card-body">
        <div class="coins-form">
            <?php $form = ActiveForm::begin([
                'enableClientValidation' => true,
                'validateOnBlur' => false,
                'validateOnChange' => false,
                'validateOnType' => false,
            ]); ?>

            <?= $form->field($model, 'coin_count')->textInput() ?>

            <?php $coin_label = 'Coin Price (' . Helper::getCurrency().')'; ?>
            <?= $form->field($model, 'coin_price')->textInput(['maxlength' => true])->label($coin_label) ?>


            <?= $form->field($model, 'discount')->textInput([
                'type' => 'number',
                'min' => 0,
                'max' => 100
            ])->label('Discount (%)') ?>
     
    
   

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
