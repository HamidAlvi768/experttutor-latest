<?php

use app\components\Helper;
use app\models\Profiles;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Request A Tutor';
$this->params['breadcrumbs'][] = ['label' => 'Student Job Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .request-tutor-form {
        padding: 0;
    }
    /* Make Select2 look like .form-control */
.select2-container--default .select2-selection--single {
    height: 52px !important;
    padding: 0 20px !important;
    border: 1px solid var(--request-tutor-border) !important;
    border-radius: 8px !important;
    font-size: 15px !important;
    color: var(--request-tutor-text-dark) !important;
    background-color: var(--request-tutor-white) !important;
    display: flex;
    align-items: center;
}

/* Remove the extra arrow box styling */
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 100% !important;
    right: 15px !important;
}

/* Match text style */
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: normal !important;
    color: var(--request-tutor-text-dark) !important;
    padding-left: 0 !important;
}

/* Style the Select2 dropdown search bar */
.select2-container .select2-search--dropdown .select2-search__field {
    height: 42px;
    padding: 0 15px;
    border: 1px solid var(--request-tutor-border);
    border-radius: 6px;
    font-size: 15px;
    width: 100% !important;
    box-sizing: border-box;
    color: var(--request-tutor-text-dark);
    outline: none;
    transition: all 0.3s ease;
}

/* On focus */
.select2-container .select2-search--dropdown .select2-search__field:focus {
    border-color: #4a90e2; /* highlight color */
    box-shadow: 0 0 5px rgba(74, 144, 226, 0.3);
}
body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url(../custom/images/learning-college.jpg) center / cover no-repeat fixed !important;
    z-index: -2;
    opacity: 0.1   !important;
}

</style>

<div class="container mt-4 mb-5">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'request-tutor-form',
            'enctype' => 'multipart/form-data',
            'style' => 'width:100% !important'
        ]
    ]); ?>
    <h1 class="request-tutor-title2 mb-4">Request A Tutor</h1>
    <!-- Job Details Section -->
    <div class="form-section">
        <?= $form->field($model, 'title')->textInput([
            'maxlength' => 200,
            'class' => 'form-control',
            'placeholder' => 'Enter Title',
            'required' => true
        ])->label('Job Title', ['class' => 'form-label']) ?>
    </div>
    <div class="form-section">
        <?= $form->field($model, 'details')->textarea([
            'rows' => 8,
            'class' => 'form-control request-tutor-textarea',
            'placeholder' => 'Describe your tutoring needs',
            'required' => true
        ])->label('Job Details', ['class' => 'form-label']) ?>
    </div>

    <!-- Two Column Layout -->
    <div class="form-row">
        
        <div class="form-section">
            <?= $form->field($model, 'location')->textInput([
                'maxlength' => 100,
                'id' => 'location-input',
                'class' => 'form-control',
                'placeholder' => 'Enter location',
                'required' => true
            ])->label('Location', ['class' => 'form-label']) ?>
        </div>
         <div class="form-section">
            <?= $form->field($model, 'want')->dropDownList([
                'online' => 'Online Tutoring',
                'home' => 'Home Tutoring',
                'assigment' => 'Assignment Help'
            ], [
                'prompt' => 'Select option',
                'class' => 'form-control',
            ])->label('I Want', ['class' => 'form-label']) ?>
        </div>
        <?php /*?>
        <?php
        $phone_number = Profiles::find()->where(['user_id' => Yii::$app->user->identity->id])->one()->phone_number;

        $options = [
            'maxlength' => 100,
            'class' => 'form-control',
            'placeholder' => 'Enter phone number',
            'value' => ($phone_number) ?? '',

        ];
        if ($phone_number) {
            $options['readonly'] = true;
        } else {
            $options['readonly'] = true;
        };
        ?>
        <div class="form-section">
            <?= $form->field($model, 'phone_number')->textInput($options)->label('Phone No', ['class' => 'form-label']) ?>
        </div>
        <?php */?>
    </div>

    <?php $levels = [
    'Undergraduate' => 'Undergraduate',
    'Bachelors' => 'Bachelors',
    'Masters' => 'Masters',
    'PhD' => 'PhD',
    ]; ?>

    


    <div class="form-row">

    
        <div class="form-section">
            <?php /*?>
            <?= $form->field($model, 'subject')->textInput(['class' => 'form-control','required' => true])->label('Subject', ['class' => 'form-label']) ?>

             <?= $form->field($model, 'subject')->dropDownList(
                \yii\helpers\ArrayHelper::map(Helper::getGenericRecord('subject'), 'title', 'title'),

                [
                    'prompt' => 'Select subject',
                    'class' => 'form-control',
                    'required' => true
                ]
            ) ?>
         <?php */?>

         
