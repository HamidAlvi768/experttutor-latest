<?php 
namespace app\controllers\api;

use app\components\Helper;
use yii\rest\Controller;
use Yii;
use app\models\User;
use app\models\LoginForm;
use yii\web\Response;
use app\components\JwtHelper;
use app\components\Mail;
use app\components\Wallet;
use app\models\Referrals;
use app\models\UserVerifications;

class AuthController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    // public function actionLogin()
    // {


    //     $model = new LoginForm();

    //     if (Yii::$app->request->isPost) {
    //         $data = Yii::$app->request->post();

    //         if ($model->load($data, '') && $model->login()) {
                
    //             $user = Yii::$app->user->identity;
    //             $token = JwtHelper::generateToken($user->id); // ✅ Generate JWT

    //             return [
    //                 'success' => true,
    //                 'message' => 'Login successful',
    //                 'token' => $token,
    //                 'user' => [
    //                     'id' => $user->id,
    //                     'username' => $user->username,
    //                     'email' => $user->email,
    //                     //'token' => $user->auth_key, // or JWT
    //                 ],
    //             ];
    //         }
    //     }

    //     return [
    //         'success' => false,
    //         'message' => 'Invalid username or password',
    //         'errors' => $model->getErrors(),
    //     ];
    // }

    public function actionLogin()
{
    $model = new LoginForm();

    if (Yii::$app->request->isPost) {
        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->login()) {
            $user = Yii::$app->user->identity;

            // ✅ Use helper to generate both tokens
            $tokens = JwtHelper::generateTokens($user->id);

            return [
                'success' => true,
                'message' => 'Login successful',
                'access_token' => $tokens['access_token'],
                'refresh_token' => $tokens['refresh_token'],
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                ],
            ];
        }
    }

    return [
        'success' => false,
        'message' => 'Invalid username or password',
        'errors' => $model->getErrors(),
    ];
}


    public function actionLogout()
    {
        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
            Yii::$app->response->statusCode = 401;
            return ['success' => false, 'message' => 'Unauthorized'];
        }


        $user = Yii::$app->user->identity;
        Yii::$app->user->logout();
        return [
            'user_id'=>$user->id,
            'success' => true,
            'message' => 'Logged out successfully',
        ];
    }

    public function actionSignup()
    {
        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
            Yii::$app->response->statusCode = 401;
            return ['success' => false, 'message' => 'Unauthorized'];
        }

        $model = new \app\models\SignupForm();
        $post = Yii::$app->request->post();

        if ($model->load($post, '') && $model->usersignup()) {
            return [
                'success' => true,
                'message' => 'Signup successful. Please verify email.',
            ];
        }

        return [
            'success' => false,
            'message' => 'Signup failed',
            'errors' => $model->getErrors(),
        ];
    }


 

    

}
