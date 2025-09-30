<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Teacher Job Descrition';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-teaching-details-create">
    <div class="container">
        <div class="wizard-container">
            <?php echo $this->render('_sidebar'); ?>
            <div class="wizard-content">
                
                <div class="teacher-teaching-details-form">
                    <h2 class="wizard-section-title">Description</h2>
                    <?php if (Yii::$app->session->hasFlash('success')): ?>
                        <div class="alert alert-success">
                            <?= Yii::$app->session->getFlash('success') ?>
                        </div>
                    <?php endif; ?>
                    <?php $form = ActiveForm::begin(['options' => ['class' => 'wizard-form', 'id' => 'description-form']]); ?>
                     <?= $form->errorSummary($model) ?>
                    <div class="description-form-container">
                        <div class="wizard-form-group full-width">
                            <label class="subject-label">Your Role and responsibility at this job</label>
                            <?= $form->field($model, 'description', [
                                'template' => '{input}{error}',
                                'options' => ['tag' => false],
                            ])->textarea([
                                'class' => 'wizard-form-control',
                                'id' => 'teacher-description',
                                'rows' => 8,
                                'placeholder' => 'Describe',
                                'required' => true
                            ]) ?>
                        </div>
                        <?php /* ?>
                        <div class="wizard-form-group full-width">
                            <div class="checkbox-option">
                                <?= $form->field($model, 'privacy_agreement', [
                                    'template' => '{input} {label}{error}',
                                    'options' => ['tag' => false],
                                    'labelOptions' => ['for' => 'privacy-agreement', 'class' => 'checkbox-label'],
                                ])->checkbox([
                                    'id' => 'privacy-agreement',
                                    'label' => 'I have not share of any details like(Phone, Skype, whatsapp etc.)',
                                    'class' => 'custom-checkbox',
                                ], false) ?>
                            </div>
                        </div>
                        <?php */?>
                    </div>
                    <div class="wizard-form-actions">
                        <?= Html::submitButton('Save', ['class' => 'btn-save']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
