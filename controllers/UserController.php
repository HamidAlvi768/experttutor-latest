<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserVerifications;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\TwilioHelper;
use yii\helpers\BaseUrl;

class UserController extends Controller
{
    public function beforeAction($action)
    {
        $actionId = $action->id;
        $controllerId = $this->id;

        // PUBLIC ACTIONS
        $publicActions = ['index', 'contact', 'verify', 'about', 'login', 'signup', 'error'];

        // Check if user is guest and trying to access restricted area
        if (Yii::$app->user->isGuest && !in_array($actionId, $publicActions)) {
            Yii::$app->session->setFlash('error', 'Please login to access this page.');
            Yii::$app->response->redirect(['/login'])->send();
            return false;
        }

        // Role-based access control
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity;
            $userRole = $user->role;

            // check user verificaiton
            if (!$user->verification && ($actionId != "verification" && $actionId != "verify")) {
                return $this->redirect(['/verification']);
            }

            // Define role-specific permissions
            $permissions = [
                'superadmin' => ['*'],
                'admin' => ['*'],
                'tutor' => ['verify-phone', 'view', 'create', 'update'],
                'student' => ['verify-phone', 'view', 'create', 'update'],
            ];

            // Check if user has permission
            if (!in_array($actionId, $permissions[$userRole]) && $permissions[$userRole] !== ['*']) {
                Yii::$app->session->setFlash('error', 'You do not have permission to access this page.');
                return $this->redirect(['/']);
            }
        }

        return parent::beforeAction($action);
    }
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Authenticated users
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            $model->setPassword($model->password_hash);
            $model->generateAuthKey();
            $model->generateAccessToken();

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    // public function actionVerifyPhone()
    // {
    //     $user = User::find()->with(['profile', 'userVerifications'])->where(['id' => Yii::$app->user->identity->id])->one();

    //     send_sms_verify();

    //     send_whatsapp_verify();

    //     if (Yii::$app->request->isPost) {
    //         $postData = Yii::$app->request->post();
    //         $otpData = $postData['otp'];
    //         $otp = implode('', $otpData);

    //         $userVerification = UserVerifications::find()->where(['user_id' => $user->id])->one();

    //         $attempts = $userVerification->phone_verification_attempts;
    //         $userVerification->phone_verification_attempts = $attempts;

    //         switch ($userVerification->phone_verification_code == $otp) {
    //             case true:
    //                 $userVerification->phone_verified = 1;
    //                 $userVerification->save();
    //                 Yii::$app->session->setFlash('success', 'Phone number successfully verified!');
    //                 return $this->redirect(['/post/list']);
    //             case false:
    //                 Yii::$app->session->setFlash('error', 'Invalid verification code!');
    //                 return $this->redirect(['verify-phone']);
    //         }
    //     }
    //     $this->layout = "main_login";

    //     return $this->render('verify-phone', ['user' => $user]);
    // }

    // public function actionVerifyPhone()
    // {
    //     $user = User::find()->with(['profile', 'userVerifications'])->where(['id' => Yii::$app->user->identity->id])->one();
    //     $otp = rand(100000, 999999);

    //     //TwilioHelper::send_sms_verify($user);
    //     TwilioHelper::send_sms_verify($user->profile->phone_number, $otp);

    //     if (Yii::$app->request->isPost) {
    //         $postData = Yii::$app->request->post();
    //         $otpData = $postData['otp'];
    //         $otp = implode('', $otpData);

    //         $userVerification = $user->userVerifications;

    //         $attempts = $userVerification->phone_verification_attempts;
    //         $userVerification->phone_verification_attempts = $attempts;

    //         if ($userVerification->phone_verification_code == $otp) {
    //             $userVerification->phone_verified = 1;
    //             $userVerification->save();
    //             Yii::$app->session->setFlash('success', 'Phone number successfully verified!');
    //             return $this->redirect(['/post/list']);
    //         } else {
    //             Yii::$app->session->setFlash('error', 'Invalid verification code!');
    //             return $this->redirect(['verify-phone']);
    //         }
    //     }

    //     $this->layout = "main_login";
    //     return $this->render('verify-phone', ['user' => $user]);
    // }

  public function actionVerifyPhone()
{
    $user_id = Yii::$app->user->identity->id;
    $user = User::find()->with(['profile', 'userVerifications'])->where(['id' => $user_id])->one();

    if (!$user || !$user->profile || empty($user->profile->phone_number)) {
        Yii::$app->session->setFlash('error', 'Phone number not found.');
        return $this->goHome();
    }

    // Get or create latest verification record
    $userVerification = UserVerifications::find()->where(['user_id' => $user_id])
        ->orderBy(['created_at' => SORT_DESC])
        ->one();

      if($userVerification->phone_verified==1)  
      {

        return $this->redirect(Yii::$app->request->baseUrl );


      }

    if (!$userVerification) {
        $userVerification = new UserVerifications();
        $userVerification->user_id = $user_id;
    }

    // Handle POST request
    if (Yii::$app->request->isPost) {
        $postData = Yii::$app->request->post();
        $otpInput = implode('', $postData['otp'] ?? []); // In case it's sent as array

        if ($userVerification->phone_verification_code == $otpInput) {
            $userVerification->phone_verified = 1;
            $userVerification->save(false);
            Yii::$app->session->setFlash('success', 'Phone number successfully verified!');
            return $this->redirect(['/post/list']);
        } else {
            $userVerification->phone_verification_attempts += 1;
            $userVerification->save(false);
            Yii::$app->session->setFlash('error', 'Invalid verification code!');
            return $this->redirect(['verify-phone']);
        }
    }

    if (Yii::$app->request->isGet && !Yii::$app->session->hasFlash('error')) {
        $otp = rand(100000, 999999);
        $userVerification->phone_verification_code = (string)$otp;
        $userVerification->phone_verification_attempts = 0;
        $userVerification->save(false);
    }


    // Send the OTP
   // TwilioHelper::send_sms_verify($user->profile->phone_number, $otp);

    $this->layout = "verify_layout";
    return $this->render('verify-phone', ['user' => $user]);
}





    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
