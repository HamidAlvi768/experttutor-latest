<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\Helper;

$this->title = 'Update Profile';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="<?= Helper::baseUrl('/') ?>custom/css/profile.css">
        <style>
            .fa-times::before{
                display: none;

            }
            .profile-pic-wrapper {
                position: relative;
                display: inline-block;
            }


            .verified-icon {
                position: absolute;
                top: 0;
                right: 0;
                color: #4CAF50;
                /* green */
                font-size: 18px;
                background: white;
                /* optional white background circle */
                border-radius: 50%;
                padding: 2px;
            }
        </style>


<main class="profile-main-content">
    <div class="profile-container">
        <?php $form = ActiveForm::begin([
            'options' => [
                'class' => 'profile-form-container',
                'enctype' => 'multipart/form-data',
                'style' => 'width:100%',
                'id' => 'profile-form',
            ],
            'enableClientValidation' => true, // Ensure Yii client-side validation is enabled
        ]); ?>
        <?= $form->errorSummary($model) ?>
            <!-- Profile Photo Section -->
            <div class="profile-photo-upload">
                <div class="profile-photo-placeholder">
                    <?php if ($model->avatar_url): ?>
                        
                        <img onclick="trigger('photo-upload')" src="<?= Helper::baseUrl('/') . Html::encode($model->avatar_url) ?>" alt="Upload Photo" class="profile-pic-wrapper" id="profile-preview">
                                 <?php if (Helper::getuserphoneverified($model->id)): ?>
                            <i class="fas fa-check-circle verified-icon"></i>
                        <?php endif; ?>
                    
                    <?php else: ?>
                        <img onclick="trigger('photo-upload')" src="<?= Helper::baseUrl('/') ?>custom/images/profile-placeholder.jpg" class="profile-pic-wrapper" alt="Upload Photo" id="profile-preview">
                                 <?php if (Helper::getuserphoneverified($model->id)): ?>
                            <i class="fas fa-check-circle verified-icon"></i>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?= $form->field($model, 'avatarFile')->fileInput([
                        'id' => 'photo-upload',
                        'accept' => 'image/*',
                        'hidden' => true,
                    ])->label(false) ?>
                </div>
                <label for="photo-upload" class="profile-upload-label"><i class="fas fa-upload me-1"></i>  Upload Your Photo</label>
            </div>

            <!-- Form Grid -->
            <div class="profile-form-grid">
                <div class="profile-form-group">
                    <?= $form->field($model, 'full_name')->textInput([
                        'maxlength' => 100,
                        'id' => 'full-name',
                        'placeholder' => 'Your Full Name',
                        'class' => 'profile-form-control',
                    ])->label('Full Name', ['class' => 'profile-label']) ?>
                </div>
                <div class="profile-form-group">
                    <?= $form->field($model, 'nick_name')->textInput([
                        'maxlength' => 100,
                        'id' => 'nick-name',
                        'placeholder' => 'Your Nick Name',
                        'class' => 'profile-form-control',
                    ])->label('Nick Name', ['class' => 'profile-label']) ?>
                </div>
                <div class="profile-form-group">
                    <?= $form->field($model, 'gender')->dropDownList([
                        'male' => 'Male',
                        'female' => 'Female',
                    ], [
                        'prompt' => 'Male/Female',
                        'id' => 'gender',
                        'class' => 'profile-form-control profile-select-control',
                    ])->label('Gender', ['class' => 'profile-label']) ?>
                </div>
                <div class="profile-form-group">
                    <?= $form->field($model, 'country')->dropDownList(
                        ArrayHelper::map(Helper::getGenericRecord('country'), 'title', 'title'),
                        [
                            'id' => 'country',
                            'prompt' => 'Select Country',
                            'class' => 'select2 profile-form-control profile-select-control',
                        ]
                    )->label('Country', ['class' => 'profile-label']) ?>
                </div>
                <div class="profile-form-group">
                    <?= $form->field($model, 'languages')->dropDownList(
                        ArrayHelper::map(Helper::getGenericRecord('language'), 'title', 'title'),
                        [
                            'id' => 'language',
                            'prompt' => 'Select Language',
                            'class' => 'profile-form-control profile-select-control',
                        ]
                    )->label('Language', ['class' => 'profile-label']) ?>
                </div>
                <div class="profile-form-group">
                    <?= $form->field($model, 'timezone')->dropDownList(
                        ArrayHelper::map(
                            DateTimeZone::listIdentifiers(DateTimeZone::ALL),
                            function ($timezone) { return $timezone; },
                            function ($timezone) {
                                $dateTime = new DateTime('now', new DateTimeZone($timezone));
                                $offset = $dateTime->format('P');
                                $tzInfo = new DateTimeZone($timezone);
                                $transitions = $tzInfo->getTransitions(time(), time() + 31536000);
                                $hasDst = count($transitions) > 1;
                                $label = "(UTC/GMT{$offset}";
                                if ($hasDst) { $label .= "†"; }
                                $label .= ") " . str_replace('_', ' ', $timezone);
                                return $label;
                            }
                        ),
                        [
                            'prompt' => 'Select Time Zone',
                            'id' => 'timezone',
                            'class' => 'profile-form-control profile-select-control',
                        ]
                    )->label('Time Zone', ['class' => 'profile-label']) ?>
                </div>
            </div>

            <div class="profile-form-group full-width">
                <?= $form->field($model, 'phone_number')->textInput([
                    'maxlength' => 20,
                    'id' => 'phone',
                    'placeholder' => 'Enter Phone Number',
                    'class' => 'profile-form-control',
                ])->label('Add Number To Verify', ['class' => 'profile-label']) ?>
            </div>

            <div class="profile-form-actions">
                <?= Html::a('<i class="fas fa-arrow-left"></i> Back', Yii::$app->request->referrer ?: Yii::$app->homeUrl, [
                    'class' => 'text-decoration-none text-center d-block mt-3',
                    'escape' => false
                ]) ?>
                <?= Html::submitButton('Save', ['class' => 'profile-btn-save']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</main>

<script>
    document.getElementById('photo-upload').addEventListener('change', function (event) {
        const input = event.target;
        const preview = document.getElementById('profile-preview');

        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            preview.onload = () => {
                URL.revokeObjectURL(preview.src); // Free memory
            };
        }
    });

    function trigger(id) {
        document.getElementById(id).click();
    }
</script>
<?php
$js = <<<JS
$('#country').select2({
    placeholder: "Select Country",
});
JS;
$this->registerJs($js);
?>