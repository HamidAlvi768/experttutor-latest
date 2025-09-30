<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\GenericRecords $model */
/** @var yii\widgets\ActiveForm $form */
?>

<style>
    .card-body .generic-records-form .form-control {
        background-color: #f7fafd;
        border: 1px solid #d1e3f0;
        border-radius: 6px;
        box-shadow: none;
        transition: border-color 0.2s;
    }

    .card-body .generic-records-form .form-control:focus {
        border-color: #80bdff;
        background-color: #f0f7fb;
        outline: none;
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="generic-records-form">
            <?php $form = ActiveForm::begin([
                'enableClientValidation' => true,
                'validateOnBlur' => false,
                'validateOnChange' => false,
                'validateOnType' => false,
            ]); ?>
            <!-- Dropdown for existing types -->
            <?php if (!isset($_GET['id'])): ?>

                <?= $form->field($model, 'type')->textInput(['maxlength' => true, 'id' => 'new-type'])->label('Add New Type') ?>
            <?php else: ?>
                <?php

                $existingTypes = ArrayHelper::map(
                    \app\models\GenericRecords::find()
                        ->select(['id', 'type'])
                        ->where(['parent_id' => null])
                        ->distinct()
                        ->all(),
                    'id',
                    'type'
                );

                $selectedId = (int)$_GET['id'];
                ?>

                <?= $form->field($model, 'parent_id')->dropDownList(
                    $existingTypes,
                    [
                        'prompt' => 'Select Existing Type',
                        'id' => 'parent-type',
                        'disabled' => true,
                        'options' => [
                            $selectedId => ['selected' => true]
                        ]
                    ]
                )->label('Record Type') ?>
                <?= $form->field($model, 'parent_id')->hiddenInput(['value' => $selectedId])->label(false) ?>

            <?php endif; ?>


            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'active')->dropDownList([
                1 => 'Yes',
                0 => 'No',
            ]) ?>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
$js = <<<JS
    // If user selects an existing type, clear new type input
    $('#parent-type').on('change', function() {
        if ($(this).val()) {
            $('#new-type').val('');
        }
    });
    // If user types a new type, reset the dropdown
    $('#new-type').on('input', function() {
        if ($(this).val().length > 0) {
            $('#parent-type').val('');
        }
    });
JS;
$this->registerJs($js);
?>