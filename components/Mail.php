<?php

namespace app\components;

use app\models\GeneralSetting;
use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    public static function generateContent($data, $page_path)
    {
        // Check if the file exists
        if (!file_exists($page_path)) {
            return "Page file not found";
        }

        // Start output buffering to capture the content of the page
        ob_start();

        // Extract the data array to make its keys accessible as variables
        extract($data);

        // Include the page file
        include $page_path;

        // Get the captured content
        return ob_get_clean();
    }

    public static function send($to, $subject, $template, $data, $headers = null)
    {
        if (empty($to) || empty($subject) || empty($template)) {
            return [
                'status' => false,
                'message' => 'Invalid parameters for sending email.'
            ];
        }

        // Generate HTML content from the template
        $body = self::generateContent($data, $template);

        $setting = GeneralSetting::find()->one();
        $mail = new PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host = $setting->host;
        $mail->SMTPAuth = true;
        $mail->Username = $setting->username;
        $mail->Password = $setting->password;
        $mail->SMTPSecure = $setting->smtpsecure; // or 'ssl' if needed
        $mail->Port = $setting->port; // Make sure this is correctly saved in DB

        // Recipients
        $mail->setFrom($setting->sender_email, $setting->site_name);
        $mail->addAddress($to);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Send the to
        if ($mail->send()) {
            return [
                'status' => true,
                'message' => 'Email sent successfully.',
                'errors' => null
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Failed to send email.',
                'errors' => error_get_last()['message'] ?? 'Unknown error'
            ];
        }
    }
}
