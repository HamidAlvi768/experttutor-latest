<?php
use yii\helpers\Html;
use app\components\Helper;
use app\models\GeneralSetting;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$resetLink = Helper::baseUrl() . 'site/reset-password?token=' . $user->password_reset_token;

$site_setting = GeneralSetting::find()->one();

// Default logo settings if not provided
$logo_src = !empty($site_setting->site_logo) ? Helper::baseUrl('/') .$site_setting->site_logo : Helper::baseUrl() . "custom/images/logo.png";
$logo_alt = !empty($site_setting->site_name) ? $site_setting->site_name : 'Assignment Connect';
//$site_name=$site_setting->site_name
?>
<div class="password-reset">
    <h2>Hello <?= Html::encode($user->username) ?>,</h2>
    
    <p>You have requested to reset your password for your <?= $logo_alt ?> account.</p>
    
    <p>Please click the link below to reset your password:</p>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="<?= $resetLink ?>" style="background-color: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">
            Reset Password
        </a>
    </div>
    
    <p>If you did not request this password reset, please ignore this email.</p>
    
    <p>This link will expire in 1 hour for security reasons.</p>
    
    <p>Best regards,<br>
    <?= $logo_alt ?>  Team</p>
    
    <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">
    <p style="color: #666; font-size: 12px;">
        If the button above doesn't work, you can copy and paste this link into your browser:<br>
        <a href="<?= $resetLink ?>"><?= $resetLink ?></a>
    </p>
</div> 