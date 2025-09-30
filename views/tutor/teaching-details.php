<?php

use app\components\Helper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Teacher Teaching Details';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teacher-teaching-details-create">
    <div class="container">
        <div class="wizard-container">
            <?php echo $this->render('_sidebar'); ?>
            <div class="wizard-content">

                <div class="teacher-teaching-details-form">
                    <h2 class="wizard-section-title">Teaching Details</h2>
                    <?php if (Yii::$app->session->hasFlash('success')): ?>
                        <div class="alert alert-success">
                            <?= Yii::$app->session->getFlash('success') ?>
                        </div>
                    <?php endif; ?>
                    <?php $form = ActiveForm::begin(['options' => ['class' => 'wizard-form', 'id' => 'teaching-details-form']]); ?>
                    <?= $form->errorSummary($model) ?>
                    <div class="teaching-form-container">
                        <div class="form-row three-equal">
                            <div class="wizard-form-group">
                                <label class="subject-label">I Charge</label>
                                <?= $form->field($model, 'charge_type', [
                                    'template' => '{input}{error}',
                                    'options' => ['tag' => false],
                                ])->dropDownList([
                                    'Hourly' => 'Hourly',
                                    'Daily' => 'Daily',
                                    'Weekly' => 'Weekly',
                                    'Monthly' => 'Monthly',
                                ], [
                                    'class' => 'wizard-form-control wizard-select-control',
                                    'id' => 'charge-type',
                                    'prompt' => 'Select Charge Type',
                                    'required' => true
                                ]) ?>
                            </div>
                            <div class="wizard-form-group">
                                <label class="subject-label">Min Fee  (<?= Helper::getCurrency() ?>)</label>
                                <?= $form->field($model, 'minimum_fee', [
                                    'template' => '{input}<div class="invalid-feedback">{error}</div>',
                                    'options' => ['tag' => false],
                                ])->textInput([
                                    'type' => 'number',
                                    'class' => 'wizard-form-control' . ($model->hasErrors('minimum_fee') ? ' is-invalid' : ''),
                                    'id' => 'min-fee',
                                    'placeholder' => 'Min Fee',
                                    'min' => 0,
                                    'step' => '0.01',
                                    'required' => true,
                                    'oninput' => 'validateMinFee(this)'
                                ]) ?>
                            </div>
                            <div class="wizard-form-group">
                                <label class="subject-label">Max Fee  (<?= Helper::getCurrency() ?>)</label>
                                <?= $form->field($model, 'maximum_fee', [
                                    'template' => '{input}<div class="invalid-feedback">{error}</div>',
                                    'options' => ['tag' => false],
                                ])->textInput([
                                    'type' => 'number',
                                    'class' => 'wizard-form-control' . ($model->hasErrors('maximum_fee') ? ' is-invalid' : ''),
                                    'id' => 'max-fee',
                                    'placeholder' => 'Max Fee',
                                    'min' => 0,
                                    'step' => '0.01',
                                    'required' => true,
                                    'oninput' => 'validateMaxFee(this)'
                                ]) ?>
                            </div>
                        </div>
                        <div class="wizard-form-group full-width">
                            <label class="subject-label">Fee Details</label>
                            <div class="custom-select-wrapper">
                                <?= $form->field($model, 'fee_details', [
                                    'template' => '{input}{error}',
                                    'options' => ['tag' => false],
                                ])->textInput([
                                    'class' => 'wizard-form-control',
                                    'id' => 'fee-details',
                                    'placeholder' => 'Detail',
                                ]) ?>

                            </div>
                        </div>
                        <div class="wizard-form-group full-width">
                            <label class="subject-label">Total Experience</label>
                            <?= $form->field($model, 'total_experience', [
                                'template' => '{input}{error}',
                                'options' => ['tag' => false],
                            ])->dropDownList(
                                array_combine(range(1, 30), array_map(function ($i) {
                                    return $i . ($i == 1 ? ' Year' : ' Years');
                                }, range(1, 30))),
                                [
                                    'class' => 'wizard-form-control wizard-select-control',
                                    'id' => 'total-experience',
                                    'prompt' => 'Year',
                                    'required' => true
                                ]
                            ) ?>
                        </div>
                        <div class="wizard-form-group full-width">
                            <label class="subject-label">Teaching Experience</label>
                            <?= $form->field($model, 'teaching_experience', [
                                'template' => '{input}{error}',
                                'options' => ['tag' => false],
                            ])->dropDownList(
                                array_combine(range(1, 30), array_map(function ($i) {
                                    return $i . ($i == 1 ? ' Year' : ' Years');
                                }, range(1, 30))),
                                [
                                    'class' => 'wizard-form-control wizard-select-control',
                                    'id' => 'teaching-experience',
                                    'prompt' => 'Year',
                                    'required' => true
                                ]
                            ) ?>
                        </div>
                        <div class="wizard-form-group full-width">
                            <label class="subject-label">Online Teaching Experience</label>
                            <?= $form->field($model, 'online_teaching_experience', [
                                'template' => '{input}{error}',
                                'options' => ['tag' => false],
                            ])->dropDownList(
                                array_combine(range(1, 30), array_map(function ($i) {
                                    return $i . ($i == 1 ? ' Year' : ' Years');
                                }, range(1, 30))),
                                [
                                    'class' => 'wizard-form-control wizard-select-control',
                                    'id' => 'online-teaching-experience',
                                    'prompt' => 'Year',
                                    'required' => true
                                ]
                            ) ?>
                        </div>
                        <div class="wizard-form-group full-width">
                            <label class="subject-label">Are You Willing to travel to Student?</label>
                            <div class="radio-options">
                                <div class="radio-option">
                                    <input type="radio" id="travel-yes" name="travel_to_student" value="1" <?= $model->travel_to_student == 1 ? 'checked' : '' ?>>
                                    <label for="travel-yes">Yes</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="travel-no" name="travel_to_student" value="0" <?= $model->travel_to_student === 0 ? 'checked' : '' ?>>
                                    <label for="travel-no">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-form-group full-width">
                            <label class="subject-label">Available for online?</label>
                            <div class="radio-options">
                                <div class="radio-option">
                                    <input type="radio" id="online-yes" name="available_for_online" value="1" <?= $model->available_for_online == 1 ? 'checked' : '' ?>>
                                    <label for="online-yes">Yes</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="online-no" name="available_for_online" value="0" <?= $model->available_for_online === 0 ? 'checked' : '' ?>>
                                    <label for="online-no">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-form-group full-width">
                            <label class="subject-label">Do you have digital pen?</label>
                            <div class="radio-options">
                                <div class="radio-option">
                                    <input type="radio" id="digital-pen-yes" name="digital_pen" value="1" <?= $model->digital_pen == 1 ? 'checked' : '' ?>>
                                    <label for="digital-pen-yes">Yes</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="digital-pen-no" name="digital_pen" value="0" <?= $model->digital_pen === 0 ? 'checked' : '' ?>>
                                    <label for="digital-pen-no">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-form-group full-width">
                            <label class="subject-label">Do you help with homework or assignment?</label>
                            <div class="radio-options">
                                <div class="radio-option">
                                    <input type="radio" id="homework-yes" name="help_work_assignments" value="1" <?= $model->help_work_assignments == 1 ? 'checked' : '' ?>>
                                    <label for="homework-yes">Yes</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="homework-no" name="help_work_assignments" value="0" <?= $model->help_work_assignments === 0 ? 'checked' : '' ?>>
                                    <label for="homework-no">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-form-group full-width">
                            <label class="subject-label">Are you current working at any school at full time?</label>
                            <div class="radio-options">
                                <div class="radio-option">
                                    <input type="radio" id="school-yes" name="working_at_school" value="1" <?= $model->working_at_school == 1 ? 'checked' : '' ?>>
                                    <label for="school-yes">Yes</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="school-no" name="working_at_school" value="0" <?= $model->working_at_school === 0 ? 'checked' : '' ?>>
                                    <label for="school-no">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="wizard-form-group full-width">
                            <label class="subject-label">Opportunity are you interested</label>
                            <?= $form->field($model, 'opportunity_interested', [
                                'template' => '{input}{error}',
                                'options' => ['tag' => false],
                            ])->dropDownList([
                                'Online tutoring' => 'Online tutoring',
                                'Assignment help' => 'Assignment help',
                                //'Research Assistance' => 'Research Assistance',
                                'Both' => 'Both',
                            ], [
                                'class' => 'wizard-form-control wizard-select-control',
                                'id' => 'interested-opportunity',
                                'prompt' => 'Select Opportunity',
                                'required' => true
                            ]) ?>
                        </div>
                        <div class="wizard-form-group full-width">
                            <label class="subject-label">Communication language</label>
                            <?= $form->field($model, 'communication_language', [
                                'template' => '{input}{error}',
                                'options' => ['tag' => false],
                            ])->dropDownList(ArrayHelper::map(Helper::getGenericRecord('language'), 'title', 'title'), [
                                'class' => 'wizard-form-control wizard-select-control select2',
                                'multiple' => 'multiple',
                                'id' => 'communication-language',
                                'prompt' => 'Select Communication Language',
                                'required' => true
                            ]) ?>
                        </div>
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

