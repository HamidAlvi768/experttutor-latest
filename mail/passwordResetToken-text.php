<?php
use app\components\Helper;
use app\models\GeneralSetting;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$resetLink = Helper::baseUrl() . 'site/reset-password?token=' . $user->password_reset_token;


$site_setting = GeneralSetting::find()->one();

// Default logo settings if not provided
$logo_src = !empty($site_setting->site_logo) ? Helper::baseUrl('/') .$site_setting->site_logo : Helper::baseUrl() . "custom/images/logo.png";
$logo_alt = !empty($site_setting->site_name) ? $site_setting->site_name : 'Assignment Connect';

?>
Hello <?= $user->username ?>,

You have requested to reset your password for your <?= $logo_alt ?>  account.

Please click the link below to reset your password:

<?= $resetLink ?>

If you did not request this password reset, please ignore this email.

This link will expire in 1 hour for security reasons.

Best regards,
<?= $logo_alt ?>  Team 