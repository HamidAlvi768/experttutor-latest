<?php

namespace app\controllers\api;

use Yii;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use app\components\Helper;
use app\components\JwtHelper;
use app\models\StudentJobPosts;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class StudentController extends Controller{

        public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;

        return $behaviors;
    }
    public function beforeAction($action)
    {

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; // ADD THIS


        $publicActions = ['index'];
        $actionId = $action->id;

        if (Yii::$app->user->isGuest && !in_array($actionId, $publicActions)) {
            Yii::$app->response->statusCode = 401;
            Yii::$app->response->data = ['message' => 'Unauthorized. Please login.'];
            return false;
        }

        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity;

            if (!$user->verification && !in_array($actionId, ['verify', 'verification'])) {
                Yii::$app->response->statusCode = 403;
                Yii::$app->response->data = ['message' => 'Verification required.'];
                return false;
            }

            $permissions = [
                'superadmin' => ['*'],
                'admin' => ['*'],
                'tutor' => [''],
                'student' => ['*'],
            ];

            $role = $user->role;
            if (isset($permissions[$role]) && $permissions[$role] !== ['*'] && !in_array($actionId, $permissions[$role])) {
                Yii::$app->response->statusCode = 403;
                Yii::$app->response->data = ['message' => 'Access denied.'];
                return false;
            }
        }

        return parent::beforeAction($action);
    }

    public function actionList()
    {
                        //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        
        $id = Yii::$app->user->identity->id;
        $posts = StudentJobPosts::find()->where(['posted_by' => $id])->orderBy(['created_at' => SORT_DESC])->all();
        return ['success' => true, 'data' => $posts];
    }

    public function actionView($id)
    {
                        //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        $model = $this->findModel($id);
        return ['success' => true, 'data' => $model];
    }

    public function actionCreate()
    {

                        //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        $model = new StudentJobPosts();
        $model->posted_by = Yii::$app->user->id;

        $data = Yii::$app->request->post();
        if ($model->load(['StudentJobPosts' => $data]) && $model->save()) {
            return ['success' => true, 'data' => $model];
        }
        return ['success' => false, 'errors' => $model->errors];
    }

    public function actionUpdate($id)
    {

                        //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        $model = $this->findModel($id);

        $data = Yii::$app->request->bodyParams;
        if ($model->load(['StudentJobPosts' => $data]) && $model->save()) {
            return ['success' => true, 'data' => $model];
        }
        return ['success' => false, 'errors' => $model->errors];
    }

    public function actionDelete($id)
    {
                        //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        $model = $this->findModel($id);
        if ($model->delete()) {
            return ['success' => true, 'message' => 'Post deleted successfully'];
        }
        return ['success' => false, 'message' => 'Failed to delete post'];
    }

    public function actionFinishPost($id)
    {

                        //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        
        $post = StudentJobPosts::findOne($id);
        if ($post) {
            $post->post_status = 'complete';
            if ($post->save()) {
                return ['success' => true, 'message' => 'Post marked as completed'];
            }
            return ['success' => false, 'errors' => $post->errors];
        }
        throw new NotFoundHttpException("Post not found.");
    }

      protected function findModel($id)
    {
        if (($model = StudentJobPosts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested post does not exist.');
    }

}