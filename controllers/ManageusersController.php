<?php

namespace app\controllers;

use Yii;

use app\models\Manageusers;
use app\models\ManageusersSearch;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ManageusersController implements the CRUD actions for Manageusers model.
 */
class ManageusersController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function beforeAction($action)
    {

        $actionId = $action->id;
        $controllerId = $this->id;

        // PUBLIC ACTIONS
        $publicActions = ['contact', 'verify', 'about', 'login', 'signup', 'error'];

        // Check if user is guest and trying to access restricted area
        if (Yii::$app->user->isGuest && !in_array($actionId, $publicActions)) {
            Yii::$app->session->setFlash('error', 'Please login to access this page.');
            Yii::$app->response->redirect(['/login'])->send();
            return false;
        }

        // echo Yii::$app->user->isGuest ? "Guest" : "Logged User";
        // die;

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
                'tutor' => [],         // no access
                'student' => [],

            ];

            // Check if user has permission
            if (!in_array($actionId, $permissions[$userRole]) && $permissions[$userRole] !== ['*']) {
                Yii::$app->session->setFlash('error', 'You do not have permission to access this page.');
                return $this->redirect(['/']);
            }
        }

        return parent::beforeAction($action);
    }
    /**
     * Lists all Manageusers models.
     *
     * @return string
     */
    public function actionIndex()
    {
        //var_dump(Yii::$app->name);die;
        $role = '';
        $searchModel = new ManageusersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $role);
        //     $dataProvider = new ActiveDataProvider([
        //    // 'query' => Manageusers::find()->where(['!=', 'role', 'superadmin']),
        //     'pagination' => [
        //         'pageSize' => 20,
        //     ],
        // ]);
        $this->layout = "admin_layout";
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title'=>'Manage Users'
        ]);
    }

        public function actionStudents()
    {
        $role = 'student';
        $searchModel = new ManageusersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $role);

        $this->layout = 'admin_layout';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'role' => $role,
            'title'=>'Manage Students'
        ]);
    }

            public function actionTutors()
    {
        $role = 'tutor';
        $searchModel = new ManageusersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams, $role);

        $this->layout = 'admin_layout';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'role' => $role,
            'title'=>'Manage Tutors'
        ]);
    }
    /**
     * Displays a single Manageusers model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = "admin_layout";
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Manageusers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Manageusers();

        if ($this->request->isPost) {


            if ($model->load($this->request->post())) {

                   // only hash if plain password is set
        if (!empty($model->plainPassword)) {
            $model->setPassword($model->plainPassword);  // hash & set to password_hash
        }
                $model->generateAuthKey();
                $model->generateAccessToken();

                $model->user_slug = User::generateUniqueSlug($model->username);

                if ($model->save()) {

                    
                    if(Yii::$app->request->get('user')=='student')
                    {
                    $red_url='students';
                    Yii::$app->session->setFlash('success', 'Student created successfully.');
                    }else{
                    $red_url='tutors';
                    Yii::$app->session->setFlash('success', 'Tutor created successfully.');

                    }
                    return $this->redirect([$red_url, 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        $this->layout = "admin_layout";
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Manageusers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) ) {


            if($model->save(false)) {
                                if(Yii::$app->request->get('user')=='student')
                    {
                    $red_url='students';
                    Yii::$app->session->setFlash('success', 'Student updated successfully.');
                    }else{
                    $red_url='tutors';
                    Yii::$app->session->setFlash('success', 'Tutor updated successfully.');

                    }
                    return $this->redirect([$red_url, 'id' => $model->id]);
            }else{
                // echo '<pre>'
                // . print_r($model->getErrors(), true)
                // . '</pre>';die;
                Yii::$app->session->setFlash('error', 'Failed to update user. Please check the errors.');
            }
        }

        $this->layout = "admin_layout";
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Manageusers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        User::findOne($id)->delete();
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'User deleted successfully.');

    return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    /**
     * Finds the Manageusers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Manageusers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Manageusers::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
