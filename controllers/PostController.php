<?php

namespace app\controllers;

use Yii;
use app\models\JobApplications;
use app\models\Reviews;
use app\models\StudentJobPosts;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;



class PostController extends Controller
{
    public function beforeAction($action)
    {
        $actionId = $action->id;
        $controllerId = $this->id;

        // PUBLIC ACTIONS
        $publicActions = ['index', 'contact', 'verify', 'about', 'login', 'signup', 'error','review','view'];

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
                'tutor' => ['review'],
                'student' => ['*'],
            ];

            // Check if user has permission
            if (!in_array($actionId, $permissions[$userRole]) && $permissions[$userRole] !== ['*']) {

                //echo 'fdfdfd';die;
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    // public function actionList()
    // {
    //     $id = Yii::$app->user->identity->id;
    //     $query = StudentJobPosts::find()->where(['posted_by' => $id]);
    //     //$models = $query->all();
    //     $dataProvider = new ActiveDataProvider([
    //         'query' => $query,
    //         'pagination' => [
    //             'pageSize' => 10,
    //         ],
    //         'sort' => [
    //             'defaultOrder' => [
    //                 'created_at' => SORT_DESC,
    //             ],
    //         ],
    //     ]);




    //     $userRole = Yii::$app->user->identity->role;
    //     if ($userRole == "tutor" || $userRole == "student") {
    //         $this->layout = "tutor_layout";
    //     }

    //     return $this->render('list', [
    //         'dataProvider' => $dataProvider,
    //         //'models' => $models,
    //     ]);
    // }

    public function actionList()
    {
        $id = Yii::$app->user->identity->id;
        $status = Yii::$app->request->get('status'); // open, closed, or null

        $query = StudentJobPosts::find()->where(['posted_by' => $id]);

        // Apply status filter
        if ($status === 'open') {
            $query->andWhere(['post_status' => 'active']);
        } elseif ($status === 'closed') {
            $query->andWhere(['post_status' => 'complete']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]);

        $userRole = Yii::$app->user->identity->role;
        if ($userRole == "tutor" || $userRole == "student") {
            $this->layout = "tutor_layout";
        }

        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'status' => $status,
        ]);
    }

    public function actionReview()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->request->isPost) {

            // FIX: get job_id from POST instead of GET
            $job_id = Yii::$app->request->post('job_id');

            $role = Yii::$app->request->post('role');



            $review = new Reviews();



            if($role=='tutor'){

            $job_post= StudentJobPosts::find()->where(['id'=>$job_id])->one();

            if (!$job_post) {
                return ['success' => false, 'message' => 'Job Does Not Exist.'];
            }

            $tutorId = $job_post->posted_by;
            $review->user_type   = 'teacher';

            }else{

            $application = JobApplications::findOne([
                'job_id' => $job_id,
                'application_status' => 'accepted'
            ]);
            if (!$application) {
                return ['success' => false, 'message' => 'No Tutor Was Selected For This Job So You cannot review this job.'];
            }
            $tutorId = $application->applicant_id;
             $review->user_type   = 'student';

            }

            

            

            $rating  = Yii::$app->request->post('rating');
            $message = Yii::$app->request->post('review_message');
           

            
            $review->review_to   = $tutorId;                  // tutor ID
            $review->user_id   = Yii::$app->user->id;       // logged-in user
           
            $review->job_id      = $job_id;
            $review->star_rating = $rating;
            $review->review_text = $message;
            $review->created_by  = Yii::$app->user->id;
            $review->active      = 1;

           if( $review->save()){
           
            return ['success' => true, 'message' => 'Review saved successfully.'];
           }else{

            return ['success' => false, 'message'=> 'Failed To Save Review.'  ];

           }

               
        

         
        }

        return ['success' => false, 'message' => 'Invalid request.'];
    }




    public function actionEngagements()
    {
        $postId = Yii::$app->request->get("id");
        $post = StudentJobPosts::find()->with(['messages.sender'])->where(['id' => $postId])->one();


        $userRole = Yii::$app->user->identity->role;
        if ($userRole == "tutor" || $userRole == "student") {
            $this->layout = "tutor_layout";
        }


        return $this->render('engagements', [
            'post' => $post,
        ]);
    }

    public function actionView($id)
    {
        if (Yii::$app->user->identity->role == 'superadmin') {
            $this->layout = 'admin_layout';
        }
        $userRole = Yii::$app->user->identity->role;
        if ($userRole == "tutor" || $userRole == "student") {
            $this->layout = "tutor_layout";
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        // Debug: Output POST data
        // var_dump(Yii::$app->request->post());
                    $user = Yii::$app->user->identity;
            $userRole = $user->role;

        if (!$user->profile && $userRole = 'student' ) {
                Yii::$app->session->setFlash('error', 'Please complete your profile before  Posting Your Assignment.');
                return $this->redirect(['/profile/create'])->send();
            }



        $model = new StudentJobPosts();
        $model->posted_by = Yii::$app->user->id;
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->posted_by = Yii::$app->user->identity->id;


                // Handle image upload
                $model->documentsFile = UploadedFile::getInstance($model, 'document');

                // ✅ Validate model first while temp file still exists
                if ($model->validate()) {
                    // ✅ Upload avatar before calling save()
                    if ($model->documentsFile) {
                        $avatarPath = $model->uploadAvatar();
                        if ($avatarPath) {
                            $model->document = $avatarPath;
                        }
                    }
                }





                if ($model->save()) {

                    Yii::$app->session->setFlash('success', 'Job Posted Successfully.');

                    return $this->redirect(['/post/list']);
                } else {
                    // Output validation errors
                    Yii::error($model->errors, __METHOD__);
                    echo "<pre>";
                    print_r($model->errors);
                    echo "</pre>";
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

    protected function findModel($id)
    {
        if (($model = StudentJobPosts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested post does not exist.');
    }

    public function actionFinishPost()
    {
        $postId = Yii::$app->request->get("id");
        $post = StudentJobPosts::find()->where(['id' => $postId])->one();
        if ($post) {
            $post->post_status = 'complete';
   if ($post->save()) {
    Yii::$app->session->setFlash('success', 'Post marked as completed.');
} else {
    $error = implode(', ', $post->getFirstErrors());
    Yii::$app->session->setFlash('error', "Failed to mark post as completed. Yii says: $error");
}

        } else {
            Yii::$app->session->setFlash('error', 'Post not found.');
        }
        return $this->redirect(['list']);
    }

    /**
     * Accept a tutor request for a post
     */
    public function actionAcceptRequest()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (!Yii::$app->request->isAjax) {
            return ['success' => false, 'message' => 'Invalid request'];
        }

        $postData = Yii::$app->request->getBodyParams();
        $postId = $postData['post_id'] ?? null;
        $senderId = $postData['sender_id'] ?? null;
        $messageId = $postData['message_id'] ?? null;

        if (!$postId || !$senderId || !$messageId) {
            return ['success' => false, 'message' => 'Missing required parameters'];
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            // Get the post
            $post = StudentJobPosts::findOne($postId);
            if (!$post) {
                throw new \Exception('Post not found');
            }

            // Debug: Check what properties are available
            Yii::error('Post properties: ' . print_r($post->attributes, true), __METHOD__);

            // Check if post is already assigned by checking job_applications table
            $assignedTutor = Yii::$app->db->createCommand("
                SELECT applicant_id FROM job_applications 
                WHERE job_id = :post_id AND application_status = 'accepted'
            ", [':post_id' => $postId])->queryScalar();

            if ($assignedTutor) {
                throw new \Exception('This post is already assigned to another tutor');
            }

            // Update the post status to assigned
            $post->post_status = 'assigned';

            if (!$post->save()) {
                throw new \Exception('Failed to update post');
            }

            // Create or update request status record
            $this->saveRequestStatus($postId, $senderId, 'accepted');

            $transaction->commit();

            return [
                'success' => true,
                'message' => 'Request accepted successfully. Post is now closed for other tutors.'
            ];
        } catch (\Exception $e) {
            $transaction->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Reject a tutor request for a post
     */
    public function actionRejectRequest()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (!Yii::$app->request->isAjax) {
            return ['success' => false, 'message' => 'Invalid request'];
        }

        $postData = Yii::$app->request->getBodyParams();
        $postId = $postData['post_id'] ?? null;
        $senderId = $postData['sender_id'] ?? null;
        $messageId = $postData['message_id'] ?? null;

        if (!$postId || !$senderId || !$messageId) {
            return ['success' => false, 'message' => 'Missing required parameters'];
        }

        try {
            // Create or update request status record
            $this->saveRequestStatus($postId, $senderId, 'rejected');

            return [
                'success' => true,
                'message' => 'Request rejected successfully.'
            ];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Save request status to database
     */
    private function saveRequestStatus($postId, $tutorId, $status)
    {
        // Update the application status in job_applications table
        $existingApplication = Yii::$app->db->createCommand("
            SELECT id FROM job_applications 
            WHERE job_id = :post_id AND applicant_id = :tutor_id
        ", [':post_id' => $postId, ':tutor_id' => $tutorId])->queryScalar();

        if ($existingApplication) {
            Yii::$app->db->createCommand("
                UPDATE job_applications SET application_status = :status, updated_at = NOW() 
                WHERE job_id = :post_id AND applicant_id = :tutor_id
            ", [':status' => $status, ':post_id' => $postId, ':tutor_id' => $tutorId])->execute();
        } else {
            // If no application exists, create one with the status
            Yii::$app->db->createCommand("
                INSERT INTO job_applications (job_id, applicant_id, application_status, created_at, updated_at) 
                VALUES (:post_id, :tutor_id, :status, NOW(), NOW())
            ", [':post_id' => $postId, ':tutor_id' => $tutorId, ':status' => $status])->execute();
        }
    }
}
