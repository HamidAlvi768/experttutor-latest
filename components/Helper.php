<?php

namespace app\components;

use app\models\GenericRecords;
use app\models\Profiles;
use app\models\StudentJobPosts;
use app\models\User;
use app\models\UserVerifications;
use app\models\Wallets;
use app\models\WalletTransactions;
use DateTimeZone;
use PhpParser\Node\Expr\StaticCall;
use Yii;
use yii\helpers\Html;

class Helper
{
    public static function getRoles()
    {
        return [
            'superadmin' => 'Super Admin',
            'admin' => 'Admin',
            'client' => 'Client',
            // 'driver' => 'Driver',
        ];
    }
    public static function getBookingStatus($notNeedStatusArray = null)
    {
        $status = [
            'Quoted' => 'Quoted',
            'Confirmed' => 'Confirmed',
            'Onway' => 'On the Way',
            'Delivered' => 'Delivered',
            'Canceled' => 'Canceled',
        ];
        if ($notNeedStatusArray != null) {
            foreach ($notNeedStatusArray as $key) {
                unset($status[$key]);
            }
        }
        return $status;
    }

    public static function generateRandomString()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // 26 letters + 10 digits
        $result = '';

        for ($i = 0; $i < 11; $i++) {
            $randomIndex = rand(0, strlen($characters) - 1);
            $result .= $characters[$randomIndex];
        }

        return $result;
    }
    public static function logo()
    {
        echo self::baseUrl("custom-assets/images/logo.png");
    }
    public static function baseUrl($path = '')
    {
        if (class_exists('\Yii')) {
            return \Yii::$app->getUrlManager()->createAbsoluteUrl($path);
        }

        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $host = $_SERVER['HTTP_HOST'];
        $baseUrl = $protocol . $host . '/';

        return $baseUrl . ltrim($path, '/');
    }

    public static function oldOrNewValue($fieldName, $newValue = '')
    {
        if (isset($_POST[$fieldName])) {
            return htmlspecialchars($_POST[$fieldName], ENT_QUOTES, 'UTF-8');
        }
        return htmlspecialchars($newValue, ENT_QUOTES, 'UTF-8');
    }
    public static function csrf()
    {
        echo Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken);
    }

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
        $content = ob_get_clean();

        return $content;
    }
    public static function generateRandomPassword($length = 8)
    {
        return Yii::$app->security->generateRandomString($length); // Random string for password
    }


    // function to round prices
    public static function roundPrice($price)
    {
        return round($price);
    }

    // Send Verification Email
    public static function SendVerificationMail($to, $name, $verificationLink)
    {
        if (empty($to) || empty($name) || empty($verificationLink)) {
            Yii::error('Invalid parameters for sending verification email.');
            return false;
        }
        try {
            return Yii::$app->mailer->compose('verification-email', [
                'username' => $name,
                'verificationLink' => $verificationLink
            ])
                ->setTo($to)
                ->setFrom(['twenty47logistics@leightonbuzzardairportcabs.co.uk' => 'Expert Tutor'])
                ->setSubject('Verify your email address')
                ->send();
        } catch (\Exception $e) {
            Yii::error('Failed to send verification email: ' . $e->getMessage());
            return false;
        }
    }

    public static function getTimeZones()
    {
        $timezones = [];
        $identifiers = DateTimeZone::listIdentifiers();

        foreach ($identifiers as $identifier) {
            $timezones[$identifier] = $identifier;
        }

        return $timezones;
    }

    public static function generateReferralCode($userName, $userId)
    {
        $cleanUserName = preg_replace('/[^A-Za-z0-9]/', '', $userName);
        $currentTime = date('YmdHis');
        $randomPart = substr(md5(uniqid(rand(), true)), 0, 4);
        return "{$cleanUserName}{$userId}{$currentTime}{$randomPart}";
    }

    public static function getCurrency()
    {
        $currency = 'USD';
        return $currency;
    }


    public static function getGenericRecord($type)
    {
        $records = GenericRecords::find()
            ->where(['type' => $type, 'active' => 1])
            ->andWhere(['IS NOT', 'parent_id', null])
            ->orderBy(['title' => SORT_ASC])
            ->all();


        return $records;
    }

    public static function createwallet($id, $balance = 0, $type = null)
    {

        $wallet = new Wallets();
        $wallet->user_id = $id;
        $wallet->balance = $balance;
        $wallet->user_type = $type;
        $wallet->currency = "Coins";
        $wallet->active = 1;
        $wallet->save();

        return $wallet;
    }

        public static function getuserphoneverified($id='')
    {

        //UserVerifications::find()->where(['user_id' => $id, 'phone_verified' => 1])->one();
        return UserVerifications::find()->where(['user_id' => $id, 'phone_verified' => 1])->one();;
    }
    public static function getdefaultrecharge()
    {

        return 10000;
    }
    public static function admin_recharge($depositCoins, $desciption = "Coins Recharged By Admin.")
    {

        $adminWallet = Wallets::find()->where(['user_type' => 'superadmin'])->one();
        $adminWallet->balance += $depositCoins;
        $adminWallet->save();


        $transaction = new WalletTransactions();
        $transaction->wallet_id = $adminWallet->id;
        $transaction->transaction_type = "credit";
        $transaction->amount = $depositCoins;
        $transaction->description = "{$depositCoins} {$desciption}";
        $transaction->status = "completed";
        $transaction->transaction_date = date('Y-m-d H:i:s'); // set timestamp
        $transaction->save();

        return $transaction;
    }

    public static function getuserimage($id)
    {

        $profile_data = Profiles::find()->where(['user_id' => $id])->one();

        if (isset($profile_data)) {
            return $profile_data->avatar_url;
        } else {
            return false;
        }
    }

    public static function getuseridfromslug($slug)
    {

        $user = User::find()->where(['user_slug' => $slug])->one();

        if (isset($user)) {
            return $user->id;
        } else {
            return false;
        }
    }

    
    public static function getuserslugfromid($id)
    {

        $user = User::find()->where(['id' => $id])->one();

        if (isset($user)) {
            return $user->user_slug;
        } else {
            return false;
        }
    }
    // public static function adminwalletdebit(){


    //         $adminWallet = Wallets::find()->where(['user_type' => 'superadmin'])->one();
    //         $adminWallet->balance -= $depositCoins;
    //         $adminWallet->save();

    //         $transaction = new WalletTransactions();
    //         $transaction->wallet_id = $adminWallet->id;
    //         $transaction->transaction_type = "debit";
    //         $transaction->amount = $depositCoins;
    //         $transaction->description = "{$depositCoins} Coins purchased By Tutor {$tutor_name}.";
    //         $transaction->status = "completed";
    //         $transaction->save();
    // }


