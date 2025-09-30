<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Manageusers $model */
/** @var yii\widgets\ActiveForm $form */
?>

<style>
    .card-body .manageusers-form .form-control {
        background-color: #f7fafd;
        border: 1px solid #d1e3f0;
        border-radius: 6px;
        box-shadow: none;
        transition: border-color 0.2s;
    }

    .card-body .manageusers-form .form-control:focus {
        border-color: #80bdff;
        background-color: #f0f7fb;
        outline: none;
    }

    .input-group-text {
        background-color: #f7fafd;
        border: 1px solid #d1e3f0;
        border-left: none;
    }
</style>
<?php
$selectedRole = Yii::$app->request->get('user');
$isDisabled = isset($selectedRole) ? true : false;
?>

<div class="card">
    <div class="card-body">
        <div class="manageusers-form">
            <?php $form = ActiveForm::begin([
                'enableClientValidation' => true,
                'validateOnBlur' => false,
                'validateOnChange' => false,
                'validateOnType' => false,
            ]); ?>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                    <?php $emailDisabled = !$model->isNewRecord; ?>
                    <?= $form->field($model, 'email')->input('email', ['maxlength' => true, 'disabled' => $emailDisabled]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'role')->dropDownList(
                        ['student' => 'Student', 'tutor' => 'Tutor'],
                        [
                            'prompt' => 'Select Role',
                            'value' => $selectedRole,   // Preselect if student
                            'disabled' => $isDisabled   // Disable if student
                        ]
                    ) ?>

                    <?php if ($isDisabled): ?>
                        <?= $form->field($model, 'role')->hiddenInput(['value' => $selectedRole])->label(false); ?>
                    <?php endif; ?>
                    <?= $form->field($model, 'user_status')->dropDownList(
                        ['active' => 'Active', 'inactive' => 'Inactive', 'banned' => 'Banned', 'deleted' => 'Deleted'],
                        ['prompt' => 'Select Status']
                    ) ?>
                </div>
            </div>

            <?php if ($model->isNewRecord): ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?= $form->field($model, 'plainPassword', [
                                'template' => "{label}\n<div class=\"input-group\">{input}\n<div class=\"input-group-append\"><span class=\"input-group-text\"><i class=\"fa fa-eye toggle-password\" style=\"cursor: pointer\"></i></span></div></div>\n{hint}\n{error}"
                            ])->passwordInput([
                                'maxlength' => true,
                                'class' => 'form-control',
                                'required' => true,
                            ])->label('Password') ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'verification')->dropDownList(
                            ['1' => 'Yes', '0' => 'No'],
                            ['prompt' => 'Select Verification Status', 'required' => true]
                        ) ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'verification')->dropDownList(
                            ['1' => 'Yes', '0' => 'No'],
                            ['prompt' => 'Select Verification Status', 'required' => true]
                        ) ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<?php
$this->registerJs(<<<JS
$(document).on('click', '.toggle-password', function() {
    var input = $(this).closest('.input-group').find('input');
    var icon = $(this);
    
    if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        icon.removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
        input.attr('type', 'password');
        icon.removeClass('fa-eye-slash').addClass('fa-eye');
    }
});
JS);
?>