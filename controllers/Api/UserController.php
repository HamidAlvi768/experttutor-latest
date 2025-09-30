<?php

namespace app\controllers\api;

use app\components\Helper;
use app\components\JwtHelper;
use app\components\Mail;
use app\components\TwilioHelper;
use app\components\Wallet;
use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use app\models\Profiles;
use app\models\Referrals;
use app\models\User;
use app\models\UserVerifications;

class UserController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // Set response format to JSON
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    public function beforeAction($action)
{

    // Set response to JSON for API
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


  

    $actionId = $action->id;
    $controllerId = $this->id;

    // Actions accessible without login
    $publicActions = ['index', 'contact', 'verify', 'about', 'login', 'signup', 'error'];

    // Case 1: Guest trying to access restricted action
    if (Yii::$app->user->isGuest && !in_array($actionId, $publicActions)) {
        Yii::$app->response->statusCode = 401;
        Yii::$app->response->data = [
            'success' => false,
            'message' => 'Please login to access this resource.'
        ];
        return false;
    }

    // Case 2: Logged-in user
    if (!Yii::$app->user->isGuest) {
        $user = Yii::$app->user->identity;
        $userRole = $user->role;

        // Case 2a: User not verified and trying to access other actions
        if (!$user->verification && !in_array($actionId, ['verification', 'verify'])) {
            Yii::$app->response->statusCode = 403;
            Yii::$app->response->data = [
                'success' => false,
                'message' => 'Account not verified. Please verify your account first.'
            ];
            return false;
        }

        // Case 2b: Role-based permissions
        // $permissions = [
        //     'superadmin' => ['*'],
        //     'admin' => ['*'],
        //     'tutor' => ['verify-phone', 'view', 'create', 'update'],
        //     'student' => ['verify-phone', 'view', 'create', 'update'],
        // ];

        // // Check permission
        // if (!in_array($actionId, $permissions[$userRole]) && $permissions[$userRole] !== ['*']) {
        //     Yii::$app->response->statusCode = 403;
        //     Yii::$app->response->data = [
        //         'success' => false,
        //         'message' => 'You do not have permission to access this resource.'
        //     ];
        //     return false;
        // }
    }

    // If all checks pass
    return parent::beforeAction($action);
}


    // GET /api/user/profile
    public function actionProfile()
    {

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }
 
        $id = Yii::$app->user->id;

        if (!$id) {
            return ['success' => false, 'message' => 'Unauthorized'];
        }

        $model = Profiles::find()->where(['user_id' => $id])->one();

        if (!$model) {
            return ['success' => false, 'message' => 'Profile not found'];
        }

        return ['success' => true, 'data' => $model];
    }

    // POST /api/user/create-profile
    public function actionCreateProfile()
    {


        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        $id = Yii::$app->user->id;

        if (!$id) {
            return ['success' => false, 'message' => 'Unauthorized'];
        }

        $existing = Profiles::find()->where(['user_id' => $id])->one();
        if ($existing) {
            return ['success' => false, 'message' => 'Profile already exists'];
        }

        $model = new Profiles();
        $model->user_id = $id;

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            // Handle verification
            $verification = UserVerifications::find()->where(['user_id' => $id])->one();
            if ($verification) {
                $otpCode = str_pad(random_int(0, 999999), 5, '0', STR_PAD_LEFT);
                $verification->phone_number = $model->phone_number;
                $verification->phone_verification_code = $otpCode;
                $verification->phone_verified = 0;
                $verification->save();
            }

            return ['success' => true, 'message' => 'Profile created', 'data' => $model];
        }

        return ['success' => false, 'message' => 'Failed to create profile', 'errors' => $model->getErrors()];
    }

    // PUT /api/user/update-profile
    public function actionUpdateProfile()
    {
        //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //

        $id = Yii::$app->user->id;

        if (!$id) {
            return ['success' => false, 'message' => 'Unauthorized'];
        }

        $model = Profiles::find()->where(['user_id' => $id])->one();

        if (!$model) {
            return ['success' => false, 'message' => 'Profile not found'];
        }

        $data = Yii::$app->request->bodyParams;

        if ($model->load($data, '') && $model->save()) {
            return ['success' => true, 'message' => 'Profile updated', 'data' => $model];
        }

        return ['success' => false, 'message' => 'Failed to update profile', 'errors' => $model->getErrors()];
    }

    public function actionVerifyPhone()
{
    
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
    $user = Yii::$app->user->identity;

    if (!$user || !$user->profile || empty($user->profile->phone_number)) {
        return ['success' => false, 'message' => 'Phone number not found.'];
    }

    $userVerification = UserVerifications::find()
        ->where(['user_id' => $user->id])
        ->orderBy(['created_at' => SORT_DESC])
        ->one();

    if ($userVerification && $userVerification->phone_verified == 1) {
        return ['success' => true, 'message' => 'Phone number already verified.'];
    }

    // Create new record if none found
    if (!$userVerification) {
        $userVerification = new UserVerifications();
        $userVerification->user_id = $user->id;
    }

    // POST: Verify submitted OTP
    if (Yii::$app->request->isPost) {
        $data = Yii::$app->request->bodyParams;
        $otpInput = isset($data['otp']) ? trim($data['otp']) : null;

        if (!$otpInput) {
            return ['success' => false, 'message' => 'OTP is required.'];
        }

        if ($userVerification->phone_verification_code == $otpInput) {
            $userVerification->phone_verified = 1;
            $userVerification->save(false);
            return ['success' => true, 'message' => 'Phone number successfully verified.'];
        } else {
            $userVerification->phone_verification_attempts += 1;
            $userVerification->save(false);
            return ['success' => false, 'message' => 'Invalid verification code.'];
        }
    }

    // GET: Generate and send OTP
    $otp = rand(100000, 999999);
    $userVerification->phone_verification_code = (string)$otp;
    $userVerification->phone_verification_attempts = 0;
    $userVerification->save(false);

    // Send via SMS
    TwilioHelper::send_sms_verify($user->profile->phone_number, $otp);

    return [
        'success' => true,
        'message' => 'OTP sent successfully.',
        'phone' => $user->profile->phone_number,
    ];
}

       public function actionResendVerification()
    {
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        $user = Yii::$app->user->identity;

        if (!$user) {
            return ['success' => false, 'message' => 'User not authenticated.'];
        }

        $token = Yii::$app->security->generateRandomString();
        $verificationLink = Helper::baseUrl("/verify?token={$token}");

        $userVerification = new UserVerifications();
        $userVerification->user_id = $user->id;
        $userVerification->email = $user->email;
        $userVerification->email_verification_link = $verificationLink;
        $userVerification->email_verification_expires = date('Y-m-d H:i:s', strtotime('+24 hours'));

        if (!$userVerification->save()) {
            return ['success' => false, 'message' => 'Error saving verification.', 'errors' => $userVerification->getErrors()];
        }

        $mailStatus = Mail::send(
            $user->email,
            'Email Verification',
            'mail/verification-email.php',
            [
                'username' => $user->username,
                'verificationLink' => $verificationLink,
            ]
        );

        if (!$mailStatus['status']) {
            return ['success' => false, 'message' => 'Failed to send email.', 'mail' => $mailStatus];
        }

        return ['success' => true, 'message' => 'Verification email resent successfully.'];
    }

    /**
     * GET /api/user/verify?token=xxxxx
     */
    public function actionVerify($token)
    {
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        $verificationUrl = Helper::baseUrl("/verify?token={$token}");

        $userVerification = UserVerifications::find()
            ->where(['email_verification_link' => $verificationUrl])
            ->orderBy(['created_at' => SORT_DESC])
            ->one();

        if (!$userVerification) {
            return ['success' => false, 'message' => 'Invalid or expired verification link.'];
        }

        if ($userVerification->email_verification_expires < date('Y-m-d H:i:s')) {
            return ['success' => false, 'message' => 'Verification link has expired.'];
        }

        $user = User::findOne($userVerification->user_id);
        if (!$user) {
            return ['success' => false, 'message' => 'User not found.'];
        }

        $userVerification->email_verified = 1;
        $userVerification->email_verification_attempts += 1;
        $userVerification->save();

        $referral = Referrals::find()->where(['referred_user_id' => $user->id])->one();
        if ($referral) {
            $referral->referral_status = 'Verified';
            $referral->save();

            Wallet::Credit($referral->referrer_id, 50, 'received', 'Received on referral verification.');
        }

        $user->verification = 1;
        $user->save();

        return ['success' => true, 'message' => 'Email verified successfully.'];
    }


    // DELETE /api/user/delete-profile
    // public function actionDeleteProfile()
    // {
    //     $id = Yii::$app->user->id;

    //     if (!$id) {
    //         return ['success' => false, 'message' => 'Unauthorized'];
    //     }

    //     $model = Profiles::find()->where(['user_id' => $id])->one();

    //     if (!$model) {
    //         return ['success' => false, 'message' => 'Profile not found'];
    //     }

    //     $model->delete();
    //     return ['success' => true, 'message' => 'Profile deleted'];
    // }
}
