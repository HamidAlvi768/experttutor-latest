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
$logo_alt = !empty($site_setting->site_name) ? $site_setting->site_name : 'Assignlly';
$buyMembershipUrl = Yii::$app->urlManager->createAbsoluteUrl(['tutor/buy-membership']);
?>
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="padding: 20px 0; text-align: center; background-color: #ffffff;">
                <div class="email-container" style="max-width: 600px; margin: 0 auto; padding: 20px;">
                    <img src="<?php echo htmlspecialchars($logo_src); ?>" alt="<?= $logo_alt ?>" style="max-width: 200px; margin-bottom: 20px;">
                    <h1 style="color: #333333; margin-bottom: 20px;">Insufficient Balance for Membership Renewal</h1>
                    <p style="color: #666666; font-size: 16px; line-height: 1.5; margin-bottom: 20px;">
                        Hello <?php echo htmlspecialchars($user->username); ?>,<br><br>
                        We attempted to renew your subscription with <?php echo htmlspecialchars($wallet->membership_coins); ?> coins, but your wallet balance is insufficient.<br>
                        Current balance: <?php echo htmlspecialchars($wallet->balance); ?> coins.
                    </p>
                    <p style="color: #666666; font-size: 16px; line-height: 1.5; margin-bottom: 30px;">
                        Please add coins to your wallet to continue your subscription.
                    </p>
                    <a href="<?php echo htmlspecialchars($buyMembershipUrl); ?>" class="button" style="display: inline-block; padding: 12px 30px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold; margin-bottom: 30px;">
                        Add Coins Now
                    </a>
                    <p style="color: #666666; font-size: 14px; line-height: 1.5;">
                        If the button doesn't work, copy and paste this link in your browser:<br>
                        <span style="color: #007bff;"><?php echo htmlspecialchars($buyMembershipUrl); ?></span>
                    </p>
                    <p style="color: #666666; font-size: 14px; line-height: 1.5; margin-top: 30px;">
                        Best regards,<br>
                        Assignlly Team
                    </p>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>