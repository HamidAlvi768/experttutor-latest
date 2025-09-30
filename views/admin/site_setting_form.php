<?php

use app\components\Helper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\GeneralSetting $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="page-wrapper">
    <div class="content">
            <div class="col-lg-8 offset-lg-2">

                        <h1 class="card-ti">Site Settings</h1>
                    
                                            <?php if(Yii::$app->session->getFlash('success')){?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= Yii::$app->session->getFlash('success') ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <?php }?>

                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'site_name')->textInput(['maxlength' => true]) ?>

                          <?php if($model->site_logo):?>
                        <img class="mb-2" src="<?= Helper::baseUrl(). $model->site_logo ?>" alt="Site Logo" style="max-width: 200px; max-height: 100px;"/>
                        <?php endif;?>


                        <?= $form->field($model, 'site_logo')->fileInput(['class'=> 'form-control']) ?>

                        <?php if($model->site_logo_white):?>
                        <img class="mb-2" src="<?= Helper::baseUrl(). $model->site_logo_white ?>" alt="Site Logo" style="max-width: 200px; max-height: 100px;"/>
                        <?php endif;?>


                        <?= $form->field($model, 'site_logo_white')->fileInput(['class'=> 'form-control']) ?>

                      

                        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'contacts')->textInput(['maxlength' => true]) ?>



                        <h4>Social Media</h4>
                       <?= $form->field($model, 'social_fb')->input('url', ['maxlength' => true, 'placeholder' => 'https://facebook.com/yourpage']) ?>
                        <?= $form->field($model, 'social_li')->input('url', ['maxlength' => true, 'placeholder' => 'https://linkedin.com/in/username']) ?>
                        <?= $form->field($model, 'social_tw')->input('url', ['maxlength' => true, 'placeholder' => 'https://twitter.com/username']) ?>
                        <?= $form->field($model, 'social_ig')->input('url', ['maxlength' => true, 'placeholder' => 'https://instagram.com/username']) ?>
                        <?= $form->field($model, 'social_yt')->input('url', ['maxlength' => true, 'placeholder' => 'https://youtube.com/channel/xyz']) ?>
                        <div class="form-group mt-3">
                            <?= Html::submitButton('Save Settings', ['class' => 'btn btn-success']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                </div>  
    </div>
</div>
