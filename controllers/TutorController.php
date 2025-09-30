<?php

namespace app\controllers;

use app\components\Helper;
use app\models\ApplyCoin;
use app\models\Coins;
use app\models\JobApplications;
use app\models\Membership;
use Yii;
use app\models\Profiles;
use app\models\Referrals;
use app\models\StudentJobPosts;
use app\models\TeacherEducation;
use app\models\TeacherJobDescriptions;
use app\models\TeacherProfessionalExperience;
use app\models\TeacherSubjects;
use app\models\TeacherTeachingDetails;
use app\models\User;
use app\models\UserReferralCodes;
use app\models\UserVerifications;
use app\models\Wallets;
use app\models\WalletTransactions;
use Stripe\FinancialConnections\Transaction;
use yii\data\Pagination;
use yii\debug\models\search\Profile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\Response;

/**
 * ProfilesController handles CRUD actions for Profiles model.
 */
class TutorController extends Controller
{
    public function beforeAction($action)
    {

        $actionId = $action->id;
        $controllerId = $this->id;

        // PUBLIC ACTIONS
        $publicActions = ['index', 'contact', 'verify', 'about', 'login', 'signup', 'error', 'buy-membership','cancel-auto-renew'];

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

            if ($userRole != "tutor") {
                return $this->redirect(['site/switch-role', 'role' => 'tutor']);
            }


            // Define role-specific permissions
            $permissions = [
                'superadmin' => ['*'],
                'admin' => ['*'],
                'tutor' => [
                    'teacher-profile',
                    'subject-teach',
                    'education-experience',
                    'professional-experience',
                    'teaching-details',
                    'teacher-description',
                    'dashboard',
                    'recent-jobs',
                    'saved-jobs',
                    'save-job',
                    'unsave-job',
                    'applied-jobs',
                    'recentjobs',
                    'job-apply',
                    'apply-now',
                    'wallet',
                    'get-coins',
                    'payment-success',
                    'referrals',
                    'jobs',
                    'online-jobs',
                    'home-jobs',
                    'assigmnet-jobs',
                    'buy-membership',
                    'cancel-all-memberships',
                    'cancel-auto-renew',
                ],
                'student' => ['*'],
            ];
            //'view', 'create', 'update'

            // Check if user has permission
            if (!in_array($actionId, $permissions[$userRole]) && $permissions[$userRole] !== ['*']) {
                if (Yii::$app->request->isAjax) {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                    Yii::$app->response->data = ['success' => false, 'message' => 'You do not have permission to access this page.'];
                    return false;
                } else {
                    Yii::$app->session->setFlash('error', 'You do not have permission to access this page.');
                    Yii::$app->response->redirect(['/'])->send();
                    return false;
                }
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
        $user = User::find()->with(['profile'])->where(['id' => Yii::$app->user->identity->id]);

        return $this->render('index', [
            'user' => $user,
        ]);
    }

    private function checkAndCreateWallet($id)
    {
        // Check Wallet
        $wallet = Wallets::find()->where(['user_id' => $id])->one();
        if (!$wallet) {
            $depositCoins = 100;

            $wallet = new Wallets();
            $wallet->user_id = $id;
            $wallet->balance = $depositCoins;
            $wallet->currency = "Coins";
            $wallet->active = 1;
            $wallet->save();

            // TRANSACTION RECORD
            $transaction = new WalletTransactions();
            $transaction->wallet_id = $wallet->id;
            $transaction->transaction_type = "credit";
            $transaction->amount = $depositCoins;
            $transaction->description = "{$depositCoins} Coins deposit on account signup.";
            $transaction->status = "completed";
            $transaction->save();
        }
    }

    public function actionTeacherProfile()
    {
        // Check is profile details created
        $id = Yii::$app->user->identity->id;

        $model = Profiles::find()->where(['user_id' => $id])->one();
        // if ($model) {
        //     return $this->redirect(['/tutor/subjects']);
        // }
        if (!$model) {

            $model = new Profiles();
        }
        if (Yii::$app->request->isPost) {

            if ($model->load(Yii::$app->request->post())) {
                $model->user_id = $id;

                // // Handle image upload
                // $model->avatarFile = UploadedFile::getInstance($model, 'avatarFile');

                // // If an image is uploaded, save it and update the avatar_url
                // if ($model->avatarFile) {
                //     $avatarPath = $model->uploadAvatar();
                //     if ($avatarPath) {
                //         $model->avatar_url = $avatarPath;  // Save the path to avatar_url
                //     }
                // }

                //////////////////////////////



                // Get new uploaded file

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
                    return $this->redirect(['/tutor/subjects', 'id' => $model->id]);
                }
            }
        }
        $this->layout = "tutor_layout";
        return $this->render('create', [
            'model' => $model,
        ]);
    }


    // public function actionSubjectTeach()
    // {
    //     // Check is profile details created
    //     $id = Yii::$app->user->identity->id;

    //     $model = TeacherSubjects::find()->where(['teacher_id' => $id])->one();
    //     if (!$model) {

    //     $model = new TeacherSubjects();
    //     }

    //     if (Yii::$app->request->isPost) {

    //         $data = Yii::$app->request->post('TeacherSubjects');
    //         $subject = $data['subject'];
    //         $from_level = $data['from_level'];
    //         $to_level = $data['to_level'];

    //         if (count($subject) > 0) {

    //             for ($i = 0; $i < count($subject); $i++) {
    //                 $teacherSubject = new TeacherSubjects();
    //                 $teacherSubject->teacher_id = $id;
    //                 $teacherSubject->subject = $subject[$i];
    //                 $teacherSubject->from_level = $from_level[$i];
    //                 $teacherSubject->to_level = $to_level[$i];
    //                 $saved = $teacherSubject->save();
    //             }
    //             return $this->redirect(['education-experience', 'id' => $model->id]);
    //         }
    //     }
    //     $this->layout = "tutor_layout";
    //     return $this->render('teacher-subjects', [
    //         'model' => $model,
    //     ]);
    // }
    public function actionSubjectTeach()
    {
        $id = Yii::$app->user->identity->id;

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $subjects = $data['subject'] ?? [];
            $from_levels = $data['from_level'] ?? [];
            $to_levels = $data['to_level'] ?? [];

            // Remove old entries and insert fresh ones
            TeacherSubjects::deleteAll(['teacher_id' => $id]);



            foreach ($subjects as $i => $subj) {
                $ts = new TeacherSubjects();
                $ts->teacher_id = $id;
                $ts->subject = $subj;
                $ts->from_level = $from_levels[$i] ?? null;
                $ts->to_level = $to_levels[$i] ?? null;
                $ts->save(false);
            }

            return $this->redirect(['education-experience']);
        }

        $existingSubjects = TeacherSubjects::find()
            ->where(['teacher_id' => $id])
            ->all();

