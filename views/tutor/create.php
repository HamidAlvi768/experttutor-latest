<?php

use app\components\Helper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Create Profile';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .wizard-form-actions {
        display: block;
        justify-content: flex-end;
        margin-top: 90px;
        gap: 15px;
        text-align: end;
    }
    @media (max-width: 991.98px) {
        .wizard-form-actions {
            margin-top: clamp(1.7rem, 5vw, 6rem);
        }
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
<div class="profiles-create">
    <div class="container">
        <div class="wizard-container">
            <?php echo $this->render('_sidebar'); ?>
            <div class="wizard-content">
                <h2 class="wizard-section-title">Teacher Profile</h2>
                <div class="profiles-form">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'profile-form'], 'enableClientValidation' => true]); ?>

                    <?= $form->errorSummary($model) ?>

                    <!-- Profile Photo Upload -->
                    <div class="profile-photo-upload">
                        <div class="profile-photo-placeholder" style="cursor:pointer;">
                            <img   src="<?= $model->avatar_url ? Helper::baseUrl($model->avatar_url) : Helper::baseUrl("/") . "custom/images/profiles/teacher-avatar.jpg" ?>" alt="Profile Photo" id="profile-preview" style="object-fit:cover;">
                            <?= $form->field($model, 'avatarFile', [
                                'template' => '{input}{error}',
                                'options' => ['tag' => false],
                            ])->fileInput([
                                'id' => 'profile-upload',
                                'style' => 'display:none;',
                                'accept' => 'image/*',
                                'hidden' => true
                            ]) ?>
                        </div>
                        <label style="cursor:pointer;" for="profile-upload" class="profile-upload-label"><i class="fas fa-upload me-1"></i>  Upload Your Photo</label>

                        <!-- <div class="upload-your-photo" for="profile-upload">Upload Your Photo</div> -->
                    </div>
                    <?php           $user_name=Yii::$app->user->identity->username;  ?>

                    <!-- Form Fields -->
                    <div class="wizard-form-grid">
                        <div class="wizard-form-group">
                            
                            <?= $form->field($model, 'full_name', [
                                'template' => '<label class="subject-label" for="full-name">Full Name</label>{input}{error}',
                                'options' => ['tag' => false],
                            ])->textInput([
                                'class' => 'wizard-form-control',
                                'id' => 'full-name',
                                'placeholder' => 'Full Name',
                                'maxlength' => 100,
                                'value' =>$user_name,
                                'required' => true
                            ]) ?>
                        </div>
                        <div class="wizard-form-group">
                            <?= $form->field($model, 'nick_name', [
                                'template' => '<label class="subject-label" for="nick-name">Nick Name</label>{input}{error}',
                                'options' => ['tag' => false],
                            ])->textInput([
                                'class' => 'wizard-form-control',
                                'id' => 'nick-name',
                                'placeholder' => 'Nick Name',
                                'maxlength' => 100,
                                'required' => true
                            ]) ?>
                        </div>
                        <div class="wizard-form-group">
                            <?= $form->field($model, 'gender', [
                                'template' => '<label class="subject-label" for="gender">Gender</label>{input}{error}',
                                'options' => ['tag' => false],
                            ])->dropDownList([
                                'male' => 'Male',
                                'female' => 'Female',
                                'other' => 'Other',
                            ], [
                                'class' => 'wizard-form-control wizard-select-control',
                                'id' => 'gender',
                                'prompt' => 'Select Gender',
                                'required' => true
                            ]) ?>
                        </div>
                        <div class="wizard-form-group">
                              <?= $form->field($model, 'country', [
                                'template' => '<label class="subject-label" for="country">Country</label>{input}{error}',
                                'options' => ['tag' => false],
                            ])->dropDownList(
                                ArrayHelper::map(Helper::getGenericRecord('country'), 'title', 'title'), // Adjust 'id' and 'name' keys as needed
                                [
                                    'class' => 'select2 wizard-form-control wizard-select-control',
                                    'id' => 'country',
                                    'prompt' => 'Select country',
                                    'required' => true,
                                ]
                            )
                            ?>
                            <?php /* $form->field($model, 'country', [
                                'template' => '<label class="subject-label" for="country">Country</label>{input}{error}',
                                'options' => ['tag' => false],
                            ])->textInput([
                                'class' => 'wizard-form-control',
                                'id' => 'country',
                                'placeholder' => 'Country',
                                'maxlength' => 100,
                                'required' => true
                            ]) */?>
                        </div>
                        <div class="wizard-form-group">
                            <?= $form->field($model, 'languages', [
                                'template' => '<label class="subject-label" for="languages">Language</label>{input}{error}',
                                'options' => ['tag' => false],
                            ])->dropDownList(
                                ArrayHelper::map(Helper::getGenericRecord('language'), 'title', 'title'), // Adjust 'id' and 'name' keys as needed
                                [
                                    'class' => 'wizard-form-control wizard-select-control',
                                    'id' => 'languages',
                                    'prompt' => 'Select Language',
                                    'required' => true,
                                ]
                            )
                            ?>
                            <?php /* ?>  <?= $form->field($model, 'languages', [
                            'template' => '<label class="subject-label" for="languages">Language</label>{input}{error}',
                            'options' => ['tag' => false],
                        ])->textInput([
                            'class' => 'wizard-form-control',
                            'id' => 'languages',
                            'placeholder' => 'Languages',
                            'required' => true
                        ]) ?><?php */ ?>

                        </div>



                        <div class="wizard-form-group">
                            <?= $form->field($model, 'timezone', [
                                'template' => '<label class="subject-label" for="timezone">Timezone</label>{input}{error}',
                                'options' => ['tag' => false],
                            ])->dropDownList(
                                ArrayHelper::map(
                                    DateTimeZone::listIdentifiers(DateTimeZone::ALL),
                                    function ($timezone) {
                                        return $timezone;
                                    },
                                    function ($timezone) {
                                        $dateTime = new DateTime('now', new DateTimeZone($timezone));
                                        $offset = $dateTime->format('P');
                                        $tzInfo = new DateTimeZone($timezone);
                                        $transitions = $tzInfo->getTransitions(time(), time() + 31536000);
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
                                    'class' => 'wizard-form-control wizard-select-control',
                                    'id' => 'timezone',
                                    'prompt' => 'Select Timezone',
                                    'required' => true,
                                    'options' => [
                                        'style' => 'max-width: 100%;'
                                    ]
                                ]
                            ) ?>
                        </div>
                         <div class="wizard-form-group">
            <?= $form->field($model, 'phone_number')->textInput([
                'maxlength' => 20,
                'id' => 'phone',
                'placeholder' => 'Enter Phone Number',
                'class' => 'wizard-form-control profile-form-control',
            ])->label('Add Number To Verify', ['class' => 'subject-label']) ?>
        </div>
        <?php /*?>
                        <div class="wizard-form-group">
                            <?= $form->field($model, 'phone_number', [
                                'template' => '<label class="subject-label" for="phone-number">Phone Number</label>{input}{error}',
                                'options' => ['tag' => false],
                            ])->textInput([
                                'class' => 'wizard-form-control',
                                //'id' => 'phone-number',
                                'id' => 'phone',
                                'placeholder' => 'Phone Number',
                                'maxlength' => 20,
                                'required' => true
                            ]) ?>
                        </div>
                    </div>

                    <?php */?>

                    <!-- Form Actions -->
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
    document.addEventListener('DOMContentLoaded', function() {
        // Profile Image Preview
        const profilePlaceholder = document.querySelector('.profile-photo-placeholder');
        if (profilePlaceholder) {
            const profileInput = document.getElementById('profile-upload');
            const profilePreview = document.getElementById('profile-preview');
            profilePlaceholder.addEventListener('click', function() {
                profileInput.click();
            });
            profileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profilePreview.src = e.target.result;
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
    });


</script>

<?php
$js = <<<JS
$('#country').select2({
    placeholder: "Select Country",
});
JS;
$this->registerJs($js);
?>