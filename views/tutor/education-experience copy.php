<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Teacher Education';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="teacher-education-create">
    <div class="container">
        <div class="wizard-container">
            <?php echo $this->render('_sidebar'); ?>
            <div class="wizard-content">
                <h2 class="wizard-section-title">Education / Experience</h2>
                <?php $form = ActiveForm::begin(['id' => 'education-form', 'options' => ['autocomplete' => 'off']]); ?>
                <div class="education-form-container">
                    <div id="education-entries">
                        <?php
                        // Render existing education entries from model (first entry)
                        $educations = isset($model->educations) && is_array($model->educations) && !empty($model->educations) ? $model->educations : [[
                            'institute_name' => '',
                            'degree_type' => '',
                            'degree_name' => '',
                            'start_date' => '',
                            'end_date' => '',
                            'association' => '',
                            'specialization' => ''
                        ]];
                        foreach ($educations as $i => $education) {
                        ?>
                        <div class="education-entry<?= $i > 0 ? ' additional-entry' : '' ?>" data-index="<?= $i ?>">
                            <div class="wizard-form-group full-width">
                                <label class="subject-label">Institute Name with City</label>
                                <div>
                                    <?= $form->field($model, 'institute_name[]')->textInput(['maxlength' => 255, 'required' => true, 'class' => 'wizard-form-control', 'placeholder' => 'Enter Name'])->label(false) ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="wizard-form-group half-width">
                                    <label class="subject-label">Degree Type</label>
                                    <div class="custom-select-wrapper">
                                        <?= $form->field($model, 'degree_type[]')->dropDownList([
                                            '' => '-Degree Type-',
                                            'bachelors' => "Bachelor's",
                                            'masters' => "Master's",
                                            'phd' => 'PhD',
                                            'diploma' => 'Diploma',
                                            'certificate' => 'Certificate',
                                        ], ['class' => 'wizard-form-control wizard-select-control'])->label(false) ?>
                                        <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                                    </div>
                                </div>
                                <div class="wizard-form-group half-width">
                                    <label class="subject-label">Degree Name</label>
                                    <div class="custom-select-wrapper">
                                        <?= $form->field($model, 'degree_name[]')->dropDownList([
                                            '' => '-Name-',
                                            'computer_science' => 'Computer Science',
                                            'business' => 'Business Administration',
                                            'engineering' => 'Engineering',
                                            'education' => 'Education',
                                            'arts' => 'Arts',
                                        ], ['class' => 'wizard-form-control wizard-select-control'])->label(false) ?>
                                        <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="wizard-form-group half-width">
                                    <label class="subject-label">Start Date</label>
                                    <div>
                                        <?= $form->field($model, 'start_date[]')->input('date', ['required' => true, 'class' => 'wizard-form-control date-picker', 'placeholder' => 'MM/YY/DD'])->label(false) ?>
                                    </div>
                                </div>
                                <div class="wizard-form-group half-width">
                                    <label class="subject-label">End Date</label>
                                    <div>
                                        <?= $form->field($model, 'end_date[]')->input('date', ['class' => 'wizard-form-control date-picker', 'placeholder' => 'MM/YY/DD'])->label(false) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="wizard-form-group full-width">
                                <label class="subject-label">Association</label>
                                <div class="custom-select-wrapper">
                                    <?= $form->field($model, 'association[]')->dropDownList([
                                        '' => 'Select',
                                        'student' => 'Student',
                                        'alumni' => 'Alumni',
                                        'faculty' => 'Faculty',
                                        'staff' => 'Staff',
                                    ], ['class' => 'wizard-form-control wizard-select-control'])->label(false) ?>
                                    <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                                </div>
                            </div>
                            <div class="wizard-form-group full-width">
                                <label class="subject-label">Specialization<span class="optional-label">(optional)</span></label>
                                <div class="custom-select-wrapper">
                                    <?= $form->field($model, 'specialization[]')->dropDownList([
                                        '' => 'Select',
                                        'ai' => 'Artificial Intelligence',
                                        'data_science' => 'Data Science',
                                        'software_dev' => 'Software Development',
                                        'finance' => 'Finance',
                                        'marketing' => 'Marketing',
                                    ], ['class' => 'wizard-form-control wizard-select-control'])->label(false) ?>
                                    <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                                </div>
                            </div>
                            <?php if ($i > 0): ?>
                                <button type="button" class="btn-remove-education">
                                    <i class="fas fa-times"></i> Remove
                                </button>
                            <?php endif; ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div id="additional-education-entries"></div>
                    <button type="button" class="btn-add-subject" id="add-education">
                        <span>Add Further Subject</span>
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="wizard-form-actions">
                    <?= Html::submitButton('Save', ['class' => 'btn-save', 'id' => 'save-education']) ?>
                    <button type="button" class="btn-next" id="next-step" data-next-step="professional-experience">Next</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<style>
.education-form-container {
    display: flex;
    flex-direction: column;
    gap: 25px;
}
.education-entry {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.additional-entry {
    border-top: 1px solid #e9ecef;
    padding-top: 25px;
    margin-top: 10px;
    position: relative;
}
.form-row {
    display: flex;
    gap: 20px;
}
.full-width {
    width: 100%;
}
.half-width {
    flex: 1;
}
.custom-select-wrapper {
    position: relative;
}
.dropdown-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    pointer-events: none;
}
.optional-label {
    color: #6c757d;
    font-weight: normal;
    font-size: 14px;
    margin-left: 5px;
}
.btn-remove-education {
    background-color: #f8f9fa;
    color: #dc3545;
    border: 1px solid #dc3545;
    border-radius: 8px;
    padding: 8px 15px;
    font-weight: 500;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    align-self: flex-start;
    margin-top: 10px;
}
.btn-remove-education:hover {
    background-color: #feecef;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add Education Entry Functionality
    const addEducationBtn = document.getElementById('add-education');
    const educationEntries = document.getElementById('education-entries');
    let educationCount = educationEntries.querySelectorAll('.education-entry').length;

    if (addEducationBtn && educationEntries) {
        addEducationBtn.addEventListener('click', function() {
            const newIndex = educationCount;
            const template = educationEntries.querySelector('.education-entry').cloneNode(true);
            // Reset values
            template.querySelectorAll('input, select').forEach(el => el.value = '');
            template.classList.add('additional-entry');
            template.setAttribute('data-index', newIndex);
            // Update name attributes
            template.querySelectorAll('input, select').forEach(el => {
                if (el.name) {
                    el.name = el.name.replace(/\[\d+\]/, '[' + newIndex + ']');
                }
            });
            // Add remove button if not present
            if (!template.querySelector('.btn-remove-education')) {
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn-remove-education';
                removeBtn.innerHTML = '<i class="fas fa-times"></i> Remove';
                template.appendChild(removeBtn);
            }
            educationEntries.appendChild(template);
            educationCount++;
            attachRemoveHandlers();
            initializeDatePickers();
        });
    }
    function attachRemoveHandlers() {
        document.querySelectorAll('.btn-remove-education').forEach(btn => {
            btn.onclick = function() {
                if (educationEntries.querySelectorAll('.education-entry').length > 1) {
                    btn.closest('.education-entry').remove();
                } else {
                    alert('At least one education must remain.');
                }
            };
        });
    }
    attachRemoveHandlers();
    // Date picker initialization function
    function initializeDatePickers() {
        document.querySelectorAll('.date-picker').forEach(datePicker => {
            datePicker.addEventListener('focus', function() {
                this.type = 'date';
            });
            datePicker.addEventListener('blur', function() {
                if (this.value === '') {
                    this.type = 'text';
                }
            });
        });
    }
    initializeDatePickers();
    // Next button functionality
    const nextButton = document.getElementById('next-step');
    if (nextButton) {
        nextButton.addEventListener('click', function() {
            document.getElementById('education-form').submit();
        });
    }
});
</script>