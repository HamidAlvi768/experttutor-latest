<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Teacher Subjects';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profiles-create2">
    <div class="container">
        <div class="wizard-container">
            <?= $this->render('_sidebar'); ?>
            <div class="wizard-content">
                <?php $form = ActiveForm::begin(['id' => 'subject-form']); ?>
                 <?= $form->errorSummary($model) ?>
                <h2 class="wizard-section-title">Subjects You Teach</h2>
                <div class="subject-form-container">
                    <?php $levels = ['beginner'=>'Beginner','elementary'=>'Elementary','intermediate'=>'Intermediate','upper_intermediate'=>'Upper Intermediate','advanced'=>'Advanced','proficient'=>'Proficient']; ?>

                    <?php foreach ($existingSubjects as $i => $es): ?>
                        <div class="subject-section" data-index="<?= $i ?>">
                            <div class="subject-form-group">
                                <label class="subject-label" for="subject-<?= $i ?>">Subject</label>
                                <select name="subject[]" id="subject-<?= $i ?>" class="wizard-form-control subject-select" required>
                                    <option value="" disabled>Select subject</option>
                                    <?php foreach ($subjects as $val => $label): ?>
                                        <option value="<?= $val ?>" <?= $es->subject == $val ? 'selected' : '' ?>><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="level-form-container">
                                <div class="level-form-group">
                                    <label for="from-level-<?= $i ?>" class="subject-label">From level</label>
                                    <select name="from_level[]" id="from-level-<?= $i ?>" class="wizard-form-control level-select" required>
                                        <option value="" disabled>Select lowest level</option>
                                        <?php foreach ($levels as $val => $label): ?>
                                            <option value="<?= $val ?>" <?= $es->from_level == $val ? 'selected' : '' ?>><?= $label ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="level-form-group">
                                    <label for="to-level-<?= $i ?>" class="subject-label">To level</label>
                                    <select name="to_level[]" id="to-level-<?= $i ?>" class="wizard-form-control level-select" required>
                                        <option value="" disabled>Select high level</option>
                                        <?php foreach ($levels as $val => $label): ?>
                                            <option value="<?= $val ?>" <?= $es->to_level == $val ? 'selected' : '' ?>><?= $label ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <button type="button" class="btn-remove-subject"><i class="fas fa-times"></i> Remove</button>
                        </div>
                    <?php endforeach; ?>

                    <?php if (empty($existingSubjects)): ?>
                        <div class="subject-section" data-index="0">
                            <div class="subject-form-group">
                                <?= Html::label('Subject', 'subject-0', ['class'=>'subject-label']) ?>
                                <?= Html::dropDownList('subject[]', null, $subjects, [
                                    'prompt'=>'Select subject', 'class'=>'wizard-form-control subject-select', 'required'=>true
                                ]) ?>
                            </div>
                            <div class="level-form-container">
                                <?php foreach (['from_level','to_level'] as $which): ?>
                                    <div class="level-form-group">
                                        <?= Html::label(ucwords(str_replace('_', ' ', $which)), "{$which}-0", ['class'=>'subject-label']) ?>
                                        <?= Html::dropDownList("{$which}[]", null, $levels, [
                                            'prompt'=>($which=='from_level'?'Select lowest':'Select high'),
                                            'class'=>'wizard-form-control level-select', 'required'=>true
                                        ]) ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <button type="button" class="btn-add-subject"><span>Add Subject</span> <i class="fas fa-plus"></i></button>
                    <div id="additional-subjects-container"></div>
                </div>

                <div class="wizard-form-actions">
                    <?= Html::submitButton('Save', ['class' => 'btn-save btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const subjects = <?= json_encode($subjects) ?>;
    const levels = <?= json_encode(array_keys($levels)) ?>;
    const addBtn = document.querySelector('.btn-add-subject');
    const container = document.getElementById('additional-subjects-container');
    let count = document.querySelectorAll('.subject-section').length;

    addBtn.onclick = ()=>{
        const div = document.createElement('div');
        div.className = 'subject-section';
        div.setAttribute('data-index', count);
        let opts = `<option value="" selected disabled>Select subject</option>`;
        for(let v in subjects) opts+=`<option value="${v}">${subjects[v]}</option>`;
        let lvlopts = `<option value="" disabled>Select...</option>`;
        levels.forEach(l=>lvlopts+=`<option value="${l}">${l.charAt(0).toUpperCase()+l.slice(1)}</option>`);
        div.innerHTML = `
        <div class="subject-form-group"><label class="subject-label"for="subject-${count}">Subject</label>
        <select id="subject-${count}" name="subject[]" class="wizard-form-control subject-select" required>${opts}</select></div>
        <div class="level-form-container">
          <div class="level-form-group"><label class="subject-label"for="from-level-${count}">From level</label>
          <select id="from-level-${count}" name="from_level[]" class="wizard-form-control level-select" required>${lvlopts}</select></div>
          <div class="level-form-group"><label class="subject-label"for="to-level-${count}">To level</label>
          <select id="to-level-${count}" name="to_level[]" class="wizard-form-control level-select" required>${lvlopts}</select></div>
        </div>
        <button type="button" class="btn-remove-subject"><i class="fas fa-times"></i> Remove</button>`;
        container.append(div);
        div.querySelector('.btn-remove-subject').onclick = ()=>div.remove();
        count++;
    };

    document.querySelectorAll('.btn-remove-subject').forEach(btn=>{
        btn.onclick = ()=>btn.closest('.subject-section').remove();
    });
});
</script>
