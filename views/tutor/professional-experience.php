<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Teacher Professional Experience';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Ensure at least one entry is shown if none exist
if (empty($existing_prof_exp)) {
    // Create a dummy object with empty properties for the form
    $emptyModel = (object) [
        'organization' => '',
        'designation' => '',
        'start_date' => '',
        'end_date' => '',
        'association' => '',
        'job_role' => '',
    ];
    $existing_prof_exp = [$emptyModel];
}
?>

<div class="teacher-experience-create">
    <div class="container">
        <div class="wizard-container">
            <?= $this->render('_sidebar'); ?>
            <div class="wizard-content">
                <div class="teacher-experience-form professional-form-container">
                    <h2 class="wizard-section-title">Professional Experience</h2>
                    <?php $form = ActiveForm::begin(['options' => ['class' => 'wizard-form', 'id' => 'experience-form']]); ?>
                     <?= $form->errorSummary($model) ?>
                    
                    <div class="professional-form-container">
                        <div id="experience-entries ">
                            <?php foreach ($existing_prof_exp as $i => $model): ?>
                                <div class="experience-entry <?= $i > 0 ? ' additional-entry' : '' ?>" data-index="<?= $i ?>">
                                    <div class="wizard-form-group full-width">
                                        <label class="subject-label">Organization With City</label>
                                        <?= Html::textInput('TeacherProfessionalExperience[organization][]', $model->organization, [
                                            'class' => 'wizard-form-control',
                                            'placeholder' => 'Enter Name',
                                            'required' => true,
                                        ]) ?>
                                    </div>

                                    <div class="wizard-form-group full-width">
                                        <label class="subject-label">Designation</label>
                                        <?= Html::textInput('TeacherProfessionalExperience[designation][]', $model->designation, [
                                            'class' => 'wizard-form-control',
                                            'placeholder' => 'Enter Designation',
                                            'required' => true,
                                        ]) ?>
                                    </div>

                                    <div class="form-row">
                                        <div class="wizard-form-group half-width">
                                            <label class="subject-label">Start Date</label>
                                            <?= Html::input('date', 'TeacherProfessionalExperience[start_date][]', $model->start_date, [
                                                'class' => 'wizard-form-control',
                                                'required' => true,
                                            ]) ?>
                                        </div>
                                        <div class="wizard-form-group half-width">
                                            <label class="subject-label">End Date</label>
                                            <?= Html::input('date', 'TeacherProfessionalExperience[end_date][]', $model->end_date, [
                                                'class' => 'wizard-form-control',
                                            ]) ?>
                                        </div>
                                    </div>

                                    <div class="wizard-form-group full-width">
                                        <label class="subject-label">Association</label>
                                        <?= Html::dropDownList('TeacherProfessionalExperience[association][]', $model->association, [
                                            '' => 'Select',
                                            'full_time' => 'Full Time',
                                            'part_time' => 'Part Time',
                                            'contract' => 'Contract',
                                            'freelance' => 'Freelance',
                                        ], ['class' => 'wizard-form-control', 'required' => true]) ?>
                                    </div>

                                    <div class="wizard-form-group full-width">
                                        <label class="subject-label">Your Role and Responsibility</label>
                                        <?= Html::textarea('TeacherProfessionalExperience[job_role][]', $model->job_role, [
                                            'class' => 'wizard-form-control',
                                            'placeholder' => 'Describe',
                                            'rows' => 4,
                                        ]) ?>
                                    </div>
                                    <?php if ($i > 0): ?>
                                <button type="button" class="btn-remove-experience">
                                    <i class="fas fa-times"></i> Remove
                                </button>
                            <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div id="additional-experience-entries"></div>

                        <button type="button" class="btn-add-experience" id="add-experience">
                            <span>Add Further Experience</span>
                            <i class="fas fa-plus"></i>
                        </button>
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
document.addEventListener('DOMContentLoaded', function () {
    const today = new Date().toISOString().split('T')[0]; // yyyy-mm-dd
    const addExperienceBtn = document.getElementById('add-experience');
    const additionalExperienceContainer = document.getElementById('additional-experience-entries');

    // ✅ Date validation function
    function validateDates(startInput, endInput) {
        const start = startInput.value;
        const end = endInput.value;

        if (start && start > today) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Start Date',
                text: "Start date can't be in the future",
                confirmButtonText: 'OK'
            }).then(() => startInput.value = '');
            return;
        }

        if (end && end > today) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid End Date',
                text: "End date can't be in the future",
                confirmButtonText: 'OK'
            }).then(() => endInput.value = '');
            return;
        }

        if (start && end && end < start) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Date Range',
                text: "End date can't be before start date",
                confirmButtonText: 'OK'
            }).then(() => endInput.value = '');
        }
    }

    // ✅ Attach validation listeners
    function attachDateValidation(startInput, endInput) {
        startInput.addEventListener('change', () => validateDates(startInput, endInput));
        endInput.addEventListener('change', () => validateDates(startInput, endInput));
    }

    // 🔁 Attach remove + validation handlers to all existing entries
    document.querySelectorAll('.experience-entry').forEach(entry => {
        const removeBtn = entry.querySelector('.btn-remove-experience');
        if (removeBtn) {
            removeBtn.addEventListener('click', () => entry.remove());
        }
        const startInput = entry.querySelector('input[name="TeacherProfessionalExperience[start_date][]"]');
        const endInput = entry.querySelector('input[name="TeacherProfessionalExperience[end_date][]"]');
        if (startInput && endInput) attachDateValidation(startInput, endInput);
    });

    // ➕ Add new experience section
    addExperienceBtn.addEventListener('click', function () {
        const newEntry = document.createElement('div');
        newEntry.classList.add('experience-entry', 'additional-entry');
        newEntry.innerHTML = `
            <div class="wizard-form-group full-width">
                <label class="subject-label">Organization With City</label>
                <input type="text" name="TeacherProfessionalExperience[organization][]" class="wizard-form-control" placeholder="Enter Name" required>
            </div>
            <div class="wizard-form-group full-width">
                <label class="subject-label">Designation</label>
                <input type="text" name="TeacherProfessionalExperience[designation][]" class="wizard-form-control" placeholder="Enter Designation" required>
            </div>
            <div class="form-row">
                <div class="wizard-form-group half-width">
                    <label class="subject-label">Start Date</label>
                    <input type="date" name="TeacherProfessionalExperience[start_date][]" class="wizard-form-control" required>
                </div>
                <div class="wizard-form-group half-width">
                    <label class="subject-label">End Date</label>
                    <input type="date" name="TeacherProfessionalExperience[end_date][]" class="wizard-form-control">
                </div>
            </div>
            <div class="wizard-form-group full-width">
                <label class="subject-label">Association</label>
                <select name="TeacherProfessionalExperience[association][]" class="wizard-form-control" required>
                    <option value="">Select</option>
                    <option value="full_time">Full Time</option>
                    <option value="part_time">Part Time</option>
                    <option value="contract">Contract</option>
                    <option value="freelance">Freelance</option>
                </select>
            </div>
            <div class="wizard-form-group full-width">
                <label class="subject-label">Your Role and Responsibility</label>
                <textarea name="TeacherProfessionalExperience[job_role][]" class="wizard-form-control" rows="4" placeholder="Describe"></textarea>
            </div>
            <button type="button" class="btn-remove-experience"><i class="fas fa-times"></i> Remove</button>
        `;

        additionalExperienceContainer.appendChild(newEntry);

        // Remove button
        const removeBtn = newEntry.querySelector('.btn-remove-experience');
        if (removeBtn) {
            removeBtn.addEventListener('click', () => newEntry.remove());
        }

        // Attach validation to new inputs
        const startInput = newEntry.querySelector('input[name="TeacherProfessionalExperience[start_date][]"]');
        const endInput = newEntry.querySelector('input[name="TeacherProfessionalExperience[end_date][]"]');
        if (startInput && endInput) attachDateValidation(startInput, endInput);
    });
});
</script>
