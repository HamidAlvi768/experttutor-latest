<?php

namespace app\controllers\api;

use app\components\Helper;
use app\components\JwtHelper;
use app\models\Coins;
use app\models\JobApplications;
use Yii;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use app\models\User;
use app\models\Wallets;
use app\models\WalletTransactions;
use app\models\Profiles;
use app\models\Referrals;
use app\models\StudentJobPosts;
use app\models\TeacherEducation;
use app\models\TeacherJobDescriptions;
use app\models\TeacherProfessionalExperience;
use app\models\TeacherSubjects;
use app\models\TeacherTeachingDetails;
use app\models\UserReferralCodes;
use app\models\UserVerifications;
use yii\data\Pagination;
use yii\web\Response;

class TutorController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'teacher-profile' => ['GET', 'POST'],
                'index' => ['GET'],
            ],
        ];

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
                'tutor' => ['*'],
                'student' => ['index'],
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

    public function actionIndex()
    {
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        $user = User::find()->with(['profile'])->where(['id' => Yii::$app->user->id])->one();

        if ($user) {
            return ['status' => 'success', 'user' => $user];
        }

        Yii::$app->response->statusCode = 404;
        return ['status' => 'error', 'message' => 'User not found.'];
    }

    public function actionTeacherProfile()
    {
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        $id = Yii::$app->user->id;
        $model = Profiles::find()->where(['user_id' => $id])->one();

        if (!$model) {
            $model = new Profiles();
        }

        $model->load(Yii::$app->request->post(), '');

        $model->user_id = $id;

        if ($model->save()) {
            $userVerification = UserVerifications::find()->where(['user_id' => $id])->one();
            if ($userVerification) {
                $otpCode = str_pad(random_int(0, 999999), 5, '0', STR_PAD_LEFT);
                $userVerification->phone_number = $model->phone_number;
                $userVerification->phone_verification_code = $otpCode;
                $userVerification->phone_verified = 0;
                $userVerification->save();
            }

            return [
                'status' => 'success',
                'message' => 'Profile saved successfully.',
                'profile_id' => $model->id
            ];
        }

        Yii::$app->response->statusCode = 400;
        return [
            'status' => 'error',
            'message' => 'Failed to save profile.',
            'errors' => $model->getErrors()
        ];
    }

    private function checkAndCreateWallet($id)
    {
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        $wallet = Wallets::find()->where(['user_id' => $id])->one();
        if (!$wallet) {
            $depositCoins = 100;

            $wallet = new Wallets();
            $wallet->user_id = $id;
            $wallet->balance = 0;
            $wallet->currency = "Coins";
            $wallet->active = 1;
            $wallet->save();

            $transaction = new WalletTransactions();
            $transaction->wallet_id = $wallet->id;
            $transaction->transaction_type = "credit";
            $transaction->amount = $depositCoins;
            $transaction->description = "{$depositCoins} Coins deposit on account signup.";
            $transaction->status = "completed";
            $transaction->save();
        }
    }



    public function actionSubjectTeach()
    {
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //

        $id = Yii::$app->user->identity->id;

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();

            $subjects = $data['subject'] ?? [];
            $from_levels = $data['from_level'] ?? [];
            $to_levels = $data['to_level'] ?? [];

            TeacherSubjects::deleteAll(['teacher_id' => $id]);

            foreach ($subjects as $i => $subj) {
                $ts = new TeacherSubjects();
                $ts->teacher_id = $id;
                $ts->subject = $subj;
                $ts->from_level = $from_levels[$i] ?? null;
                $ts->to_level = $to_levels[$i] ?? null;
                $ts->save(false);
            }

            return ['success' => true, 'message' => 'Subjects saved successfully'];
        }

        $existingSubjects = TeacherSubjects::find()->where(['teacher_id' => $id])->all();
        return ['success' => true, 'subjects' => $existingSubjects];
    }
    public function actionEducationExperience()
    {
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //

        $id = Yii::$app->user->identity->id;

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('TeacherEducation');

            $institute_name = $data['institute_name'] ?? [];
            $degree_type = $data['degree_type'] ?? [];
            $degree_name = $data['degree_name'] ?? [];
            $start_date = $data['start_date'] ?? [];
            $end_date = $data['end_date'] ?? [];
            $association = $data['association'] ?? [];
            $specialization = $data['specialization'] ?? [];

            TeacherEducation::deleteAll(['teacher_id' => $id]);

            for ($i = 0; $i < count($institute_name); $i++) {
                $edu = new TeacherEducation();
                $edu->teacher_id = $id;
                $edu->institute_name = $institute_name[$i];
                $edu->degree_type = $degree_type[$i];
                $edu->degree_name = $degree_name[$i];
                $edu->start_date = $start_date[$i];
                $edu->end_date = $end_date[$i];
                $edu->association = $association[$i];
                $edu->specialization = $specialization[$i];
                $edu->save(false);
            }

            return ['success' => true, 'message' => 'Education experience saved'];
        }

        $existing = TeacherEducation::find()->where(['teacher_id' => $id])->all();
        return ['success' => true, 'educations' => $existing];
    }

    public function actionProfessionalExperience()
    {

                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //

        $id = Yii::$app->user->identity->id;

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post('TeacherProfessionalExperience');
            $post = Yii::$app->request->post();

            $organization = $data['organization'] ?? [];
            $designation = $data['designation'] ?? [];
            $start_date = $data['start_date'] ?? [];
            $end_date = $data['end_date'] ?? [];
            $association = $data['association'] ?? [];
            $job_role = $data['job_role'] ?? [];

            // Handle dynamic additional fields
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

            TeacherProfessionalExperience::deleteAll(['teacher_id' => $id]);

            for ($i = 0; $i < count($organization); $i++) {
                $exp = new TeacherProfessionalExperience();
                $exp->teacher_id = $id;
                $exp->organization = $organization[$i];
                $exp->designation = $designation[$i];
                $exp->start_date = $start_date[$i];
                $exp->end_date = $end_date[$i];
                $exp->association = $association[$i];
                $exp->job_role = $job_role[$i];
                $exp->save(false);
            }

            return ['success' => true, 'message' => 'Professional experience saved'];
        }

        $existing = TeacherProfessionalExperience::find()->where(['teacher_id' => $id])->all();
        return ['success' => true, 'experiences' => $existing];
    }
    public function actionTeachingDetails()
    {

                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //

        $id = Yii::$app->user->identity->id;

        $model = TeacherTeachingDetails::findOne(['teacher_id' => $id]) ?? new TeacherTeachingDetails();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post(), '');
            $model->teacher_id = $id;

            if ($model->save()) {
                return ['success' => true, 'message' => 'Teaching details saved successfully'];
            }

            return ['success' => false, 'errors' => $model->getErrors()];
        }

        return ['success' => true, 'model' => $model];
    }

    public function actionTeacherDescription()
    {

                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        $id = Yii::$app->user->identity->id;

        $model = TeacherJobDescriptions::findOne(['teacher_id' => $id]) ?? new TeacherJobDescriptions();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post(), '');
            $model->teacher_id = $id;

            if ($model->save()) {
                return ['success' => true, 'message' => 'Job description saved successfully'];
            }

            return ['success' => false, 'errors' => $model->getErrors()];
        }

        return ['success' => true, 'model' => $model];
    }

    public function actionDashboard()
    {
        //Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; // ADD THIS
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //

        $id = Yii::$app->user->identity->id;

        // Check and create wallet
        $this->checkAndCreateWallet($id);

        $user = User::findOne($id);

        $tutorSubjects = TeacherSubjects::find()
            ->select('subject')
            ->where(['teacher_id' => $id])
            ->asArray()
            ->column();

        $jobs = StudentJobPosts::find()
            ->where(['in', 'subject', $tutorSubjects])
            ->orderBy(['id' => SORT_DESC])
            ->limit(10)
            ->all();

        return [
            'success' => true,
            'user' => $user,
            'matched_jobs' => $jobs,
        ];
    }

    public function actionRecentJobs()
    {
        //Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //

        $id = Yii::$app->user->identity->id;
        $this->checkAndCreateWallet($id);

        $jobs = StudentJobPosts::find()
            ->orderBy(['id' => SORT_DESC])
            ->limit(10)
            ->all();

        return [
            'success' => true,
            'jobs' => $jobs,
        ];
    }

    public function actionSavedJobs()
    {
        //Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //

        $id = Yii::$app->user->identity->id;
        $this->checkAndCreateWallet($id);

        $savedJobs = StudentJobPosts::find()
            ->innerJoin('job_applications', 'job_applications.job_id = student_job_posts.id')
            ->where(['job_applications.applicant_id' => $id])
            ->orderBy(['student_job_posts.id' => SORT_DESC])
            ->limit(10)
            ->all();

        return [
            'success' => true,
            'saved_jobs' => $savedJobs,
        ];
    }

    public function actionJobApply()
    {
        // Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //

        $id = Yii::$app->user->identity->id;
        $user = User::findOne($id);
        $job_id = Yii::$app->request->get("id");

        if (!$job_id) {
            return ['success' => false, 'message' => 'Job ID is required.'];
        }

        $post = StudentJobPosts::find()->with(['applies'])->where(['id' => $job_id])->one();

        if (!$post) {
            return ['success' => false, 'message' => 'Job post not found.'];
        }

        $applied = JobApplications::find()->where(['job_id' => $job_id, 'applicant_id' => $id])->one();
        $coins = Wallets::find()->where(['user_id' => $id])->one();

        return [
            'success' => true,
            'user' => $user,
            'post' => $post,
            'applied' => $applied,
            'coins' => $coins
        ];
    }

    public function actionApplyNow()
    {
        //Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //

        $id = Yii::$app->user->identity->id;
        $redirectUrl = Yii::$app->request->get("url");
        $job_id = Yii::$app->request->get("id");
        $coins = Yii::$app->request->get("coins");
        $postId = Yii::$app->request->get("post");

        if (!$job_id || !$coins || !$redirectUrl) {
            return ['success' => false, 'message' => 'Required parameters are missing.'];
        }

        $applyMethod = ($redirectUrl == 'call') ? 'call' : 'message';
        $application = JobApplications::find()
            ->where(['job_id' => $job_id, 'applicant_id' => $id])
            ->one();

        $alreadyApplied = false;
        $userWallet = Wallets::find()->where(['user_id' => $id])->one();

        if (!$userWallet || $userWallet->balance < $coins) {
            return [
                'success' => false,
                'message' => 'Insufficient wallet balance.',
                'redirect' => Yii::$app->urlManager->createUrl(['/tutor/wallet'])
            ];
        }

        if (!$application) {
            $userWallet->balance -= $coins;
            $userWallet->save();

            $transaction = new WalletTransactions();
            $transaction->wallet_id = $userWallet->id;
            $transaction->transaction_type = "debit";
            $transaction->amount = $coins;
            $transaction->description = "Paid for a $applyMethod during job apply";
            $transaction->status = "completed";
            $transaction->save();

            $application = new JobApplications();
            $application->job_id = $job_id;
            $application->applicant_id = $id;
            $application->$applyMethod = 1;
            $application->save();
        } else {
            if ($application->$applyMethod != 1) {
                $userWallet->balance -= $coins;
                $userWallet->save();

                $transaction = new WalletTransactions();
                $transaction->wallet_id = $userWallet->id;
                $transaction->transaction_type = "debit";
                $transaction->amount = $coins;
                $transaction->description = "Paid for a $applyMethod during job apply";
                $transaction->status = "completed";
                $transaction->save();

                $application->$applyMethod = 1;
                $application->save();
            }
            $alreadyApplied = true;
        }

        if ($applyMethod == 'call') {
            $post = StudentJobPosts::findOne($job_id);
            $whatsappNumber = $this->formatWhatsappNumber($post->phone_number);

            return [
                'success' => true,
                'message' => 'Applied successfully. Redirecting to WhatsApp...',
                'redirect' => "https://wa.me/{$whatsappNumber}?text=" . urlencode("Hello, I am interested in your job post titled '{$post->title}'."),
                'already_applied' => $alreadyApplied
            ];
        } else {
            return [
                'success' => true,
                'message' => 'Applied successfully.',
                'redirect' => $redirectUrl . "&post=" . $postId,
                'already_applied' => $alreadyApplied
            ];
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



    public function actionWallet()
    {
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        $id = Yii::$app->user->identity->id;

        $user = User::find()->with(['wallet'])->where(['id' => $id])->one();
        $wallet = Wallets::find()->with(['transactions'])->where(['user_id' => $id])->one();

        return [
            'user' => $user,
            'wallet' => $wallet,
            'coins' => Coins::find()->all(),
        ];
    }

    public function actionGetCoins()
    {
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        $id = Yii::$app->user->identity->id;
        $user = User::find()->with(['wallet'])->where(['id' => $id])->one();
        $coins = Coins::find()->all();

        $coinId = Yii::$app->request->post('coin');
        if ($coinId) {
            $coin = Coins::findOne($coinId);
            Yii::$app->session->set('coin', $coin);
            return ['status' => 'success', 'redirect' => '/payment/stripe-payment'];
        }

        return [
            'user' => $user,
            'coins' => $coins,
        ];
    }

    public function actionPaymentSuccess($id)
    {
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        $paymentId = Yii::$app->session->get('id');
        $userId = Yii::$app->user->identity->id;

        if ($id == $paymentId) {
            $coin = Yii::$app->session->get('coin');
            Yii::$app->session->remove('coin');

            $depositCoins = $coin['coin_count'];
            $wallet = Wallets::find()->where(['user_id' => $userId])->one();
            $wallet->balance += $depositCoins;
            $wallet->save();

            $transaction = new WalletTransactions();
            $transaction->wallet_id = $wallet->id;
            $transaction->transaction_type = "credit";
            $transaction->amount = $depositCoins;
            $transaction->description = "{$depositCoins} Coins purchased.";
            $transaction->status = "completed";
            $transaction->save();

            
            $tutor_name= User::getusername($wallet->user_id);

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

            return ['status' => 'success', 'wallet_balance' => $wallet->balance];
        }

        return ['status' => 'error', 'message' => 'Invalid Payment ID'];
    }

    public function actionReferrals()
    {
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        $id = Yii::$app->user->identity->id;
        $code = UserReferralCodes::find()->where(['user_id' => $id])->one();

        if (!$code) {
            $referralCode = Helper::generateReferralCode(Yii::$app->user->identity->username, $id);
            $code = new UserReferralCodes();
            $code->user_id = $id;
            $code->referral_code = $referralCode;
            $code->save();
        }

        $query = Referrals::find()->with(['user'])->where(['referrer_id' => $id]);

        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 10,
        ]);

        $referrals = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return [
            'referral_code' => $code,
            'referrals' => $referrals,
            'pagination' => [
                'totalCount' => $pagination->totalCount,
                'pageCount' => $pagination->getPageCount(),
                'pageSize' => $pagination->pageSize,
            ]
        ];
    }

    public function actionUpdate()
    {
                //Token Validation //

        $JWT_auth = JwtHelper::getUserFromToken();

        if (!$JWT_auth) {
                Yii::$app->response->statusCode = 401;
                return ['success' => false, 'message' => 'Unauthorized Token Needed'];
        }

        //Token Validation End //
        $id = Yii::$app->user->identity->id;
        $model = Profiles::find()->where(['user_id' => $id])->one();

        if (!$model) {
            return ['status' => 'error', 'message' => 'Profile not found.'];
        }

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ['status' => 'success', 'profile' => $model];
        }

        return ['status' => 'error', 'message' => $model->getErrors()];
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
        $model = Profiles::findOne($id);
        if (!$model) {
            return ['status' => 'error', 'message' => 'Profile not found.'];
        }

        $model->delete();
        return ['status' => 'success', 'message' => 'Profile deleted.'];
    }



}
