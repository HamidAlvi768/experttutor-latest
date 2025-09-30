<?php

use app\components\Helper;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\Alert;


?>

    <style>
        a {
            text-decoration: none;
        }
        .opn_mail{
            text-align: center;
        }
    </style>
    <main class="verification-page">
        <div class="verification-container">

                    <img src="<?= Helper::baseUrl("/") ?>custom/images/learning-college.jpg" alt="Background decoration" class="background-image" />

            <section class="verification-card">
                <div class="verification-content">
                   <header class="verification-header">
                        <div class="verification-icon">
                            <svg width="41" height="41" viewBox="0 0 41 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M36.7552 28.815V33.7621C36.757 34.2214 36.6629 34.676 36.479 35.0968C36.295 35.5176 36.0251 35.8953 35.6867 36.2058C35.3483 36.5163 34.9488 36.7526 34.5137 36.8998C34.0786 37.0469 33.6177 37.1016 33.1603 37.0602C28.0859 36.5088 23.2116 34.7749 18.9291 31.9977C14.9448 29.4659 11.5667 26.0878 9.0349 22.1035C6.248 17.8015 4.51365 12.9035 3.97237 7.80636C3.93116 7.35035 3.98536 6.89076 4.1315 6.45684C4.27765 6.02292 4.51254 5.62418 4.82124 5.28602C5.12993 4.94785 5.50565 4.67767 5.92448 4.49267C6.34331 4.30767 6.79608 4.2119 7.25395 4.21147H12.201C13.0013 4.20359 13.7772 4.48699 14.384 5.00883C14.9908 5.53068 15.3871 6.25536 15.4991 7.04781C15.7079 8.63099 16.0952 10.1855 16.6534 11.6816C16.8753 12.2718 16.9233 12.9133 16.7918 13.53C16.6603 14.1466 16.3547 14.7127 15.9114 15.1611L13.8171 17.2553C16.1646 21.3838 19.5829 24.802 23.7113 27.1495L25.8056 25.0553C26.2539 24.6119 26.82 24.3063 27.4367 24.1748C28.0533 24.0433 28.6948 24.0913 29.285 24.3132C30.7812 24.8715 32.3356 25.2587 33.9188 25.4675C34.7199 25.5805 35.4514 25.984 35.9744 26.6012C36.4973 27.2184 36.7752 28.0063 36.7552 28.815Z" stroke="#564FFD" stroke-width="3.29807" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
                        </div>
                        <div class="header-text">
                            <h1 class="title">Check your Phone</h1>
                            <p class="subtitle">Verification Code Sent on <?= Html::encode($user->profile->phone_number) ?></p>
                        </div>
                    </header>
                      <?php $form = \yii\widgets\ActiveForm::begin([
            'id' => 'otpForm',
            'options' => ['class' => 'form-horizontal'],
        ]); ?>
        <div class="verification-code-inputs" style="display: flex; justify-content: center; gap: 12px; margin-bottom: 28px;">
            <?php for ($i = 0; $i < 6; $i++): ?>
                <input type="text"
                    class="code-input"
                    maxlength="1"
                    name="otp[]"
                    data-index="<?= $i ?>"
                    autocomplete="off"
                    style="width: 54px; height: 54px; border: 1px solid #E7E7E7; border-radius: 8px; text-align: center; font-size: 20px; font-weight: 600; color: #1B1B3F; background: #FFFFFF;">
            <?php endfor; ?>
        </div>
       
        <button type="submit" class="primary-button opn_mail btn btn-primary finish-btn w-100" style="margin-bottom: 18px;"> <span class="button-text">Verify</span> </button>
        <?php \yii\widgets\ActiveForm::end(); ?>
                    
                    <div class="resend-section">
                        <p class="resend-text">Didn't receive the Code?</p>
                        <a href="<?= Helper::baseUrl('/verify-phone') ?>" class="resend-link" style="color: #564FFD; font-weight: 500; text-decoration: none; margin-left: 4px;">Code Resend</a>
                    </div>
                    <div style="margin-top: 24px; text-align: center;">
                        <?= Html::beginForm(['/logout'], 'post', ['style' => 'display:inline;']) ?>
                        <?= Html::submitButton(
                            'Back to Login',
                            [
                                'class' => 'btn btn-link logout',
                                'style' => '
                                    color: #007bff;
                                    background: none;
                                    border: none;
                                    padding: 0;
                                    font-size: 16px;
                                    cursor: pointer;
                                    text-decoration: underline;
                                    font-family: Montserrat, Arial, sans-serif;
                                '
                            ]
                        ) ?>
                        <?= Html::endForm() ?>
                    </div>
                
                
                </div>
            </section>
        </div>
    </main>

  
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.code-input');
        inputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                if (this.value.length >= 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && !this.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });
    });
</script>