<script>
    function validateMinFee(input) {
        const minFee = parseFloat(input.value);
        const maxFeeInput = document.getElementById('max-fee');
        const maxFee = parseFloat(maxFeeInput.value);

        if (minFee < 0) {
            input.setCustomValidity('Minimum fee cannot be negative');
            input.classList.add('is-invalid');
        } else if (maxFee && minFee > maxFee) {
            input.setCustomValidity('Minimum fee cannot be greater than maximum fee');
            input.classList.add('is-invalid');
        } else {
            input.setCustomValidity('');
            input.classList.remove('is-invalid');
        }
    }

    function validateMaxFee(input) {
        const maxFee = parseFloat(input.value);
        const minFeeInput = document.getElementById('min-fee');
        const minFee = parseFloat(minFeeInput.value);

        if (maxFee < 0) {
            input.setCustomValidity('Maximum fee cannot be negative');
            input.classList.add('is-invalid');
        } else if (minFee && maxFee < minFee) {
            input.setCustomValidity('Maximum fee cannot be less than minimum fee');
            input.classList.add('is-invalid');
        } else {
            input.setCustomValidity('');
            input.classList.remove('is-invalid');
        }
    }

    // Add event listeners for real-time validation
    document.addEventListener('DOMContentLoaded', function() {
        const minFeeInput = document.getElementById('min-fee');
        const maxFeeInput = document.getElementById('max-fee');

        if (minFeeInput) {
            minFeeInput.addEventListener('input', function() {
                validateMinFee(this);
            });
        }

        if (maxFeeInput) {
            maxFeeInput.addEventListener('input', function() {
                validateMaxFee(this);
            });
        }
    });
</script>
<?php
$js = <<<JS
$('#communication-language').select2({
    placeholder: "Select Languages",
});
JS;
$this->registerJs($js);
?>