<?php

namespace app\controllers;

use Yii;
use app\models\Profiles;
use app\models\User;
use app\models\UserVerifications;
use yii\debug\models\search\Profile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;

/**
 * ProfilesController handles CRUD actions for Profiles model.
 */
class ProfileController extends Controller
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
                'tutor' => ['teacher-profile', 'subject-teach', 'education-experience', 'professional-experience', 'teaching-details', 'teacher-description'],
                'student' => ['view', 'create', 'update'],
            ];

            // Check if user has permission
            if (!in_array($actionId, $permissions[$userRole]) && $permissions[$userRole] !== ['*']) {
                Yii::$app->session->setFlash('error', 'You do not have permission to access this page.');
                return $this->redirect(['site/index']);
            }
        }

        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Profiles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $user = User::find()->where(['profile'])->where(['id' => Yii::$app->user->identity->id]);
        if ($user->role == "tutor" || $user->role == "student") {
            $this->layout = "tutor_layout";
        }

        return $this->render('index', [
            'user' => $user,
        ]);
    }

    public function actionView()
    {
        $id = Yii::$app->user->identity->id;
        $model = Profiles::find()->where(['user_id' => $id])->one();

        $userRole = Yii::$app->user->identity->role;
        if ($userRole == "tutor" || $userRole == "student") {
            $this->layout = "tutor_layout";
        }

        if (!$model) {
            return $this->redirect(['create']);
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        
        // Check is profile details created
        $id = Yii::$app->user->identity->id;
        $model = Profiles::find()->where(['user_id' => $id])->one();
        if ($model) {
            return $this->redirect(['view']);
        }

        $model = new Profiles();

        if (Yii::$app->request->isPost) {
            //var_dump(Yii::$app->request->post());die;
            if ($model->load(Yii::$app->request->post())) {
                $model->user_id = $id;

                // Handle image upload
                $model->avatarFile = UploadedFile::getInstance($model, 'avatarFile');

                // ✅ Validate model first while temp file still exists
                if ($model->validate()) {
                    // ✅ Upload avatar before calling save()
                    if ($model->avatarFile) {
                        $avatarPath = $model->uploadAvatar();
                        if ($avatarPath) {
                            $model->avatar_url = $avatarPath;
                        }
                    }
                }

                if ($model->save(false)) {



                $user_mod = User::findOne($id);
                
                if ($user_mod) {


                    $user_mod->username = trim($model->full_name);
                    
                    $user_mod->save(false);
                }
   
       






                    $userVerification = UserVerifications::find()->where(['user_id' => $id])->one();
                    if ($userVerification) {
                        $otpCode = str_pad(random_int(0, 999999), 5, '0', STR_PAD_LEFT);
                        $userVerification->phone_number = $model->phone_number;
                        $userVerification->phone_verification_code = $otpCode;
                        $userVerification->phone_verified = 0;
                        $userVerification->save();
                    }
                    Yii::$app->session->setFlash('success', 'Profile Updated Successfully.');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                                if (!$model->validate()) {
                        \Yii::error($model->errors, __METHOD__);
                    }
            }
        }

        $userRole = Yii::$app->user->identity->role;
        if ($userRole == "tutor" || $userRole == "student") {
            $this->layout = "tutor_layout";
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate()
    {
        $id = Yii::$app->user->identity->id;
        $model = Profiles::find()->where(['user_id' => $id])->one();
        if (!$model) {
            return $this->redirect(['create']);
        }
//////////////////////////////



        // Get new uploaded file
        $model->avatarFile = UploadedFile::getInstance($model, 'avatarFile');

        if ($model->validate()) {
            if ($model->avatarFile) {
                // Delete old file if it exists
                if (!empty($model->avatar_url) && file_exists(Yii::getAlias('@webroot') . $model->avatar_url)) {
                    @unlink(Yii::getAlias('@webroot') . $model->avatar_url);
                }

                // Upload new file
                $avatarPath = $model->uploadAvatar();
                if ($avatarPath) {
                    $model->avatar_url = $avatarPath;
                }
            }



        }
////////////////////////////

        if ($model->load(Yii::$app->request->post()) && $model->save()) {



                $user_mod = User::findOne($id);
                
                if ($user_mod) {


                    $user_mod->username = trim($model->full_name);
                    
                    $user_mod->save(false);
                }

                                if (!$model->validate()) {
                        \Yii::error($model->errors, __METHOD__);
                    }


            Yii::$app->session->setFlash('success', 'Profile Updated Successfully.');
            return $this->redirect(['update', 'id' => $model->id]);
        }

        $userRole = Yii::$app->user->identity->role;
        if ($userRole == "tutor" || $userRole == "student") {
            $this->layout = "tutor_layout";
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


    protected function findModel($id)
    {
        if (($model = Profiles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested profile does not exist.');
    }
}
