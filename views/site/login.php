<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\components\Helper;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

// Register CSS
$this->registerCss("
        .login-container {
            background-size: cover;
            position: relative;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15), 0 1.5px 6px 0 rgba(60,60,60,0.08);
            border-radius: 24px;
            padding: 1rem 2rem !important;
        }
            
            @media (min-width: 992px) {
                .login-container {
                    max-width: 900px !important;
                    padding: 0 !important;
                }
                .login-image-panel img {
                    border-radius: 10px 0 0 10px;
                }
            }
    .login_sec{
        height: 600px;
        overflow: hidden;
    }
    /* Hide login image column on mobile and tablet screens */
    @media (max-width: 767.98px) {
        .login_sec {
            display: none !important;
        }
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
");
?>

<div class="login-container container m-b-100 border-top2 mt-5 mb-3">
    <!-- //shadow style=" border-radius: 40px;"-->
    <div class="mw-1000  mx-auto ">
        <div class="row g-0 no-gutters ">
            <!-- Left Image Panel -->
            <div class="col-md-6 login_sec">
                <div class="login-image-panel bg-login-page d-flex justify-content-center text-white text-center">
                    <img src="<?= Helper::baseUrl() ?>custom/images/student-login.jpg"
                        alt="Login illustration"
                        class=" w-100 img-responsive"
                        id="auth-image">
                </div>
            </div>
            <!-- Right Form Panel -->
            <div class="col-md-6 justify-content-center align-items-center d-md-block">
                <?php /*?>
                <a type="button" aria-label="Close" id="close-form" href="<?php echo Yii::$app->homeUrl ?>" class="css-1oj1qv9">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="#000" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </a>
                <?php */ ?>
                <div class="login-form-panel h-100 px-md-4 pt-5">
                    <div class="mb-3">
                        <h1 class="login-title mb-2"><?= Html::encode($this->title) ?></h1>
                        <p class="login-subtitle mb-4">Please fill out the following fields to login</p>
                    </div>
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'form-label'],
                            'inputOptions' => ['class' => 'form-control'],
                            'errorOptions' => ['class' => 'invalid-feedback'],
                        ],
                    ]); ?>

                    <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Enter your username']) ?>
                    <?php /* $form->field($model, 'password')->passwordInput(['placeholder' => 'Enter your password']) */ ?>
                    <?= $form->field($model, 'password', [
                        'template' => "{label}\n<div class=\"password-toggle position-relative\">{input}<span class=\"toggle-password fa fa-eye-slash position-absolute end-0 top-50 translate-middle-y me-2\" id=\"toggle-password\"></span></div>\n{error}",
                        'errorOptions' => ['class' => 'invalid-feedback d-block'],
                        'inputOptions' => ['class' => 'form-control'] // ensures Yii adds 'is-invalid'
                    ])->passwordInput(['placeholder' => 'Enter your password', 'id' => 'password-field'])->label('Password') ?>
                    <?= $form->field($model, 'rememberMe')->checkbox([
                        'template' => "<div class=\"form-check\">{input} {label}</div>\n{error}",
                        'class' => 'form-check-input',
                        'labelOptions' => ['class' => 'form-check-label'],
                    ]) ?>
                    <div class="form-group">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary login-btn w-100']) ?>
                    </div>
                    <div class="text-center mt-3">
                        <?= Html::a('Forgot Password?', ['request-password-reset'], ['class' => 'text-decoration-none']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>

                    <div class="signup-help text-center mt-4">
                        Not have an account? <?= Html::a('Signup here', ['signup']) ?>
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
    document.addEventListener('DOMContentLoaded', () => {
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
            console.error('Password toggle elements not found:', {
                passwordInput,
                togglePassword
            });
        }
    });
</script>