public static function hasActiveJobConversation($studentId, $tutorId)
{
   
//    $job_conver=(new \yii\db\Query())
//     ->from('student_job_posts sjp')
//     ->innerJoin('job_applications ja', 'sjp.id = ja.job_id')
//     ->where([
//         'sjp.posted_by'   => $studentId,
//         'ja.applicant_id' => $tutorId,
//     ])->exists();
 
    //->andWhere(['!=', 'sjp.post_status', 'complete']) // <-- fixed
    //->andWhere(['ja.application_status' => 'accepted'])



$job_conver = (new \yii\db\Query())
    ->from('chat_messages sjp')
    ->where([
        'sjp.sender_id'   => $studentId,
        'sjp.receiver_id' => $tutorId,
    ])
    ->andWhere(['IS NOT', 'sjp.job_post_id', null]) // ✅ proper check
    ->exists();

$direct_conver = (new \yii\db\Query())
    ->from('chat_messages sjp')
    ->where([
        'sjp.sender_id'   => $studentId,
        'sjp.receiver_id' => $tutorId,
    ])
    ->andWhere(['sjp.is_read' => 1]) // ✅ correct array condition
    ->exists();


$direct_conver2 = (new \yii\db\Query())
    ->from('chat_messages sjp')
    ->where([
        'sjp.sender_id'   => $tutorId,
        'sjp.receiver_id' => $studentId,
    ])
  
    ->exists();

    if($job_conver || $direct_conver || $direct_conver2){
        return true;
    }else{
        return false;
    }

}


}
