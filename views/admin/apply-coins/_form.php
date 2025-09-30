<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Manageusers $model */
/** @var yii\widgets\ActiveForm $form */
?>


<div class="coins-form">   
   <?php $form = ActiveForm::begin([
                            'id' => 'apply-coin-form',
                            'enableClientValidation' => true,
                        ]); ?>

                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <?= $form->field($model, 'coin_value')->textInput([
                                    'type' => 'number',
                                    'min' => 1,
                                    'class' => 'form-control',
                                ])->label('Set Apply Coin') ?>
                            </div>

                             <div class="col-md-12 mb-2">
                                <?= $form->field($model, 'member_coin_value')->textInput([
                                    'type' => 'number',
                                    'min' => 1,
                                    'class' => 'form-control',
                                ])->label('Set Member Ship Apply Coin') ?>
                            </div>

                            <div class="col-md-12">
                                <?= $form->field($model, 'country')->dropDownList(
                                    ['Default'=>'Default','Asia'=>'Asia', 'Europe'=>'Europe', 'North America'=>'North America', 'South America'=>'South America', 'Africa'=>'Africa', 'Australia'=>'Australia', 'Antarctica'=>'Antarctica'],
                                    [
                                        'class' => 'form-control select2',
                                        //'multiple' => 'multiple',
                                        'id' => 'country-dropdown',
                                        'prompt' => 'Select Region',
                                    ]
                                )->label('Set Region') ?>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
 </div>

 
<?php
$js = <<<JS
$('#country-dropdown').select2({
    placeholder: "Select Region",
});
JS;
$this->registerJs($js);
?>