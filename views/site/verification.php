<?php

use app\components\Helper;
use yii\helpers\Html;
use yii\helpers\Url;

$checkUrl = Url::to(['site/check-verification']);
$redirectUrl = Url::to(['site/user-dash']); // dashboard/home
$js = <<<JS
let redirecting = false;

function checkVerification() {
    if (redirecting) return; // prevent multiple triggers

    fetch("$checkUrl")
        .then(res => res.json())
        .then(data => {
            if (data.verified === true) {
                redirecting = true;
                
                // Show SweetAlert success before redirect
                Swal.fire({
                    icon: 'success',
                    title: 'Verified!',
                    text: 'Your account has been successfully verified.',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "$redirectUrl";
                });
            } else {
                setTimeout(checkVerification, 3000); // retry in 3 sec
            }
        })
        .catch(err => {
            console.error('Verification check failed:', err);
            setTimeout(checkVerification, 5000); // retry later
        });
}

checkVerification();
JS;

$this->registerJs($js);
?>

    <style>
        a {
            text-decoration: none;
        }
        .opn_mail{
            text-align: center;
        }
        .timer-text {
            color: #6c757d;
            font-size: 14px;
            margin-top: 8px;
            display: none;
            margin: 0;
        }
        .link-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .user-email {
            text-align: center;
            font-size: clamp(1rem, 0.4vw + 0.7rem, 1.35rem);
        }
    </style>
    <main class="verification-page">
        <div class="verification-container">

                    <img src="<?= Helper::baseUrl("/") ?>custom/images/learning-college.jpg" alt="Background decoration" class="background-image" />

            <section class="verification-card">
                <div class="verification-content">
                   <header class="verification-header">
                        <div class="verification-icon">
                            <i class="far fa-envelope"></i>
                        </div>
                        <div class="header-text">
                            <h1 class="title">Check your email</h1>
                            <p class="subtitle">open mail app to verify</p>
                        </div>
                    </header>
                    <div class="user-email" style="text-align: center;">
                        <?= Html::encode($user->email); ?>
                    </div>
                    <a class="primary-button opn_mail"href="https://mail.google.com"  >
                        <span class="button-text">Open email app</span>
                    </a>
                    <div class="resend-section">
                        <p class="resend-text">Didn't receive the email?</p>
                        <button class="link-button" id="resend-button" onclick="resendVerification()">
                            <span class="link-text">Click to resend</span>
                        </button>
                        <div class="timer-text" id="timer-display">
                            You can resend again in <span id="countdown">60</span> seconds
                        </div>
                    </div>
                    <div style="margin-top: clamp(12px, 1.5vw, 24px); text-align: center;">
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
    <!-- Include SweetAlert if not already included -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Timer variables
let countdownTimer;
let timeLeft = 60;
const resendButton = document.getElementById('resend-button');
const timerDisplay = document.getElementById('timer-display');
const countdownElement = document.getElementById('countdown');

function resendVerification() {
    // Hide the button and show timer
    resendButton.style.display = 'none';
    timeLeft = 60;
    timerDisplay.style.display = 'block';
    updateCountdown();
    
    fetch('<?= Url::to(['site/resend-verification']) ?>', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-Token': '<?= Yii::$app->request->getCsrfToken() ?>',
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: ''
    })
    .then(res => res.json())
    .then(data => {
        console.log("Response:", data);

        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message || 'Verification email sent!',
                timer: 2000,
                showConfirmButton: false
            });
            
            // Start the countdown timer
            countdownTimer = setInterval(updateCountdown, 1000);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.message || 'Something went wrong.'
            });
            // Show button again if there was an error
            resendButton.style.display = 'block';
            timerDisplay.style.display = 'none';
        }
    })
    .catch(err => {
        console.error('Fetch error:', err);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to resend verification email. Please try again later.'
        });
        // Show button again if there was an error
        resendButton.style.display = 'block';
        timerDisplay.style.display = 'none';
    });
}

function updateCountdown() {
    countdownElement.textContent = timeLeft;
    timeLeft--;
    
    if (timeLeft < 0) {
        clearInterval(countdownTimer);
        resendButton.style.display = 'block';
        timerDisplay.style.display = 'none';
    }
}
</script>