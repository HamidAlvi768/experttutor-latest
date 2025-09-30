<?php

namespace app\components;

use Twilio\Rest\Client;
use Yii;

class TwilioHelper
{

    public static function send_sms_verify($to, $otp)
    {
        $sid = 'AC96de1ca80ef697962057257ad67a0ce7';
        $token = '0faf3b3b49f8a50cdbecf57ac9a02647';
        $client = new Client($sid, $token);

        $twilioNumber = '+17176708083'; // Your active Twilio number
        $message = "Your verification code is: $otp";

        try {
            $response = $client->messages->create(
                $to,
                [
                    'from' => $twilioNumber,
                    'body' => $message,
                ]
            );
            return $response->sid; // ✅ Return the SID for confirmation
        } catch (\Exception $e) {
            Yii::error("Twilio SMS failed: " . $e->getMessage());
            return false; // or return $e->getMessage();
        }
    }


    // public static function send_sms_verify($phone_number, $otpCode)
    // {
    //     $sid = 'AC96de1ca80ef697962057257ad67a0ce7';
    //     $token = '0faf3b3b49f8a50cdbecf57ac9a02647';
    //     $from = '+17176708083'; // Your Twilio SMS number
    //     $to = $phone_number; // Make sure this has country code

    //     $client = new Client($sid, $token);

    //     $message = "Your verification code is: " . $otpCode;

    //     try {
    //         $client->messages->create($to, [
    //             'from' => $from,
    //             'body' => $message
    //         ]);
    //     } catch (\Exception $e) {
    //         Yii::error("SMS error: " . $e->getMessage());
    //     }
    // }

    public static function send_whatsapp_verify($phone_number, $otpCode)
    {
        $sid = 'AC96de1ca80ef697962057257ad67a0ce7';
        $token = '0faf3b3b49f8a50cdbecf57ac9a02647';
        $from = 'whatsapp:+17176708083'; // Twilio sandbox number
        $to = 'whatsapp:' . $phone_number;

        $client = new Client($sid, $token);

        $message = "Your WhatsApp verification code is: " . $otpCode;

        try {
            $client->messages->create($to, [
                'from' => $from,
                'body' => $message
            ]);
        } catch (\Exception $e) {
            Yii::error("WhatsApp error: " . $e->getMessage());
        }
    }
}
