<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <style>
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
            }

            .button {
                width: 100% !important;
            }
        }
    </style>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <?php

use app\components\Helper;
use app\models\GeneralSetting;

$site_setting = GeneralSetting::find()->one();


// Default logo settings if not provided
$logo_src = !empty($site_setting->site_logo) ? Helper::baseUrl('/') .$site_setting->site_logo : Helper::baseUrl() . "custom/images/logo.png";
$logo_alt = !empty($site_setting->site_name) ? $site_setting->site_name : 'Assignment Connect';
 ?>
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 20px 0; text-align: center; background-color: #ffffff;">
                <div class="email-container" style="max-width: 600px; margin: 0 auto; padding: 20px;">
                    <img src="<?php echo htmlspecialchars($logo_src); ?>" alt="<?= $logo_alt ?>" style="max-width: 200px; margin-bottom: 20px;">
                    <h1 style="color: #333333; margin-bottom: 20px;">Verify Your Email Address</h1>
                    <p style="color: #666666; font-size: 16px; line-height: 1.5; margin-bottom: 30px;">
                        Hello <?php echo htmlspecialchars($username);  ?>,<br><br>
                        Thank you for registering! Please click the button below to verify your email address.
                    </p>
                    <a href="<?php echo htmlspecialchars($verificationLink); ?>" class="button" style="display: inline-block; padding: 12px 30px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold; margin-bottom: 30px;">
                        Verify Email
                    </a>
                    <p style="color: #666666; font-size: 14px; line-height: 1.5;">
                        If the button doesn\'t work, copy and paste this link in your browser:<br>
                        <span style="color: #007bff;"><?php echo htmlspecialchars($verificationLink); ?></span>
                    </p>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>