        $this->layout = "tutor_layout";
        return $this->render('teacher-subjects', [
            'existingSubjects' => $existingSubjects,
            'model' => new TeacherSubjects(),
            'subjects' => \yii\helpers\ArrayHelper::map(
                Helper::getGenericRecord('subject'),
                'title',
                'title'
            ),
        ]);
    }


    // public function actionEducationExperience()
    // {
    //     // Check is profile details created
    //     $id = Yii::$app->user->identity->id;

    //     $model = TeacherEducation::find()->where(['teacher_id' => $id])->all();
    //    if (!$model) {

    //     $model = new TeacherEducation();
    //     }

    //     if (Yii::$app->request->isPost) {

    //         $data = Yii::$app->request->post('TeacherEducation');
    //         $institute_name = $data['institute_name'];
    //         $degree_type = $data['degree_type'];
    //         $degree_name = $data['degree_name'];
    //         $start_date = $data['start_date'];
    //         $end_date = $data['end_date'];
    //         $association = $data['association'];
    //         $specialization = $data['specialization'];

    //         if (count($institute_name) > 0) {

    //             for ($i = 0; $i < count($institute_name); $i++) {
    //                 $teacherSubject = new TeacherEducation();
    //                 $teacherSubject->teacher_id = $id;
    //                 $teacherSubject->institute_name = $institute_name[$i];
    //                 $teacherSubject->degree_type = $degree_type[$i];
    //                 $teacherSubject->degree_name = $degree_name[$i];
    //                 $teacherSubject->start_date = $start_date[$i];
    //                 $teacherSubject->end_date = $end_date[$i];
    //                 $teacherSubject->association = $association[$i];
    //                 $teacherSubject->specialization = $specialization[$i];
    //                 $saved = $teacherSubject->save();
    //             }
    //             return $this->redirect(['/tutor/professional-experience']);
    //         }
    //     }
    //     $this->layout = "tutor_layout";
    //     return $this->render('education-experience', [
    //         'model' => $model,
    //     ]);
    // }

    public function actionEducationExperience()
    {
        $id = Yii::$app->user->identity->id;

        $model = new TeacherEducation();

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('TeacherEducation');

            $institute_name = $data['institute_name'] ?? [];
            $degree_type = $data['degree_type'] ?? [];
            $degree_name = $data['degree_name'] ?? [];
            $other_degree_name = $data['other_degree_name'] ?? [];
            $start_date = $data['start_date'] ?? [];
            $end_date = $data['end_date'] ?? [];
            $association = $data['association'] ?? [];
            $specialization = $data['specialization'] ?? [];

            // Delete previous entries
            TeacherEducation::deleteAll(['teacher_id' => $id]);

            for ($i = 0; $i < count($institute_name); $i++) {
                $edu = new TeacherEducation();
                $edu->teacher_id = $id;
                $edu->institute_name = $institute_name[$i];
                $edu->degree_type = $degree_type[$i];
                $edu->degree_name = $degree_name[$i];
                $edu->other_degree_name = $other_degree_name[$i];
                $edu->start_date = $start_date[$i];
                $edu->end_date = $end_date[$i];
                $edu->association = $association[$i];
                $edu->specialization = $specialization[$i];
                $edu->save(false);
            }
            if (!$model->validate()) {
                \Yii::error($model->errors, __METHOD__);
            }

            return $this->redirect(['/tutor/professional-experience']);
        }

        $existing = TeacherEducation::find()->where(['teacher_id' => $id])->all();
        $this->layout = "tutor_layout";

        return $this->render('education-experience', [
            'model' => $model,
            'educations' => !empty($existing) ? $existing : [new TeacherEducation()], // Always pass array of objects
        ]);
    }


    public function actionProfessionalExperience()
    {
        $id = Yii::$app->user->identity->id;
        $model = new TeacherProfessionalExperience();

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('TeacherProfessionalExperience');

            // JS fields (additional ones)
            $post = Yii::$app->request->post();

            $organization = $data['organization'] ?? [];
            $designation = $data['designation'] ?? [];
            $start_date = $data['start_date'] ?? [];
            $end_date = $data['end_date'] ?? [];
            $association = $data['association'] ?? [];
            $job_role = $data['job_role'] ?? [];

            // Handle JS-added additional entries
            $i = 0;
            while (isset($post["additional_organization_$i"])) {
                $organization[] = $post["additional_organization_$i"];
                $designation[] = $post["additional_designation_$i"];
                $start_date[] = $post["additional_start_date_$i"];
                $end_date[] = $post["additional_end_date_$i"];
                $association[] = $post["additional_association_$i"];
                $job_role[] = $post["additional_role_responsibility_$i"];
                $i++;
            }

            if (count($organization) > 0) {
                TeacherProfessionalExperience::deleteAll(['teacher_id' => $id]);

                for ($i = 0; $i < count($organization); $i++) {
                    $teacherSubject = new TeacherProfessionalExperience();
                    $teacherSubject->teacher_id = $id;
                    $teacherSubject->organization = $organization[$i];
                    $teacherSubject->designation = $designation[$i];
                    $teacherSubject->start_date = $start_date[$i];
                    $teacherSubject->end_date = $end_date[$i];
                    $teacherSubject->association = $association[$i];
                    $teacherSubject->job_role = $job_role[$i];
                    $teacherSubject->save();
                }
                if (!$model->validate()) {
                    \Yii::error($model->errors, __METHOD__);
                }

                return $this->redirect(['/tutor/teaching-details']);
            }
        }

        $existing_prof_exp = TeacherProfessionalExperience::find()->where(['teacher_id' => $id])->all();
        $this->layout = "tutor_layout";
        return $this->render('professional-experience', [
            'model' => $model,
            'existing_prof_exp' => $existing_prof_exp,
        ]);
    }


    // public function actionProfessionalExperience()
    // {
    //     // Check is profile details created
    //     $id = Yii::$app->user->identity->id;

    //     $model = TeacherProfessionalExperience::find()->where(['teacher_id' => $id])->one();
    //     if (!$model) {

    //     $model = new TeacherProfessionalExperience();
    //     }

    //     if (Yii::$app->request->isPost) {

    //         $data = Yii::$app->request->post('TeacherProfessionalExperience');
    //         $organization = $data['organization'];
    //         $designation = $data['designation'];
    //         $start_date = $data['start_date'];
    //         $end_date = $data['end_date'];
    //         $association = $data['association'];
    //         $job_role = $data['job_role'];

    //         if (count($organization) > 0) {

    //             for ($i = 0; $i < count($organization); $i++) {
    //                 $teacherSubject = new TeacherProfessionalExperience();
    //                 $teacherSubject->teacher_id = $id;
    //                 $teacherSubject->organization = $organization[$i];
    //                 $teacherSubject->designation = $designation[$i];
    //                 $teacherSubject->start_date = $start_date[$i];
    //                 $teacherSubject->end_date = $end_date[$i];
    //                 $teacherSubject->association = $association[$i];
    //                 $teacherSubject->job_role = $job_role[$i];
    //                 $saved = $teacherSubject->save();
    //             }
    //             return $this->redirect(['/tutor/teaching-details']);
    //         }
    //     }
    //     $this->layout = "tutor_layout";
    //     return $this->render('professional-experience', [
    //         'model' => $model,
    //     ]);
    // }

    // public function actionTeachingDetails()
    // {
    //     // Check is profile details created
    //     $id = Yii::$app->user->identity->id;

    //     $model = TeacherTeachingDetails::find()->where(['teacher_id' => $id])->one();
    //     if (!$model) {

    //         $model = new TeacherTeachingDetails();
    //     }


    //     if ($model->load(Yii::$app->request->post())) {
    //         $model->teacher_id = $id;

    //         if ($model->save()) {
    //             Yii::$app->session->setFlash('success', 'Profile updated successfully');
    //             return $this->redirect(['/tutor/description']);
    //         }
    //     }
    //     $this->layout = "tutor_layout";
    //     return $this->render('teaching-details', [
    //         'model' => $model,
    //     ]);
    // }
    public function actionTeachingDetails()
    {
        $id = Yii::$app->user->identity->id;

        $model = TeacherTeachingDetails::find()->where(['teacher_id' => $id])->one();
        if (!$model) {
            $model = new TeacherTeachingDetails();
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->teacher_id = $id;

            // Handle communication_language (convert array → string)
            if (is_array($model->communication_language)) {
                $model->communication_language = implode(',', $model->communication_language);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Profile updated successfully');
                return $this->redirect(['/tutor/description']);
            }
            if (!$model->validate()) {
                \Yii::error($model->errors, __METHOD__);
            }
        } else {
            // Handle communication_language (convert string → array for form)
            if (!empty($model->communication_language)) {
                $model->communication_language = explode(',', $model->communication_language);
            }
        }

        $this->layout = "tutor_layout";
        return $this->render('teaching-details', [
            'model' => $model,
        ]);
    }

    public function actionTeacherDescription()
    {
        // Check is profile details created
        $id = Yii::$app->user->identity->id;

        $model = TeacherJobDescriptions::find()->where(['teacher_id' => $id])->one();
        if (!$model) {

            $model = new TeacherJobDescriptions();
        }


        if ($model->load(Yii::$app->request->post())) {
            $model->teacher_id = $id;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Profile updated successfully');
                return $this->redirect(['/tutor/dashboard']);
            }
            if (!$model->validate()) {
                \Yii::error($model->errors, __METHOD__);
            }
        }
        $this->layout = "tutor_layout";
        return $this->render('teacher-description', [
            'model' => $model,
        ]);
    }

    public function actionDashboard()
    {
        $this->layout = "tutor_layout";
        $id = Yii::$app->user->identity->id;
        $user = User::findOne($id);

        // Check and create wallet
        $this->checkAndCreateWallet($id);


        // $tutorSubjects = TeacherSubjects::find()
        //     ->select('subject')
        //     ->where(['teacher_id' => $id])
        //     ->asArray()
        //     ->column();

        // // Find jobs where the subject matches any of the tutor's subjects
        // $matched_posts = StudentJobPosts::find()
        //     ->where(['in', 'subject', $tutorSubjects])
        //     //->asArray()
        //     ->all();


        // Get tutor's subjects
        $tutorSubjects = TeacherSubjects::find()
            ->select('subject')
            ->where(['teacher_id' => $id])
            ->asArray()
            ->column();

        // Create paginated data provider for matched posts
        $dataProvider = new ActiveDataProvider([
            'query' => StudentJobPosts::find()
                ->where(['in', 'subject', $tutorSubjects])
                ->andWhere(['post_status' => 'active'])
                ->andWhere(['!=', 'posted_by', $id]) // exclude current user's posts
                ->orderBy(['id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);


        return $this->render('dashboard', [
            'user' => $user,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionJobs()
    {
        $this->layout = "tutor_layout";
        $id = Yii::$app->user->identity->id;
        $user = User::findOne($id);

        $this->checkAndCreateWallet($id);




        // Get tutor's subjects
        $tutorSubjects = TeacherSubjects::find()
            ->select('subject')
            ->where(['teacher_id' => $id])
            ->asArray()
            ->column();

        // Create paginated data provider for matched posts
        $dataProvider = new ActiveDataProvider([
            'query' => StudentJobPosts::find()
                ->where(['in', 'subject', $tutorSubjects])
                ->orderBy(['id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('jobs', [
            'user' => $user,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRecentJobs()
    {
        // prepare $recent_posts
        $this->layout = "tutor_layout";
        $id = Yii::$app->user->identity->id;
        $user = User::findOne($id);

        // Check and create wallet
        $this->checkAndCreateWallet($id);

        // Create data provider with pagination
        $dataProvider = new ActiveDataProvider([
            'query' => StudentJobPosts::find()->where(['post_status' => 'active'])->orderBy(['id' => SORT_DESC]), // Correct usage
            'pagination' => [
                'pageSize' => 10, // Change page size as needed
            ],
        ]);

        // Post Matches
        //  $recent_posts = StudentJobPosts::find()->all();



        return $this->render('jobs', [
            'user' => $user,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSavedJobs()
    {
        $this->layout = "tutor_layout";
        $id = Yii::$app->user->identity->id;
        $user = User::findOne($id);
        $this->checkAndCreateWallet($id);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => StudentJobPosts::find()
                ->innerJoin('saved_jobs', 'saved_jobs.job_id = student_job_posts.id')
                ->where(['saved_jobs.tutor_id' => $id])
                ->orderBy(['student_job_posts.id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('jobs', [
            'user' => $user,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAppliedJobs()
    {
        $this->layout = "tutor_layout";
        $id = Yii::$app->user->identity->id;
        $user = User::findOne($id);
        $this->checkAndCreateWallet($id);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => StudentJobPosts::find()
                ->innerJoin('job_applications', 'job_applications.job_id = student_job_posts.id')
                ->where(['job_applications.applicant_id' => $id])
                ->orderBy(['student_job_posts.id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('jobs', [
            'user' => $user,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionOnlineJobs()
    {
        // prepare $recent_posts
        $this->layout = "tutor_layout";
        $id = Yii::$app->user->identity->id;
        $user = User::findOne($id);

        // Check and create wallet
        $this->checkAndCreateWallet($id);

        // Create data provider with pagination
        $dataProvider = new ActiveDataProvider([
            'query' => StudentJobPosts::find()->where(['want' => 'online'])->andWhere(['post_status' => 'active'])->orderBy(['id' => SORT_DESC]), // Correct usage
            'pagination' => [
                'pageSize' => 10, // Change page size as needed
            ],
        ]);

        // Post Matches
        //  $recent_posts = StudentJobPosts::find()->all();



        return $this->render('dashboard', [
            'user' => $user,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionHomeJobs()
    {
        // prepare $recent_posts
        $this->layout = "tutor_layout";
        $id = Yii::$app->user->identity->id;
        $user = User::findOne($id);

        // Check and create wallet
        $this->checkAndCreateWallet($id);

        // Create data provider with pagination
        $dataProvider = new ActiveDataProvider([
            'query' => StudentJobPosts::find()->where(['want' => 'home'])->andWhere(['post_status' => 'active'])->orderBy(['id' => SORT_DESC]), // Correct usage
            'pagination' => [
                'pageSize' => 10, // Change page size as needed
            ],
        ]);

        // Post Matches
        //  $recent_posts = StudentJobPosts::find()->all();



        return $this->render('dashboard', [
            'user' => $user,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAssigmnetJobs()
    {
        // prepare $recent_posts
        $this->layout = "tutor_layout";
        $id = Yii::$app->user->identity->id;
        $user = User::findOne($id);

        // Check and create wallet
        $this->checkAndCreateWallet($id);

        // Create data provider with pagination
        $dataProvider = new ActiveDataProvider([
            'query' => StudentJobPosts::find()->where(['want' => 'assigment'])->andWhere(['post_status' => 'active'])->orderBy(['id' => SORT_DESC]), // Correct usage
            'pagination' => [
                'pageSize' => 10, // Change page size as needed
            ],
        ]);

        // Post Matches
        //  $recent_posts = StudentJobPosts::find()->all();



        return $this->render('dashboard', [
            'user' => $user,
            'dataProvider' => $dataProvider,
        ]);
    }






    // public function actionJobApply()
    // {

    //     $user = Yii::$app->user->identity;
    //     $userRole = $user->role;
    //     if (!$user->profile && $userRole = 'tutor') {
    //         Yii::$app->session->setFlash('error', 'Please complete your profile before applying for Jobs.');
    //         return $this->redirect(['/tutor/profile'])->send();
    //     }
    //     $this->layout = "tutor_layout";
    //     $id = Yii::$app->user->identity->id;
    //     $user = User::findOne($id);
    //     $job_id = Yii::$app->request->get("id");



    //     // Post Matches
    //     $post = StudentJobPosts::find()->with(['applies'])->where(['id' => $job_id])->one();
    //     $applied = JobApplications::find()->where(['job_id' => $job_id, 'applicant_id' => $id])->one();
    //     $coins = Wallets::find()->where(['user_id' => $id])->one();


    //     // Example usage:
    //     $location = $post->location; // e.g. "Islamabad, Pakistan"
    //     $apply_coin = new ApplyCoin();
    //     $result = $apply_coin->getContinentFromLocation($location);

    //     // Build query
    //     $query = ApplyCoin::find();

    //     if (!empty($result['continent'])) {
    //         $query->where(['like', 'country', $result['continent']]);
    //     }

    //     // Always include default as fallback
    //     $query->orWhere(['country' => 'default']);

    //     $regions = $query->orderBy(['country' => SORT_DESC])->one();

    //     // Safe fallback if still nothing found
    //     $coinValue = $regions ? $regions->coin_value : 0;
    //     $mem_apply_coin = $regions ? $regions->member_coin_value : 0; 



    //     if(!empty($result['continent'])){
    //     $job_region=$result['continent'];
    //     }else
    //     {
    //         $job_region='default';
    //     }   


    //     // ----------------- Usage -----------------






    //     return $this->render('job-apply', [
    //         'user' => $user,
    //         'post' => $post,
    //         'applied' => $applied,
    //         'coins' => $coins,
    //         'ApplyCoin' => $coinValue,
    //         'member_applycoins'=>$mem_apply_coin,
    //         'region'=>$job_region
    //     ]);
    // }

    public function actionJobApply()
{
    $user = Yii::$app->user->identity;
    $userRole = $user->role;
    if (!$user->profile && $userRole == 'tutor') {
        Yii::$app->session->setFlash('error', 'Please complete your profile before applying for Jobs.');
        return $this->redirect(['/tutor/profile'])->send();
    }
    $this->layout = "tutor_layout";
    $id = Yii::$app->user->identity->id;
    $user = User::findOne($id);
    $job_id = Yii::$app->request->get("id");

    // Post Matches
    $post = StudentJobPosts::find()->with(['applies'])->where(['id' => $job_id])->one();
    $applied = JobApplications::find()->where(['job_id' => $job_id, 'applicant_id' => $id])->one();
    $coins = Wallets::find()->where(['user_id' => $id])->one();

    // Example usage:
    $location = $post->location; // e.g. "Islamabad, Pakistan"
    $apply_coin = new ApplyCoin();
    $result = $apply_coin->getContinentFromLocation($location);

    // Build query
    $query = ApplyCoin::find();

    if (!empty($result['continent'])) {
        $query->where(['like', 'country', $result['continent']]);
    }

    // Always include default as fallback
    $query->orWhere(['country' => 'default']);

    $regions = $query->orderBy(['country' => SORT_DESC])->one();

    // Safe fallback if still nothing found
    $coinValue = $regions ? $regions->coin_value : 0;
    $mem_apply_coin = $regions ? $regions->member_coin_value : 0; 

    if(!empty($result['continent'])){
        $job_region=$result['continent'];
    }else
    {
        $job_region='default';
    }   

    // Compute membership values using Membership model
    $totalActiveCoins = Membership::getTotalActiveCoins($id);
    $isMember = Membership::hasActiveMembership($id);
    $purchases = Membership::getUserMemberships($id);
    $hasExpired = !$isMember && Membership::find()->where(['<', 'memb_expiry', date('Y-m-d H:i:s')])->exists();
    $expiredExpiry = $hasExpired ? Membership::find()->where(['user_id' => $id])->max('memb_expiry') : null;

    // ----------------- Usage -----------------

    return $this->render('job-apply', [
        'user' => $user,
        'post' => $post,
        'applied' => $applied,
        'coins' => $coins,
        'ApplyCoin' => $coinValue,
        'member_applycoins' => $mem_apply_coin,
        'region' => $job_region,
        'totalActiveCoins' => $totalActiveCoins,
        'isMember' => $isMember,
        'purchases' => $purchases,
        'hasExpired' => $hasExpired,
        'expiredExpiry' => $expiredExpiry,
    ]);
}




// public function actionApplyNow()
// {
//     $id = Yii::$app->user->identity->id;
//     $redirectUrl = Yii::$app->request->get("url"); 
//     $job_id = Yii::$app->request->get("id");

//     $applyMethod = ($redirectUrl == 'call') ? 'call' : 'message';

//     // ✅ Recalculate coins on server-side
//     $post = StudentJobPosts::find()->with(['applies'])->where(['id' => $job_id])->one();
//     if ($post) {
        
//         $location = $post->location;
//         $apply_coin = new ApplyCoin();
//         $result = $apply_coin->getContinentFromLocation($location);

//         $query = ApplyCoin::find();
//         if (!empty($result['continent'])) {
//             $query->where(['like', 'country', $result['continent']]);
//         }
//         $query->orWhere(['country' => 'default']);

//         $regions = $query->orderBy(['country' => SORT_DESC])->one();
//         $baseApplyCoin = $regions ? $regions->coin_value : 0;

//         $maxMembershipCoin = $regions ? $regions->member_coin_value : 0; // Assuming this is accessible, e.g., from config or property

//         $jobPostedTime = strtotime($post->created_at);
//         $currentTime = time();
//         $timeSincePosted = $currentTime - $jobPostedTime;
//         $minutesSincePosted = floor($timeSincePosted / 60);

//         $isEarly = $minutesSincePosted < 90;
//         $dynamic_cost = $isEarly ? round($maxMembershipCoin * (1 - $minutesSincePosted / 90.0)) : 0;

//         $user = User::findOne($id); // Assuming User model
//         $isMember = !empty($user->membership);
//         $user_wallet = $user->wallet;
//         $membershipCoins = $user_wallet ? $user_wallet->membership_coins : 0;

//         $apply_coins = $isEarly ? max($baseApplyCoin, max(0, $dynamic_cost - $membershipCoins)) : $baseApplyCoin;

//         $direct_msg = false; // Job found, not a direct message

//         $transaction_description = "Paid for a $applyMethod during job apply";

//     } else {
        
//         $query = ApplyCoin::find();
        
//         $query->Where(['country' => 'default']);

//         $regions = $query->orderBy(['country' => SORT_DESC])->one();
//         $apply_coins = $regions ? $regions->coin_value : 0;

//         $direct_msg = true; // Job not found, assume direct message

//         $transaction_description = "Paid for a view or contact during direct message";

//     }

//     // ✅ Now coins cannot be faked from frontend
//     $application = JobApplications::find()
//         ->where(['job_id' => $job_id, 'applicant_id' => $id])
//         ->one();

//     $userWallet = Wallets::find()->where(['user_id' => $id])->one();

//     if ($userWallet && $userWallet->balance >= $apply_coins) {
//         if (!$application ) {
//             // First time applying
//             $userWallet->balance -= $apply_coins;
//             $userWallet->save();

//             $transaction = new WalletTransactions();
//             $transaction->wallet_id = $userWallet->id;
//             $transaction->transaction_type = "debit";
//             $transaction->amount = $apply_coins;
//             $transaction->description =  $transaction_description;
//             $transaction->status = "completed";
//             $transaction->save();

//             $application = new JobApplications();
//             $application->job_id = $job_id;
//             $application->applicant_id = $id;
//             $application->$applyMethod = 1;
//             $application->save();
//             if ($direct_msg) {

            
            
//             Yii::$app->session->setFlash('success', 'Can View/Sent Messages Now');
//         } else{
//             Yii::$app->session->setFlash('success', 'Successfully Applied For Job.');

//         }

//         }else {
//             // Already applied, maybe for the other method
//             if ($application->$applyMethod != 1) {
//                 $userWallet->balance -= $apply_coins;
//                 $userWallet->save();

//                 $transaction = new WalletTransactions();
//                 $transaction->wallet_id = $userWallet->id;
//                 $transaction->transaction_type = "debit";
//                 $transaction->amount = $apply_coins;
//                 $transaction->description = "Paid for a $applyMethod during job apply";
//                 $transaction->status = "completed";
//                 $transaction->save();

//                 $application->$applyMethod = 1;
//                 $application->save();
//             }
//         }

    

//         if ($applyMethod === 'call') {
//             $whatsappNumber = $this->formatWhatsappNumber($post->phone_number);
//             return $this->redirect("https://wa.me/{$whatsappNumber}?text=" . urlencode("Hello, I am interested in your job post titled '{$post->title}'"));
//         } else {
//             Yii::$app->response->redirect($redirectUrl)->send();
//         }
//     } else {
//         Yii::$app->session->setFlash('error', 'Insufficient balance in wallet to apply for this job.');
//         return $this->redirect(['/tutor/wallet']);
//     }
// }

// public function actionApplyNow()
// {
//     $id = Yii::$app->user->identity->id;
//     $redirectUrl = Yii::$app->request->get("url"); 
//     $job_id = Yii::$app->request->get("id");

//     $applyMethod = ($redirectUrl == 'call') ? 'call' : 'message';

//     // ✅ Recalculate coins on server-side
//     $post = StudentJobPosts::find()->with(['applies'])->where(['id' => $job_id])->one();
//     if ($post) {
        
//         $location = $post->location;
//         $apply_coin = new ApplyCoin();
//         $result = $apply_coin->getContinentFromLocation($location);

//         $query = ApplyCoin::find();
//         if (!empty($result['continent'])) {
//             $query->where(['like', 'country', $result['continent']]);
//         }
//         $query->orWhere(['country' => 'default']);

//         $regions = $query->orderBy(['country' => SORT_DESC])->one();
//         $baseApplyCoin = $regions ? $regions->coin_value : 0;

//         $maxMembershipCoin = $regions ? $regions->member_coin_value : 0; // Assuming this is accessible, e.g., from config or property

//         $jobPostedTime = strtotime($post->created_at);
//         $currentTime = time();
//         $timeSincePosted = $currentTime - $jobPostedTime;
//         $minutesSincePosted = floor($timeSincePosted / 60);

//         $isEarly = $minutesSincePosted < 90;
//         $dynamic_cost = $isEarly ? round($maxMembershipCoin * (1 - $minutesSincePosted / 90.0)) : 0;

//         $user = User::findOne($id); // Assuming User model
//         $user_wallet = $user->wallet;
//         $isMember = !empty($user_wallet->memb_expiry) && strtotime($user_wallet->memb_expiry) > $currentTime;

//         $membershipCoins = $isMember ? ($user_wallet ? $user_wallet->membership_coins : 0) : 0;

//         $apply_coins = $isEarly ? max($baseApplyCoin, max(0, $dynamic_cost - $membershipCoins)) : $baseApplyCoin;

//         $direct_msg = false; // Job found, not a direct message

//         $transaction_description = "Paid for a $applyMethod during job apply";

//     } else {
        
//         $query = ApplyCoin::find();
        
//         $query->Where(['country' => 'default']);

//         $regions = $query->orderBy(['country' => SORT_DESC])->one();
//         $apply_coins = $regions ? $regions->coin_value : 0;

//         $direct_msg = true; // Job not found, assume direct message

//         $transaction_description = "Paid for a view or contact during direct message";

//     }

//     // ✅ Now coins cannot be faked from frontend
//     $application = JobApplications::find()
//         ->where(['job_id' => $job_id, 'applicant_id' => $id])
//         ->one();

//     $userWallet = Wallets::find()->where(['user_id' => $id])->one();

//     if ($userWallet && $userWallet->balance >= $apply_coins) {
//         if (!$application ) {
//             // First time applying
//             $userWallet->balance -= $apply_coins;
//             $userWallet->save();

//             $transaction = new WalletTransactions();
//             $transaction->wallet_id = $userWallet->id;
//             $transaction->transaction_type = "debit";
//             $transaction->amount = $apply_coins;
//             $transaction->description =  $transaction_description;
//             $transaction->status = "completed";
//             $transaction->save();

//             $application = new JobApplications();
//             $application->job_id = $job_id;
//             $application->applicant_id = $id;
//             $application->$applyMethod = 1;
//             $application->save();
//             if ($direct_msg) {

            
            
//             Yii::$app->session->setFlash('success', 'Can View/Sent Messages Now');
//         } else{
//             Yii::$app->session->setFlash('success', 'Successfully Applied For Job.');

//         }

//         }else {
//             // Already applied, maybe for the other method
//             if ($application->$applyMethod != 1) {
//                 $userWallet->balance -= $apply_coins;
//                 $userWallet->save();

//                 $transaction = new WalletTransactions();
//                 $transaction->wallet_id = $userWallet->id;
//                 $transaction->transaction_type = "debit";
//                 $transaction->amount = $apply_coins;
//                 $transaction->description = "Paid for a $applyMethod during job apply";
//                 $transaction->status = "completed";
//                 $transaction->save();

//                 $application->$applyMethod = 1;
//                 $application->save();
//             }
//         }

    

//         if ($applyMethod === 'call') {
//             $whatsappNumber = $this->formatWhatsappNumber($post->phone_number);
//             return $this->redirect("https://wa.me/{$whatsappNumber}?text=" . urlencode("Hello, I am interested in your job post titled '{$post->title}'"));
//         } else {
//             Yii::$app->response->redirect($redirectUrl)->send();
//         }
//     } else {
//         Yii::$app->session->setFlash('error', 'Insufficient balance in wallet to apply for this job.');
//         return $this->redirect(['/tutor/wallet']);
//     }
// }

    public function actionApplyNow()
    {
    $id = Yii::$app->user->identity->id;
    $redirectUrl = Yii::$app->request->get("url"); 
    $job_id = Yii::$app->request->get("id");

    $applyMethod = ($redirectUrl == 'call') ? 'call' : 'message';

    // ✅ Recalculate coins on server-side
    $post = StudentJobPosts::find()->with(['applies'])->where(['id' => $job_id])->one();
    if ($post) {
        
        $location = $post->location;
        $apply_coin = new ApplyCoin();
        $result = $apply_coin->getContinentFromLocation($location);

        $query = ApplyCoin::find();
        if (!empty($result['continent'])) {
            $query->where(['like', 'country', $result['continent']]);
        }
        $query->orWhere(['country' => 'default']);

        $regions = $query->orderBy(['country' => SORT_DESC])->one();
        $baseApplyCoin = $regions ? $regions->coin_value : 0;

        $maxMembershipCoin = $regions ? $regions->member_coin_value : 0; // Assuming this is accessible, e.g., from config or property

        $jobPostedTime = strtotime($post->created_at);
        $currentTime = time();
        $timeSincePosted = $currentTime - $jobPostedTime;
        $minutesSincePosted = floor($timeSincePosted / 60);

        $isEarly = $minutesSincePosted < 90;
        $dynamic_cost = $isEarly ? round($maxMembershipCoin * (1 - $minutesSincePosted / 90.0)) : 0;

        $user = User::findOne($id); // Assuming User model
        $membershipCoins = Membership::getTotalActiveCoins($id);
        $isMember = Membership::hasActiveMembership($id);

        $apply_coins = $isEarly ? max($baseApplyCoin, max(0, $dynamic_cost - $membershipCoins)) : $baseApplyCoin;

        $direct_msg = false; // Job found, not a direct message

        $transaction_description = "Paid for a $applyMethod during job apply";

    } else {
        
        $query = ApplyCoin::find();
        
        $query->Where(['country' => 'default']);

        $regions = $query->orderBy(['country' => SORT_DESC])->one();
        $apply_coins = $regions ? $regions->coin_value : 0;

        $direct_msg = true; // Job not found, assume direct message

        $transaction_description = "Paid for a view or contact during direct message";

    }

    // ✅ Now coins cannot be faked from frontend
    $application = JobApplications::find()
        ->where(['job_id' => $job_id, 'applicant_id' => $id])
        ->one();

    $userWallet = Wallets::find()->where(['user_id' => $id])->one();

    if ($userWallet && $userWallet->balance >= $apply_coins) {
        if (!$application ) {
            // First time applying
            $userWallet->balance -= $apply_coins;
            $userWallet->save();

            $transaction = new WalletTransactions();
            $transaction->wallet_id = $userWallet->id;
            $transaction->transaction_type = "debit";
            $transaction->amount = $apply_coins;
            $transaction->description =  $transaction_description;
            $transaction->status = "completed";
            $transaction->save();

            $application = new JobApplications();
            $application->job_id = $job_id;
            $application->applicant_id = $id;
            $application->$applyMethod = 1;
            $application->save();
            if ($direct_msg) {

            
            
            Yii::$app->session->setFlash('success', 'Can View/Sent Messages Now');
        } else{
            Yii::$app->session->setFlash('success', 'Successfully Applied For Job.');

        }

        }else {
            // Already applied, maybe for the other method
            if ($application->$applyMethod != 1) {
                $userWallet->balance -= $apply_coins;
                $userWallet->save();

                $transaction = new WalletTransactions();
                $transaction->wallet_id = $userWallet->id;
                $transaction->transaction_type = "debit";
                $transaction->amount = $apply_coins;
                $transaction->description = "Paid for a $applyMethod during job apply";
                $transaction->status = "completed";
                $transaction->save();

                $application->$applyMethod = 1;
                $application->save();
            }
        }

    

        if ($applyMethod === 'call') {
            $whatsappNumber = $this->formatWhatsappNumber($post->phone_number);
            return $this->redirect("https://wa.me/{$whatsappNumber}?text=" . urlencode("Hello, I am interested in your job post titled '{$post->title}'"));
        } else {
            Yii::$app->response->redirect($redirectUrl)->send();
        }
    } else {
        Yii::$app->session->setFlash('error', 'Insufficient balance in wallet to apply for this job.');
        return $this->redirect(['/tutor/wallet']);
    }
    }



    public function actionSaveJob()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->user->isGuest) {
            return ['success' => false, 'message' => 'Not logged in'];
        }
        $tutor_id = Yii::$app->user->id;
        $job_id = Yii::$app->request->post('job_id');
        if (!$job_id) {
            return ['success' => false, 'message' => 'No job ID'];
        }
        $model = new \app\models\SavedJobs();
        $model->tutor_id = $tutor_id;
        $model->job_id = $job_id;
        if ($model->save()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Could not save', 'errors' => $model->getErrors()];
        }
    }

    public function actionUnsaveJob()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->user->isGuest) {
            return ['success' => false, 'message' => 'Not logged in'];
        }
        $tutor_id = Yii::$app->user->id;
        $job_id = Yii::$app->request->post('job_id');
        if (!$job_id) {
            return ['success' => false, 'message' => 'No job ID'];
        }
        $model = \app\models\SavedJobs::findOne(['tutor_id' => $tutor_id, 'job_id' => $job_id]);
        if ($model && $model->delete()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'Could not unsave'];
        }
    }


    private function formatWhatsappNumber($rawNumber, $defaultCountryCode = '92')
    {
        // Remove spaces, dashes, parentheses
        $number = preg_replace('/[\s\-\(\)]/', '', $rawNumber);
        // If number starts with +, remove it
        if (strpos($number, '+') === 0) {
            $number = substr($number, 1);
        }
        // If number starts with 00, remove it
        if (strpos($number, '00') === 0) {
            $number = substr($number, 2);
        }
        // If number now starts with a country code (1-4 digits, not starting with 0), use as is
        if (preg_match('/^[1-9][0-9]{7,14}$/', $number)) {
            return $number;
        }
        // If number starts with 0, remove it and prepend default country code
        if (strpos($number, '0') === 0) {
            $number = substr($number, 1);
        }
        // Prepend default country code
        return $defaultCountryCode . $number;
    }



    // public function actionWallet()
    // {
    //     $this->layout = "tutor_layout";
    //     $id = Yii::$app->user->identity->id;

    //     // Post Matches
    //     $user = User::find()->with(['wallet'])->where(['id' => $id])->one();

    //     $wallet = Wallets::find()->with(['transactions'])->where(['user_id' => $id])->one();

    //     return $this->render('wallet', [
    //         'user' => $user,
    //         'wallet' => $wallet,
    //         'coins' => Coins::find()->all(),
    //     ]);
    // }
    public function actionWallet()
    {
        $this->layout = "tutor_layout";
        $id = Yii::$app->user->identity->id;

        // Post Matches
        $user = User::find()->with(['wallet'])->where(['id' => $id])->one();

        $wallet = Wallets::find()->with(['transactions'])->where(['user_id' => $id])->one();

        $query = WalletTransactions::find()->where(['wallet_id' => $wallet->id])->orderBy(['created_at' => SORT_DESC]);


        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 10
        ]);

        $transactions = $query->offset($pagination->offset)->limit($pagination->limit)->all();


        //var_dump($transactions);die;
        return $this->render('wallet', [
            'user' => $user,
            'wallet' => $wallet,
            'transactions' => $transactions,
            'coins' => Coins::find()->all(),
            'pagination' => $pagination
        ]);
    }
    public function actionGetCoins()
    {
        $this->layout = "tutor_layout";
        $id = Yii::$app->user->identity->id;
        // Post Matches
        $user = User::find()->with(['wallet'])->where(['id' => $id])->one();
        $coins = Coins::find()->all();

        if (Yii::$app->request->isPost) {
            $coinId = Yii::$app->request->post('coin');
            $coin = Coins::findOne($coinId);



            ///Recharge If admin wallet has low coin//

            $coin_price = $coin->coin_price;
            $adminWallet = Wallets::find()->where(['user_type' => 'superadmin'])->one();
            if ($adminWallet->balance < $coin_price) {

                $deposit = Helper::getdefaultrecharge();
                $desciption = 'Coins Auto Recharged.';
                Helper::admin_recharge($deposit, $desciption);
            }
            ///end Recharge //



            Yii::$app->session->set('coin', $coin);
            Yii::$app->response->redirect(['/payment/stripe-payment'])->send();
        }

        return $this->render('coins', ['coins' => $coins, 'user' => $user]);
    }

    public function actionPaymentSuccess()
    {
        $paymentId = Yii::$app->session->get('id');
        $id = Yii::$app->request->get('id');
        $userId = Yii::$app->user->identity->id;
        if ($id == $paymentId) {
            $coin = Yii::$app->session->get('coin');
            Yii::$app->session->remove('coin');
            $depositCoins = $coin['coin_count'];
            $wallet = Wallets::find()->where(['user_id' => $userId])->one();
            $wallet->balance += $depositCoins;
            $wallet->save();
            // TRANSACTION RECORD
            $transaction = new WalletTransactions();
            $transaction->wallet_id = $wallet->id;
            $transaction->transaction_type = "credit";
            $transaction->amount = $depositCoins;
            $transaction->description = "{$depositCoins} Coins purchased.";
            $transaction->status = "completed";
            $transaction->save();

            $tutor_name = User::getusername($wallet->user_id);

            $adminWallet = Wallets::find()->where(['user_type' => 'superadmin'])->one();
            $adminWallet->balance -= $depositCoins;
            $adminWallet->save();

            $transaction = new WalletTransactions();
            $transaction->wallet_id = $adminWallet->id;
            $transaction->transaction_type = "debit";
            $transaction->amount = $depositCoins;
            $transaction->description = "{$depositCoins} Coins purchased By Tutor {$tutor_name}.";
            $transaction->status = "completed";
            $transaction->save();
        }
        Yii::$app->session->setFlash('success', 'Coin Purchased Successfully.');
        Yii::$app->response->redirect(['/tutor/wallet'])->send();
    }

    public function actionReferrals()
    {
        $id = Yii::$app->user->identity->id;
        $user = User::findOne($id);


        $code = UserReferralCodes::find()->where(['user_id' => $id])->one();
        if (!$code) {
            $referralCode = Helper::generateReferralCode(Yii::$app->user->identity->username, $id);

            $code = new UserReferralCodes();
            $code->user_id = $id;
            $code->referral_code = $referralCode;
            $code->save();
        }

        // FIND Referrals
        $query = Referrals::find()->with(['user'])->where(['referrer_id' => $id]);

        // Create Pagination object
        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 10,
        ]);

        $referrals = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('referrals', [
            'referrals' => $referrals,
            'code' => $code,
            'pagination' => $pagination
        ]);
    }

    public function actionUpdate()
    {
        $id = Yii::$app->user->identity->id;
        $model = Profiles::find()->where(['user_id' => $id])->one();
        if (!$model) {
            return $this->redirect(['create']);
        }

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





    // public function actionBuyMembership()
    // {
    //     $userId = Yii::$app->user->identity->id;
    //     $wallet = Wallets::find()->where(['user_id' => $userId])->one();

    //     $user = User::find()->where(['id' => $userId])->one();

    //     $offers = ApplyCoin::find()->orderBy(['member_coin_value' => SORT_DESC])
    //     ->asArray()
    //     ->all();
    //     //getMembershipOffers();
    //    // print_r($offers); die;
        

    //     if (Yii::$app->request->isPost) {
    //        // $offerId = Yii::$app->request->post('offer_id');
    //         // Example offers array (should be fetched from DB/config in real app)      
    //           // $offer_price = ApplyCoin::findOne($offerId)->member_coin_value;
    //        $offer_price = Yii::$app->request->post('custom_coins');

    //         $currentTime = time();

    //         if (strtotime($wallet->memb_expiry) < $currentTime) {
    //             // Expired → reset coins
    //             $wallet->membership_coins = 0;
    //         }

               
               
    //         if ( $wallet->balance >= $offer_price) {

             
    //         $price = $offer_price;
    //         $wallet->membership_coins += $price;
    //         $wallet->memb_expiry = date("Y-m-d H:i:s", strtotime("+1 month"));
    //         $wallet->balance -= $price;
    //         $wallet->save();

    //         $user->membership='yes';
    //         $user->save();


    //         $transaction = new WalletTransactions();
    //         $transaction->wallet_id = $wallet->id;
    //         $transaction->transaction_type = "debit";
    //         $transaction->amount = $price;
    //         $transaction->description = "{$price} membership coins purchased.";
    //         $transaction->status = "completed";
    //         $transaction->save();


    //             Yii::$app->session->setFlash('success', 'Membership purchased successfully!');

    //             return $this->redirect(['buy-membership']);


    //         }elseif($wallet->balance < $offer_price){



    //             Yii::$app->session->setFlash('error', 'Insufficient Coins for membership subscription');
    //                     return $this->redirect(['wallet']);


    //         } else {
    //             Yii::$app->session->setFlash('error', 'Invalid membership offer selected.');
    //         }
    //     }

    //     $user_role=Yii::$app->user->identity->role;

    //     if($user_role=='tutor'){
    //             $this->layout = "tutor_layout";
    //     }

    //     return $this->render('buy-membership', [
    //         //'wallet' => $wallet,
    //         'offers' => $offers,
    //     ]);
    // }

public function actionBuyMembership()
{
    $userId = Yii::$app->user->identity->id;
    $wallet = Wallets::find()->where(['user_id' => $userId])->one();
    $user = User::find()->where(['id' => $userId])->one();
    $offers = ApplyCoin::find()->orderBy(['member_coin_value' => SORT_DESC])->asArray()->all();
    $currentTime = time();

    if (Yii::$app->request->isPost) {
        $offer_price = Yii::$app->request->post('custom_coins');
        $autoRenew = Yii::$app->request->post('auto_renew') ? 1 : 0;

        if ($wallet->balance >= $offer_price) {
            $price = $offer_price;

            // Create a new separate purchase record
            $membership = new Membership();
            $membership->user_id = $userId;
            $membership->premium_coins = $price;
            $membership->memb_expiry = date("Y-m-d H:i:s", $currentTime + (30 * 24 * 3600)); // +30 days from now
            $membership->auto_renew = $autoRenew;
            $membership->cancelled_from_next_month = 0;
            $membership->location = $user->location ?? 'default'; // Use user's location or default
            $membership->rank = 0; // Will be updated in cron
            $membership->discount = 0;
            $membership->created_by = $userId;
            $membership->updated_by = $userId;
            
            if ($membership->save()) {
                // Deduct from wallet
                $wallet->balance -= $price;
                $wallet->save();

                // Set user membership flag if no active before
                if (!Membership::hasActiveMembership($userId)) {
                    $user->membership = 'yes';
                    $user->save();
                }

                $transaction = new WalletTransactions();
                $transaction->wallet_id = $wallet->id;
                $transaction->transaction_type = "debit";
                $transaction->amount = $price;
                $transaction->description = "{$price} membership coins purchased (separate pack). Auto-renew: " . ($autoRenew ? 'Enabled' : 'Disabled') . ".";
                $transaction->status = "completed";
                $transaction->save();

                Yii::$app->session->setFlash('success', 'New membership pack purchased successfully! Valid for 30 days. Total active coins: ' . number_format(Membership::getTotalActiveCoins($userId)));
                return $this->redirect(['buy-membership']);
            } else {
                Yii::error('Failed to save membership: ' . json_encode($membership->errors));
                Yii::$app->session->setFlash('error', 'Failed to process purchase. Please try again.');
            }
        } elseif ($wallet->balance < $offer_price) {
            Yii::$app->session->setFlash('error', 'Insufficient Coins for membership subscription');
            return $this->redirect(['wallet']);
        } else {
            Yii::$app->session->setFlash('error', 'Invalid amount entered.');
        }
    }

    $user_role = Yii::$app->user->identity->role;
    if ($user_role == 'tutor') {
        $this->layout = "tutor_layout";
    }

    return $this->render('buy-membership', [
        'offers' => $offers,
        'membership' => null, // No single membership; use static methods for totals
        'wallet' => $wallet,
        'totalActiveCoins' => Membership::getTotalActiveCoins($userId),
        'purchases' => Membership::getUserMemberships($userId),
        'isMember' => Membership::hasActiveMembership($userId),
    ]);
}

 public function actionCancelAutoRenew()
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
    if (Yii::$app->request->isPost) {
        $purchaseId = Yii::$app->request->post('purchase_id'); // For per-purchase cancel
        if ($purchaseId) {
            $membership = Membership::findOne($purchaseId);
            if ($membership && $membership->user_id == Yii::$app->user->identity->id) {
                $membership->auto_renew = 0;
                if ($membership->save()) {
                    return ['success' => true, 'message' => 'Auto-renewal canceled for this purchase.'];
                }
            }
        } else {
            // Cancel all for user
            $memberships = Membership::find()->where(['user_id' => Yii::$app->user->identity->id, 'auto_renew' => 1])->all();
            foreach ($memberships as $membership) {
                $membership->auto_renew = 0;
                $membership->save();
            }
            return ['success' => true, 'message' => 'Auto-renewal canceled for all purchases.'];
        }
    }
    return ['success' => false, 'message' => 'Error canceling auto-renewal.'];
}

    private function updateRanks($location)
    {
        $members = Membership::find()
            ->where(['location' => $location])
            ->andWhere(['cancelled_from_next_month' => 0]) // Only active memberships
            ->orderBy(['premium_coins' => SORT_DESC])
            ->all();

        if (empty($members)) {
            return;
        }

        $current_rank = 1;
        $ties_count = 1;
        $prev_coins = $members[0]->premium_coins;
        $members[0]->rank = $current_rank;

        for ($i = 1; $i < count($members); $i++) {
            if ($members[$i]->premium_coins == $prev_coins) {
                $members[$i]->rank = $current_rank;
                $ties_count++;
            } else {
                $current_rank += $ties_count;
                $members[$i]->rank = $current_rank;
                $ties_count = 1;
                $prev_coins = $members[$i]->premium_coins;
            }
        }

        foreach ($members as $mem) {
            $mem->save(false);
        }
    }


    protected function findModel($id)
    {
        if (($model = Profiles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested profile does not exist.');
    }
}