<?= $form->field($model, 'subject')->dropDownList(
    ArrayHelper::map(Helper::getGenericRecord('subject'), 'title', 'title') + ['other' => 'Other'], // add "Other" option
    [
        'prompt' => 'Select subject ',
        'class' => 'select2 form-control',
        'required' => true,
        'id' => 'subject-dropdown'
    ]
)->label('Subject', ['class' => 'form-label']) ?>


           
            
        </div>

        <div class="form-section" id="other-subject-field" style="display:none;">
    <?= $form->field($model, 'other_subject')->textInput([
        'placeholder' => 'Enter your subject',
    ])->label('Other Subject', ['class' => 'form-label']) ?>
</div>
        
                <div class="form-section">
        <?= $form->field($model, 'level')->dropDownList(
            $levels,
            [
                'prompt' => 'Select Level',
                'class' => 'form-control',
                'required' => true
            ]
        )->label('Level', ['class' => 'form-label']) ?>
    </div>
        <?php /*?>
        <div class="form-section">
            <?= $form->field($model, 'want')->textInput([
                'class' => 'form-control',
                'placeholder' => 'What do you want?'
            ])->label('I want', ['class' => 'form-label']) ?>
        </div>
        <?php */   ?>
    </div>

    <div class="form-row">
        <div class="form-section">
            <?= $form->field($model, 'meeting_option')->dropDownList([
                'online' => 'Online',
                'in-person' => 'In Person',
                'both' => 'Both'
            ], [
                'prompt' => 'Select meeting option',
                'class' => 'form-control',
            ])->label('Meeting option', ['class' => 'form-label']) ?>
        </div>
        <?php /*?>
        <div class="form-section">
            <?= $form->field($model, 'post_code')->textInput([
                'maxlength' => 20,
                'class' => 'form-control',
                'placeholder' => 'Enter post code'
            ])->label('Post Code', ['class' => 'form-label']) ?>
        </div>
        <?php */?>
            <?php
        $phone_number = Profiles::find()->where(['user_id' => Yii::$app->user->identity->id])->one()->phone_number;

        $options = [
            'maxlength' => 100,
            'class' => 'form-control',
            'placeholder' => 'Enter phone number',
            'value' => ($phone_number) ?? '',

        ];
        if ($phone_number) {
            $options['readonly'] = true;
        } else {
            $options['readonly'] = true;
        };
        ?>
        <div class="form-section">
            <?= $form->field($model, 'phone_number')->textInput($options)->label('Phone No', ['class' => 'form-label']) ?>
        </div>


    
    </div>



    <div class="form-row">


    <?php $curency=Helper::getCurrency(); ?>

    <!-- Budget Section -->
<div class="form-section">
    <?php if (strtolower($curency) == 'usd'): ?>
        <?= $form->field($model, 'budget', [
            'template' => '<label class="form-label">{label}</label><div class="input-group"><span class="input-group-text">$</span>{input}</div>{error}{hint}'
        ])->textInput([
            'type' => 'number',
            'class' => 'form-control',
            'placeholder' => 'Enter budget'
        ])->label('Budget (USD)') ?>
    <?php else: ?>
        <?= $form->field($model, 'budget', [
            'template' => '<label class="form-label">{label}</label><div class="input-group"><span class="input-group-text">'. $curency .'</span>{input}</div>{error}{hint}'
        ])->textInput([
            'type' => 'number',
            'class' => 'form-control',
            'placeholder' => 'Enter budget'
        ])->label('Budget (' . $curency . ')', ['class' => 'form-label']) ?>
    <?php endif; ?>
