<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\GeneralSetting $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="page-wrapper">
    <div class="content">
            <div class="col-lg-8 offset-lg-2">

                        <h1 class="card-ti">Email Settings</h1>

                        <?php if(Yii::$app->session->getFlash('success')){?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= Yii::$app->session->getFlash('success') ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <?php }?>
                        
                    
                    

                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'host')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'port')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'smtpsecure')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

                         <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>
                          <?= $form->field($model, 'sender_email')->textInput(['maxlength' => true]) ?>
                           <?= $form->field($model, 'receiver_email')->textInput(['maxlength' => true]) ?>

                        <div class="form-group mt-3">
                            <?= Html::submitButton('Save Settings', ['class' => 'btn btn-success']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                </div>  
    </div>
</div>
