<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\SignupForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\components\Helper;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss("
    .signup-container {
        background-size: cover;
        position: relative;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15), 0 1.5px 6px 0 rgba(60,60,60,0.08);
        border-radius: 24px;
        padding: 3rem !important;
        padding-bottom: 0 !important;
    }
    @media (max-width: 767.98px) {
        .signup-container {
            padding: 1rem !important;
        }
    }
    @media (min-width: 992px) {
        .signup-container {
            max-width: 900px !important;
        }
        .signup-image-panel img {
            border-radius: 10px;
        }
    }
    .signup_sec {
        height: 600px;
        overflow: hidden;
    }
    /* Hide signup image column on mobile and tablet screens */
    @media (max-width: 767.98px) {
        .signup_sec {
            display: none !important;
        }
    }
    
    /* Signup-specific styling to match login */
    .signup-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1B1B3F;
        margin-bottom: 0.5rem;
    }
    
    .signup-subtitle {
        color: #666;
        font-size: 1rem;
        margin-bottom: 0;
    }
    
    .signup-form-panel {
        background: white;
        border-radius: 0 24px 24px 0;
        padding: 3rem;
        padding-top: 0 !important;
    }
    @media (max-width: 767.98px) {
        .signup-form-panel {
            padding: 0 !important;
        }
    }
    
    .signup-image-panel {
        position: relative;
        overflow: hidden;
    }
    
    .signup-image-panel img {
        border-radius: 24px;
        object-fit: cover;
        height: 100%;
        width: 100%;
    }
    #close-form {
        position: absolute;
        background: white;
        right: 0;
        top: 30px;
        border-radius: 50%;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(0, 0, 0, 0.15);
    }

    /* User Type Toggle Styles */
    .user-type-toggle {
        display: flex;
        background: #f5f5f5;
        border-radius: 12px;
        padding: 4px;
        margin-bottom: 1.5rem;
    }
    
    .user-type-toggle .btn {
        flex: 1;
        padding: 8px 24px;
        border: none;
        border-radius: 8px;
        color: #666;
        font-weight: 500;
        transition: all 0.3s ease;
        background: transparent;
    }
    
    .user-type-toggle .btn.active {
        background: #564FFD;
        color: #fff;
    }
    
    .user-type-toggle .btn:hover:not(.active) {
        background: #e9e9e9;
    }

    /* Password Toggle Styles */
    .password-toggle {
        position: relative;
        display: inline-block;
        width: 100%;
    }
    .password-toggle .form-control {
        padding-right: 40px; /* Space for the icon */
    }
    .password-toggle .toggle-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #666;
        font-size: 1.2rem;
        z-index: 10; /* Ensure icon is above input */
    }
    .password-toggle .toggle-password:hover {
        color: #000;
    }
    .password-toggle .invalid-feedback {
        display: none; /* Hidden by default, shown when .is-invalid is present */
    }
    .password-toggle .form-control.is-invalid ~ .invalid-feedback {
        display: block; /* Show error when input is invalid */
    }