</div>

        <div class="form-section">
            <?= $form->field($model, 'charge_type')->dropDownList([
                                'Hourly' => 'Hourly',
                                'Daily' => 'Daily',                            
                                'Monthly' => 'Monthly',
                                'Fixed Cost' => 'Fixed Cost',
                            ], [
                                'class' => 'form-control',
                                'id' => 'charge-type',
                                'prompt' => 'Select Charge Type',
                                'required' => true
                            ])->label('Charge Type', ['class' => 'form-label']) ?>
        </div>
    </div>

    <!-- Advanced Options -->
    <div class="form-row three-columns">
        <div class="form-section">
            <?= $form->field($model, 'gender')->dropDownList([
                'male' => 'Male',
                'female' => 'Female',
                'any' => 'Any'
            ], [
                'prompt' => 'Gender',
                'class' => 'form-select',
            ])->label('Gender', ['class' => 'form-label']) ?>
        </div>
        <?php /*?>
        <div class="form-section with-connector">
            <label class="form-label">I need Some</label>
            <div class="connected-inputs">
                <?= Html::activeTextInput($model, 'need_some', [
                    'class' => 'form-control',
                    'placeholder' => 'Enter value',
                    'style' => 'width: 100%; display: inline-block;'
                ]) ?>
                
                        <span class="connector">to</span>
                        <select class="form-select" style="width: 40%; display: inline-block;">
                            <option value="" selected>Enter</option>
                        </select>
                        <?php * ?>
            </div>
            <?= Html::error($model, 'need_some', ['class' => 'help-block']) ?>
        </div>
        <?php */ ?>
        <div class="form-section">
            <?= $form->field($model, 'tutor_from')->dropDownList(
                    ['Any Country' => 'Any Country']+ArrayHelper::map(Helper::getGenericRecord('country'), 'title', 'title'),
                    [
                        'id' => 'country',
                        'prompt' => 'Select Country',
                        'class' => 'select2 form-control',
                    ]
                )->label('Get tutors from', ['class' => 'form-label']) ?>
        </div>
        <div class="form-section">
        <?= $form->field($model, 'call_option')->dropDownList([
            '1' => 'Yes',
            '0' => 'NO',

        ], [
            'class' => 'form-control',
        ])->label('Allow Tutors To Call', ['class' => 'form-label']) ?>
    </div>
    

     
    </div>

<style>
input{
    padding: 15px !important;
}
</style>

    <div class="form-section">
    <?= $form->field($model, 'document')->fileInput(['class' => 'form-control form-input'])->label('Document <span class="text-muted sm">(Only 1 MB files are allowed. Use Google Drive or any other option for larger files.)</span>', ['class' => 'form-label']) ?>
</div>



    <!-- Form Actions -->
    <div class="form-actions">
        <!-- <button type="button" class="btn btn-outline-primary preview-btn">Preview</button> -->
        <?= Html::submitButton('Post Job', ['class' => 'btn btn-primary finish-btn']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<script>
  function initAutocomplete() {
    const input = document.getElementById("location-input");
    const autocomplete = new google.maps.places.Autocomplete(input, {
      fields: ["place_id", "geometry", "formatted_address", "name"]
    });

    autocomplete.addListener("place_changed", () => {
      const place = autocomplete.getPlace();
      console.log("Selected:", place);
    });
  }
</script>
<?php
$js = <<<JS
    $('#subject-dropdown').on('change', function() {
        if ($(this).val() === 'other') {
            $('#other-subject-field').show();
            $('#other-subject-field input').attr('required', true); // make required
        } else {
            $('#other-subject-field').hide();
            $('#other-subject-field input').val('').removeAttr('required'); // remove required
        }
    });
JS;
$this->registerJs($js);
?>


<?php
$js = <<<JS
$('#subject-dropdown').select2({
    placeholder: "Select subject",
});

$('#country').select2({
    placeholder: "Select Country",
});
JS;
$this->registerJs($js);
?>