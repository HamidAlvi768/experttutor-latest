<?php

use app\components\Helper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Teacher Education';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .education-form-container {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .education-entry {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .additional-entry {
        border-top: 1px solid #e9ecef;
        padding-top: 25px;
        margin-top: 10px;
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
        pointer-events: none;
    }

    .optional-label {
        color: #6c757d;
        font-size: 14px;
    }

    .btn-remove-education {
        background-color: #f8f9fa;
        color: #dc3545;
        border: 1px solid #dc3545;
        border-radius: 8px;
        padding: 8px 15px;
        font-size: 14px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        margin-top: 10px;
    }

        .select2-container--default .select2-selection--single {
    width: 100% !important;
    padding: 12px 15px  !important ;
    border: 1px solid #ddd !important;
    border-radius: 8px !important;
    font-size: 14px !important;
    transition: all 0.3s !important;
    background-color: #F3F3F3 !important;
    color: #140489 !important;
        }

</style>


<div class="teacher-education-create">
    <div class="container">
        <div class="wizard-container">
            <?php echo $this->render('_sidebar'); ?>
            <div class="wizard-content">
                <h2 class="wizard-section-title">Education / Experience</h2>
                <?php $form = ActiveForm::begin(['id' => 'education-form', 'options' => ['autocomplete' => 'off']]); ?>
                 <?= $form->errorSummary($model) ?>
                <div class="education-form-container">
                    <div id="education-entries">
                        <?php
                        //var_dump($educations);die;
                        // /$educations = is_array($model) ? $model : [$model];

                        foreach ($educations as $i => $education) {
                        ?>
                            <div class="education-entry <?= $i > 0 ? ' additional-entry' : '' ?>" data-index="<?= $i ?>">
                                <div class="wizard-form-group full-width">
                                    <label class="subject-label">Institute Name with City</label>
                                    <?= Html::textInput("TeacherEducation[institute_name][]", $education->institute_name, ['class' => 'wizard-form-control', 'maxlength' => 255, 'required' => true, 'placeholder' => 'Enter Name']) ?>
                                </div>
                                <div class="form-row">
                                    <div class="wizard-form-group half-width">
                                        <label class="subject-label">Degree Type</label>
                                        <div class="custom-select-wrapper">
                                            <?= Html::dropDownList("TeacherEducation[degree_type][]", $education->degree_type, [
                                                '' => '-Degree Type-',
                                                'bachelors' => "Bachelor's",
                                                'masters' => "Master's",
                                                'phd' => 'PhD',
                                                'diploma' => 'Diploma',
                                                'certificate' => 'Certificate',

                                            ], ['class' => 'wizard-form-control wizard-select-control']) ?>
                                            <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                                        </div>
                                    </div>
                                    <div class="wizard-form-group half-width">
                                        <label class="subject-label">Degree Name</label>
                                        <div class="custom-select-wrapper">
                                            <?= Html::dropDownList(
                                                "TeacherEducation[degree_name][]",
                                                $education->degree_name,
                                                \yii\helpers\ArrayHelper::map(
                                                    Helper::getGenericRecord('degree'), // Fetch degrees dynamically
                                                    'title',   // or 'degree_name' if you want the value to be the name
                                                    'title' // Displayed text
                                                ) + ['other' => 'Other'],
                                                [
                                                    'prompt' => 'Select Degree',
                                                    'id' => 'degree-dropdown',
                                                    'class' => 'select2 wizard-form-control wizard-select-control',
                                                    'required' => true
                                                ]
                                            ) ?>



                                            <?php /*?> <?= Html::dropDownList("TeacherEducation[degree_name][]", $education->degree_name, [
                                            '' => '-Name-',
                                            'computer_science' => 'Computer Science',
                                            'business' => 'Business Administration',
                                            'engineering' => 'Engineering',
                                            'education' => 'Education',
                                            'arts' => 'Arts',
                                        ], ['class' => 'wizard-form-control wizard-select-control']) ?>
                                        <?php */ ?>
                                            <!-- <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div> -->
                                        </div>
                                    </div>

                                </div>
                                    <div class="wizard-form-group full-width" id="other-degree-field" style="display:<?= ($education->degree_name=='other')? 'block' : 'none' ?>;">
                                        <label class="subject-label">Other Subject</label>
                                        <?= Html::textInput("TeacherEducation[other_degree_name][]", $education->other_degree_name, [
                                            'class' => 'wizard-form-control',
                                            'maxlength' => 255,
                                            'placeholder' => 'Enter your Degree Name'
                                        ]) ?>
                                    </div>
                                <div class="form-row">
                                    <div class="wizard-form-group half-width">
                                        <label class="subject-label">Start Date</label>
                                        <?= Html::input('date', "TeacherEducation[start_date][]", $education->start_date, ['class' => 'wizard-form-control date-picker', 'required' => true]) ?>
                                    </div>
                                    <div class="wizard-form-group half-width">
                                        <label class="subject-label">End Date</label>
                                        <?= Html::input('date', "TeacherEducation[end_date][]", $education->end_date, ['class' => 'wizard-form-control date-picker']) ?>
                                    </div>
                                </div>
                                <div class="wizard-form-group full-width">
                                    <label class="subject-label">Association</label>
                                    <div class="custom-select-wrapper">
                                        <?= Html::dropDownList("TeacherEducation[association][]", $education->association, [
                                            '' => 'Select',
                                            'student' => 'Student',
                                            'alumni' => 'Alumni',
                                            'faculty' => 'Faculty',
                                            'staff' => 'Staff',
                                        ], ['class' => 'wizard-form-control wizard-select-control']) ?>
                                        <div class="dropdown-icon"><i class="fas fa-chevron-down"></i></div>
                                    </div>
                                </div>
                                <div class="wizard-form-group full-width">
                                    <label class="subject-label">Specialization<span class="optional-label">(optional)</span></label>
                                    <div class="custom-select-wrapper">
                                        <?= Html::textInput("TeacherEducation[specialization][]", $education->specialization, ['class' => 'wizard-form-control ']) ?>
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
                    <button type="button" class="btn-add-subject" id="add-education">
                        <span>Add education</span>
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="wizard-form-actions">
                    <?= Html::submitButton('Save', ['class' => 'btn-save', 'id' => 'save-education']) ?>

                    <?php /*?><button type="button" class="btn-next" id="next-step" data-next-step="professional-experience">Next</button>
                    <?php */ ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>


<!-- <script>
document.addEventListener('DOMContentLoaded', function() {
    const addEducationBtn = document.getElementById('add-education');
    const educationEntries = document.getElementById('education-entries');
    let educationCount = educationEntries.querySelectorAll('.education-entry').length;

    function attachRemoveHandlers() {
        document.querySelectorAll('.btn-remove-education').forEach(btn => {
            btn.onclick = function () {
                btn.closest('.education-entry').remove();
            };
        });
    }

    if (addEducationBtn && educationEntries) {
        addEducationBtn.addEventListener('click', function() {
            const firstEntry = educationEntries.querySelector('.education-entry');
            const newEntry = firstEntry.cloneNode(true);

            // Reset field values
            newEntry.querySelectorAll('input, select').forEach(el => el.value = '');

            // Add "Remove" button if not present
            if (!newEntry.querySelector('.btn-remove-education')) {
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn-remove-education';
                removeBtn.innerHTML = '<i class="fas fa-times"></i> Remove';
                removeBtn.onclick = function () {
                    newEntry.remove();
                };
                newEntry.appendChild(removeBtn);
            }

            newEntry.classList.add('additional-entry');
            educationEntries.appendChild(newEntry);
            educationCount++;
            attachRemoveHandlers();
        });
    }

    attachRemoveHandlers();
});
</script> -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0]; // yyyy-mm-dd
        const addEducationBtn = document.getElementById('add-education');
        const educationEntries = document.getElementById('education-entries');

        // ✅ Validation function
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

        // ✅ Attach validation events to a row
        function attachDateValidation(row) {
            const startInput = row.querySelector('input[name="TeacherEducation[start_date][]"]');
            const endInput = row.querySelector('input[name="TeacherEducation[end_date][]"]');
            if (startInput && endInput) {
                startInput.addEventListener('change', () => validateDates(startInput, endInput));
                endInput.addEventListener('change', () => validateDates(startInput, endInput));
            }
        }

        // ✅ Attach remove button handlers
        function attachRemoveHandlers() {
            document.querySelectorAll('.btn-remove-education').forEach(btn => {
                btn.onclick = function() {
                    btn.closest('.education-entry').remove();
                };
            });
        }

        // Initial setup for existing rows
        document.querySelectorAll('.education-entry').forEach(row => {
            attachRemoveHandlers();
            attachDateValidation(row);
        });

        // ➕ Add new education row
        if (addEducationBtn && educationEntries) {
            addEducationBtn.addEventListener('click', function() {
                const firstEntry = educationEntries.querySelector('.education-entry');
                const newEntry = firstEntry.cloneNode(true);

                // Reset all input/select values
                newEntry.querySelectorAll('input, select').forEach(el => el.value = '');

                // Add "Remove" button if missing
                if (!newEntry.querySelector('.btn-remove-education')) {
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'btn-remove-education';
                    removeBtn.innerHTML = '<i class="fas fa-times"></i> Remove';
                    removeBtn.onclick = function() {
                        newEntry.remove();
                    };
                    newEntry.appendChild(removeBtn);
                }

                newEntry.classList.add('additional-entry');
                educationEntries.appendChild(newEntry);

                attachRemoveHandlers();
                attachDateValidation(newEntry);
            });
        }
    });
</script>

<?php
$js = <<<JS
    $('#degree-dropdown').on('change', function() {
        if ($(this).val() === 'other') {
            $('#other-degree-field').show();
           // $('#other-degree-field input').prop('required', true);
        } else {
            $('#other-degree-field input')
                .prop('required', false) // remove required first
                .val('');
            $('#other-degree-field').hide(); // then hide
        }
    });
JS;
$this->registerJs($js);
?>



<?php
$js = <<<JS
$('#degree-dropdown').select2({
    placeholder: "Select Degree Name",
});
JS;
$this->registerJs($js);
?>