");
?>
<div class="signup-container container m-b-100 border-top2 mt-5 mb-3">
    <div class="mw-1000 mx-auto">
        <div class="row g-0 no-gutters">
            <!-- Left Image Panel -->
            <div class="col-md-6 signup_sec">
                <div class="signup-image-panel bg-login-page d-flex justify-content-center text-white text-center">
                    <img src="<?= Helper::baseUrl() ?>/custom/images/student-login.jpg"
                         alt="Signup illustration"
                         class="w-100 img-responsive"
                         id="auth-image">
                </div>
            </div>
            <!-- Right Form Panel -->
            <div class="col-md-6 justify-content-center align-items-center d-md-block">
                <div class="signup-form-panel h-100">
                    <div class="mb-3">
                        <h1 class="signup-title mb-2"><?= Html::encode($this->title) ?></h1>
                        <p class="signup-subtitle mb-4">Please fill out the following fields to create an account</p>
                    </div>

                    <!-- User Type Toggle -->
                    <div class="user-type-toggle">
                        <button type="button" class="btn <?= isset($_GET['tutor'])?'': 'active' ?>" data-type="student">Student</button>
                        <button type="button" class="btn <?= isset($_GET['tutor'])?'active': '' ?>" data-type="teacher">Teacher</button>
                    </div>

                    <?php $form = ActiveForm::begin([
                        'id' => 'signup-form',
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'form-label'],
                            'inputOptions' => ['class' => 'form-control'],
                            'errorOptions' => ['class' => 'invalid-feedback'],
                        ],
                    ]); ?>

                    <?= $form->field($model, 'username')->textInput([
                        'autofocus' => true,
                        'placeholder' => 'Enter your full name',
                        'id' => 'username-field'
                    ])->label('Full Name') ?>

                    <div id="username-suggestion" style="color:#007bff; font-size: 0.9em;"></div>

                    <?= $form->field($model, 'email')->textInput(['placeholder' => 'Enter your email']) ?>
                    <?php /* $form->field($model, 'password')->passwordInput(['placeholder' => 'Enter your password']) */?>
                    <?= $form->field($model, 'password', [
                    'template' => "{label}\n<div class=\"password-toggle position-relative\">{input}<span class=\"toggle-password fa fa-eye-slash position-absolute end-0 top-50 translate-middle-y me-2\" id=\"toggle-password\"></span></div>\n{error}",
                    'errorOptions' => ['class' => 'invalid-feedback d-block'],
                    'inputOptions' => ['class' => 'form-control'] // ensures Yii adds 'is-invalid'
                        ])->passwordInput(['placeholder' => 'Enter your password', 'id' => 'password-field'])->label('Password') ?>


                    <?php /* $form->field($model, 'password', [
                        'template' => "{label}\n<div class=\"password-toggle\">{input}<span class=\"toggle-password fa fa-eye-slash\" id=\"toggle-password\"></span></div>\n{error}",
                        'errorOptions' => ['class' => 'invalid-feedback']
                    ])->passwordInput(['placeholder' => 'Enter your password', 'id' => 'password-field'])->label('Password') */ ?>
                    
                    <!-- Role is set by toggle, use hidden input -->
                    <?= Html::activeHiddenInput($model, 'role', ['id' => 'signupform-role', 'value' => 'student']) ?>
                    
                    <div class="form-group">
                        <?= Html::submitButton('Signup', ['class' => 'btn btn-primary signup-btn w-100']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>

                    <div class="signup-help text-center mt-4">
                        Already have an account? <?= Html::a('Login here', ['login']) ?>
                    </div>
                    <div class="text-center mt-3">
                        <?= Html::a('← Home', Yii::$app->homeUrl, ['class' => 'text-decoration-none']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const teacherImage = '<?= Helper::baseUrl() ?>/custom/images/teacher-login.jpg';
const studentImage = '<?= Helper::baseUrl() ?>/custom/images/student-login.jpg';

document.addEventListener('DOMContentLoaded', () => {
    // User Type Toggle
    const userTypeButtons = document.querySelectorAll('.user-type-toggle .btn');
    const authImage = document.getElementById('auth-image');
    const roleInput = document.getElementById('signupform-role');

    userTypeButtons.forEach((button, index) => {
        // Remove any existing listeners to prevent duplicates
        button.replaceWith(button.cloneNode(true));
        const newButton = document.querySelectorAll('.user-type-toggle .btn')[index];

        newButton.addEventListener('click', () => {
            // Remove active class from all buttons
            userTypeButtons.forEach(btn => btn.classList.remove('active'));

            // Add active class to clicked button
            newButton.classList.add('active');

            // Update image and role based on user type
            const userType = newButton.getAttribute('data-type');

            if (authImage) {
                authImage.src = userType === 'teacher' ? teacherImage : studentImage;
            }

            if (roleInput) {
                roleInput.value = userType === 'teacher' ? 'tutor' : 'student';
            }
        });
    });

    
// Get query string
const urlParams = new URLSearchParams(window.location.search);
const isTutor = urlParams.has('tutor'); // true if ?tutor exists

// Auto-select teacher if ?tutor exists
if (isTutor) {
    const teacherBtn = document.querySelector('.user-type-toggle .btn[data-type="teacher"]');
    if (teacherBtn) {
        teacherBtn.click(); // simulate click
    }
}
// Auto-select teacher if ?tutor exists
if (isTutor) {
    const teacherBtn = document.querySelector('.user-type-toggle .btn[data-type="teacher"]');
    if (teacherBtn) {
        teacherBtn.click(); // simulate click
    }
}
    // Password Toggle
    const passwordInput = document.getElementById('password-field');
    const togglePassword = document.getElementById('toggle-password');

    if (passwordInput && togglePassword) {
        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            togglePassword.classList.toggle('fa-eye');
            togglePassword.classList.toggle('fa-eye-slash');
        });
    } else {
        console.error('Password toggle elements not found:', { passwordInput, togglePassword });
    }
});
</script>