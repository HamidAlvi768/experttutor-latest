<?php

namespace app\components;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Yii;

use app\models\GeneralSetting;



class Mailer
{
    public function send($to, $name, $verificationLink)
    {
        if (empty($to) || empty($name) || empty($verificationLink)) {
            Yii::error('Invalid parameters for sending verification email.');
            return false;
        }

        $setting = GeneralSetting::find()->one();
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = $setting->host;
            $mail->SMTPAuth = true;
            $mail->Username = $setting->username;
            $mail->Password = $setting->password;
            $mail->SMTPSecure = 'ssl'; // or 'ssl' if needed
            $mail->Port = $setting->port; // Make sure this is correctly saved in DB

            // Recipients
            $mail->setFrom($setting->sender_email, $setting->site_name);
            $mail->addAddress($to);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Verify your email address';
            $mail->Body    = "
            <p>Hi <strong>{$name}</strong>,</p>
            <p>Please verify your email by clicking the link below:</p>
            <p><a href='{$verificationLink}'>{$verificationLink}</a></p>
            <p>Thank you!</p>
        ";

            return $mail->send();
        } catch (Exception $e) {
            // Log error for Yii logs
            Yii::error('Failed to send verification email: ' . $mail->ErrorInfo);

            // Print full exception details and stop execution
            die('Mailer Error: ' . $mail->ErrorInfo . ' | Exception: ' . $e->getMessage());
        }
    }
}
