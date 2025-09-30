<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Update Profile';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profiles-create">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="profiles-form">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($model, 'avatarFile')->fileInput() ?>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'full_name')->textInput(['maxlength' => 100]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'nick_name')->textInput(['maxlength' => 100]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'gender')->dropDownList([
                        'male' => 'Male',
                        'female' => 'Female'
                    ], ['prompt' => 'Select Gender']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'country')->textInput(['maxlength' => 100]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'languages')->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'timezone')->dropDownList(
                        ArrayHelper::map(
                            DateTimeZone::listIdentifiers(DateTimeZone::ALL),
                            function ($timezone) {
                                return $timezone;
                            },
                            function ($timezone) {
                                $dateTime = new DateTime('now', new DateTimeZone($timezone));
                                $offset = $dateTime->format('P');
                                $tzInfo = new DateTimeZone($timezone);
                                $transitions = $tzInfo->getTransitions(time(), time() + 31536000); // Check transitions for next year
                                $hasDst = count($transitions) > 1;
                                $label = "(UTC/GMT{$offset}";
                                if ($hasDst) {
                                    $label .= "†";
                                }
                                $label .= ") " . str_replace('_', ' ', $timezone);
                                return $label;
                            }
                        ),
                        [
                            'prompt' => 'Select Timezone',
                            'options' => [
                                'style' => 'max-width: 100%;'
                            ]
                        ]
                    ) ?>
                </div>
            </div>

            <!-- <?= $form->field($model, 'address')->textarea(['rows' => 4]) ?>
            <?= $form->field($model, 'city')->textInput(['maxlength' => 100]) ?> -->

            <!-- <?= $form->field($model, 'birthdate')->input('date') ?> -->

            <?= $form->field($model, 'phone_number')->textInput(['maxlength' => 20]) ?>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>