<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\Helper;

$this->title = 'Teacher Subjects';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profiles-create2">
    <div class="container">
    <div class="wizard-container">
        <?php echo $this->render('_sidebar'); ?>
        <div class="wizard-content">
            
  
                <?php $form = ActiveForm::begin(['options' => ['class' => 'wizard-form-container', 'id' => 'subject-form']]); ?>
                <h2 class="wizard-section-title">Subject you Teach</h2>
                <div class="subject-form-container">
                    <div class="subject-form-group">
                        <?= $form->field($model, 'subject[]', [
                            'template' => '<label class="subject-label" for="subject-0">Subject</label>{input}{error}',
                            'options' => ['tag' => false],
                        ])->dropDownList(
                                 \yii\helpers\ArrayHelper::map(Helper::getGenericRecord('subject'), 'title', 'title'),
                         [
                            'prompt' => 'Select subject',
                            'class' => 'wizard-form-control wizard-select-control subject-select',
                            'id' => 'subject-0',
                            'required' => true
                        ]) ?>
                    </div>
                    <div class="level-form-container">
                        <div class="level-form-group">
                            <?= $form->field($model, 'from_level[]', [
                                'template' => '<label class="subject-label" for="from-level-0">From level</label>{input}{error}',
                                'options' => ['tag' => false],
                            ])->dropDownList([
                                '' => '-Select lowest level-',
                                'beginner' => 'Beginner',
                                'elementary' => 'Elementary',
                                'intermediate' => 'Intermediate',
                                'upper_intermediate' => 'Upper Intermediate',
                                'advanced' => 'Advanced',
                                'proficient' => 'Proficient',
                            ], [
                                'class' => 'wizard-form-control wizard-select-control level-select',
                                'id' => 'from-level-0',
                                'required' => true
                            ]) ?>
                        </div>
                        <div class="level-form-group">
                            <?= $form->field($model, 'to_level[]', [
                                'template' => '<label class="subject-label" for="to-level-0">To level</label>{input}{error}',
                                'options' => ['tag' => false],
                            ])->dropDownList([
                                '' => '-Select High level-',
                                'beginner' => 'Beginner',
                                'elementary' => 'Elementary',
                                'intermediate' => 'Intermediate',
                                'upper_intermediate' => 'Upper Intermediate',
                                'advanced' => 'Advanced',
                                'proficient' => 'Proficient',
                            ], [
                                'class' => 'wizard-form-control wizard-select-control level-select',
                                'id' => 'to-level-0',
                                'required' => true
                            ]) ?>
                        </div>
                    </div>
                    <button type="button" class="btn-add-subject">
                        <span>Add Further Subject</span>
                        <i class="fas fa-plus"></i>
                    </button>
                    <div id="additional-subjects-container"></div>
                </div>
                <div class="wizard-form-actions">
                    <?= Html::submitButton('Save', ['class' => 'btn-save']) ?>
                </div>
                <?php ActiveForm::end(); ?>
           
        </div>
    </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add Subject Functionality
    const addSubjectBtn = document.querySelector('.btn-add-subject');
    const additionalSubjectsContainer = document.getElementById('additional-subjects-container');
    let subjectCount = 1;
    if (addSubjectBtn && additionalSubjectsContainer) {
        addSubjectBtn.addEventListener('click', function() {
            const newSubjectSection = document.createElement('div');
            newSubjectSection.className = 'subject-section';
            newSubjectSection.setAttribute('data-index', subjectCount);
            newSubjectSection.innerHTML = `
                <div class=\"subject-form-group\">
                    <label for=\"subject-${subjectCount}\" class=\"subject-label\">Subject</label>
                    <select class=\"wizard-form-control wizard-select-control subject-select\" id=\"subject-${subjectCount}\" name=\"subject[]\" required>
                        <option value=\"\" selected disabled>Set Language</option>
                        <option value=\"english\">English</option>
                        <option value=\"mathematics\">Mathematics</option>
                        <option value=\"science\">Science</option>
                        <option value=\"history\">History</option>
                        <option value=\"geography\">Geography</option>
                        <option value=\"physics\">Physics</option>
                        <option value=\"chemistry\">Chemistry</option>
                        <option value=\"biology\">Biology</option>
                        <option value=\"computer_science\">Computer Science</option>
                        <option value=\"economics\">Economics</option>
                        <option value=\"business_studies\">Business Studies</option>
                        <option value=\"art\">Art</option>
                        <option value=\"music\">Music</option>
                        <option value=\"physical_education\">Physical Education</option>
                    </select>
                </div>
                <div class=\"level-form-container\">
                    <div class=\"level-form-group\">
                        <label for=\"from-level-${subjectCount}\" class=\"subject-label\">From level</label>
                        <select class=\"wizard-form-control wizard-select-control level-select\" id=\"from-level-${subjectCount}\" name=\"from_level[]\" required>
                            <option value=\"\" selected disabled>-Select lowest level-</option>
                            <option value=\"beginner\">Beginner</option>
                            <option value=\"elementary\">Elementary</option>
                            <option value=\"intermediate\">Intermediate</option>
                            <option value=\"upper_intermediate\">Upper Intermediate</option>
                            <option value=\"advanced\">Advanced</option>
                            <option value=\"proficient\">Proficient</option>
                        </select>
                    </div>
                    <div class=\"level-form-group\">
                        <label for=\"to-level-${subjectCount}\" class=\"subject-label\">To level</label>
                        <select class=\"wizard-form-control wizard-select-control level-select\" id=\"to-level-${subjectCount}\" name=\"to_level[]\" required>
                            <option value=\"\" selected disabled>-Select High level-</option>
                            <option value=\"beginner\">Beginner</option>
                            <option value=\"elementary\">Elementary</option>
                            <option value=\"intermediate\">Intermediate</option>
                            <option value=\"upper_intermediate\">Upper Intermediate</option>
                            <option value=\"advanced\">Advanced</option>
                            <option value=\"proficient\">Proficient</option>
                        </select>
                    </div>
                </div>
                <button type=\"button\" class=\"btn-remove-subject\"><i class=\"fas fa-times\"></i> Remove</button>
            `;
            additionalSubjectsContainer.appendChild(newSubjectSection);
            // Remove functionality
            const removeBtn = newSubjectSection.querySelector('.btn-remove-subject');
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    newSubjectSection.remove();
                });
            }
            subjectCount++;
        });
    }
    // Remove for any pre-existing (if rendered from backend)
    document.querySelectorAll('.btn-remove-subject').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.subject-section').remove();
        });
    });
});
</script>

