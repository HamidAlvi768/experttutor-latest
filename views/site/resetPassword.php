<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\PasswordResetForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use app\components\Helper;

$this->title = 'Reset Password';
$this->params['breadcrumbs'][] = $this->title;

// Register CSS
$this->registerCss("
        .login-container {
            background-size: cover;
            position: relative;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15), 0 1.5px 6px 0 rgba(60,60,60,0.08);
            border-radius: 24px;
            padding: 3rem !important;
            padding-bottom: 0 !important;
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
    
    /* Login-specific styling */
    .login-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1B1B3F;
        margin-bottom: 0.5rem;
    }
    
    .login-subtitle {
        color: #666;
        font-size: 1rem;
        margin-bottom: 0;
    }
    
    .login-form-panel {
        background: white;
        border-radius: 0 24px 24px 0;
        padding: 3rem !important;
        padding-bottom: 0 !important;
    }
    
    @media (min-width: 992px) {
        .login-form-panel {
            padding: 3rem !important;
            padding-bottom: 0 !important;
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
                        alt="Password Reset illustration"
                        class=" w-100 img-responsive"
                        id="auth-image">
                </div>
            </div>
            <!-- Right Form Panel -->
            <div class="col-md-6 justify-content-center align-items-center d-md-block">
                <div class="login-form-panel h-100 px-md-4 pt-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h1 class="login-title mb-2"><?= Html::encode($this->title) ?></h1>
                            <p class="login-subtitle mb-4">Please enter your new password.</p>    
                        </div>
                        <?= Html::a('Back to Login', ['login'], ['class' => 'btn btn-outline-secondary']) ?>    
                    </div>

                    <?php $form = ActiveForm::begin([
                        'id' => 'password-reset-form',
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'form-label'],
                            'inputOptions' => ['class' => 'form-control'],
                            'errorOptions' => ['class' => 'invalid-feedback'],
                        ],
                    ]); ?>

                    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'placeholder' => 'Enter new password']) ?>
                    <?= $form->field($model, 'confirm_password')->passwordInput(['placeholder' => 'Confirm new password']) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Reset Password', ['class' => 'btn btn-primary login-btn w-100']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                    <div class="signup-help text-center mt-4">
                        Remember your password? <?= Html::a('Login here', ['login']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 