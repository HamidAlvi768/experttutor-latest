<?php

namespace app\controllers;

use app\components\Helper;
use app\components\Mail;
use app\components\Wallet;
use app\models\ApplyCoin;
use app\models\ApplyCoins;
use app\models\Coins;
use app\models\GeneralSetting;
use app\models\JobApplications;
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
use DateTime;
use yii\data\ActiveDataProvider;
use \yii\helpers\ArrayHelper;

/**
 * ProfilesController handles CRUD actions for Profiles model.
 */
class AdminController extends Controller
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


public function actionApplyCoinsAdd()
{
    $model = new ApplyCoin();

    if ($model->load(Yii::$app->request->post())) {
        $countries = (array)$model->country; // multiple selected
        foreach ($countries as $country) {
            $applyCoin = new ApplyCoin();
            $applyCoin->country = $country;
            $applyCoin->coin_value = $model->coin_value;
            $applyCoin->member_coin_value = $model->member_coin_value;
            $applyCoin->save(false);
        }
        Yii::$app->session->setFlash('success', 'Coins saved successfully!');
        return $this->redirect(['admin/apply-coins']);
    }
 $this->layout = 'admin_layout'; // Set layout for admin section

    return $this->render('apply-coins/add', [
        'model' => $model,
    ]);
}
public function actionApplyCoins()
{
        $dataProvider = new ActiveDataProvider([
            'query' => ApplyCoin::find(),
        ]);
 $this->layout = 'admin_layout'; // Set layout for admin section

        return $this->render('apply-coins/index', [
            'dataProvider' => $dataProvider,
        ]);
}

    public function actionApplyCoinsUpdate($id)
    {
        $model = ApplyCoin::findOne($id);

        if ($this->request->isPost && $model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['admin/apply-coins']);
        }
        $this->layout = 'admin_layout'; // Set layout for admin section

        return $this->render('apply-coins/update', [
            'model' => $model,
        ]);
    }

    public function actionApplyCoinsDelete($id)
    {
        ApplyCoin::findOne($id)->delete();
        //$this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Data deleted successfully.');

    return $this->redirect(Yii::$app->request->referrer ?: ['admin/apply-coins']);
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


    public function actionDashboard()
    {
        $this->layout = "admin_layout";
        $id = Yii::$app->user->identity->id;


        $select_data = ['id', 'username', 'email', 'user_status', 'verification', 'active', 'created_at'];

        $students = User::find()
            ->select($select_data)
            ->where(['role' => 'student', 'verification' => 1])
            ->all();


        $tutors = User::find()
            ->select($select_data)
            ->where(['role' => 'tutor', 'verification' => 1])
            ->all();


        $totalUsers = User::find()->where(['!=', 'role', 'superadmin'])->count();
        $totalStudents = User::find()->where(['role' => 'student'])->count();
        $totalTeachers = User::find()->where(['role' => 'tutor'])->count();
        $verifiedUsers = User::find()->where(['!=', 'role', 'superadmin'])->andWhere(['verification' => 1])->count();

        $studentPercentage  = $totalUsers > 0 ? round(($totalStudents / $totalUsers) * 100) : 0;
        $teacherPercentage  = $totalUsers > 0 ? round(($totalTeachers / $totalUsers) * 100) : 0;
        $verifiedPercentage = $totalUsers > 0 ? round(($verifiedUsers / $totalUsers) * 100) : 0;

        $totalcoins = WalletTransactions::find()
            ->alias('t')
            ->joinWith(['wallet w']) // Assuming relation getWallet()
            ->where(['t.transaction_type' => 'credit'])
            ->andWhere(['w.user_type' => 'superadmin'])
            ->sum('t.amount');

        $consumedcoins = WalletTransactions::find()
            ->alias('t')
            ->joinWith(['wallet w']) // Assuming relation getWallet()
            ->where(['t.transaction_type' => 'debit'])
            ->andWhere(['w.user_type' => 'superadmin'])
            ->sum('t.amount');

        //$consumedcoins = $walletcoins;

        $stats = (object)[
            'totalUsers'        => $totalUsers,
            'totalStudents'     => $totalStudents,
            'totalTeachers'     => $totalTeachers,
            'verifiedUsers'     => $verifiedUsers,
            'studentPercentage' => $studentPercentage,
            'teacherPercentage' => $teacherPercentage,
            'verifiedPercentage' => $verifiedPercentage,
            'totalcoins'        => $totalcoins,
            'consumedcoins'     => $consumedcoins,
            'totalPosts'        => StudentJobPosts::find()->count(),
        ];


        $all_posts = StudentJobPosts::find()->all();
        // Prepare job data for line chart (grouped by month)
        $jobDataByMonth = $this->prepareJobDataByMonth();
        $userDataByMonth = $this->prepareUserDataByMonth();

        return $this->render('dashboard', [
            'stats' => $stats,
            'all_posts' => $all_posts,
            'tutors' => $tutors,
            'students' => $students,
            'jobDataByMonth' => $jobDataByMonth,
            'userDataByMonth' => $userDataByMonth,
        ]);
    }



    private function getLast6Months()
    {
        $months = [];
        $date = new DateTime('first day of this month');
        for ($i = 5; $i >= 0; $i--) {
            $clone = clone $date;
            $months[] = $clone->modify("-$i months")->format('M Y');
        }
        return $months;
    }

    private function prepareJobDataByMonth()
    {
        $monthLabels = $this->getLast6Months();
        $counts = array_fill(0, 6, 0); // Initialize with zeros

        // Get job posts within the 6-month range
        $startDate = (new DateTime())->modify('-5 months')->format('Y-m-01');
        $endDate = (new DateTime())->format('Y-m-t');

        $jobPosts = StudentJobPosts::find()
            ->select(['created_at'])
            ->where(['between', 'created_at', $startDate, $endDate])
            ->all();

        // Count posts per month
        foreach ($jobPosts as $post) {
            $month = date('M Y', strtotime($post->created_at));
            if (($index = array_search($month, $monthLabels)) !== false) {
                $counts[$index]++;
            }
        }

        return [
            'labels' => $monthLabels,
            'data'   => $counts
        ];
    }

    // New method for user data
    private function prepareUserDataByMonth()
    {
        $monthLabels = $this->getLast6Months();
        $students = array_fill(0, 6, 0);
        $tutors = array_fill(0, 6, 0);

        $startDate = (new DateTime())->modify('-5 months')->format('Y-m-01');
        $endDate = (new DateTime())->format('Y-m-t');

        // Get student registrations
        $studentRegistrations = User::find() // Assuming User model
            ->select(['created_at'])
            ->where(['role' => 'student'])
            ->andWhere(['between', 'created_at', $startDate, $endDate])
            ->all();

        // Get tutor registrations
        $tutorRegistrations = User::find()
            ->select(['created_at'])
            ->where(['role' => 'tutor'])
            ->andWhere(['between', 'created_at', $startDate, $endDate])
            ->all();

        // Count students
        foreach ($studentRegistrations as $user) {
            $month = date('M Y', strtotime($user->created_at));
            if (($index = array_search($month, $monthLabels)) !== false) {
                $students[$index]++;
            }
        }

        // Count tutors
        foreach ($tutorRegistrations as $user) {
            $month = date('M Y', strtotime($user->created_at));
            if (($index = array_search($month, $monthLabels)) !== false) {
                $tutors[$index]++;
            }
        }

        return [
            'labels' => $monthLabels,
            'students' => $students,
            'tutors' => $tutors
        ];
    }

    public function actionStudents()
    {

        $users = User::find()
            ->select(['id', 'username', 'email', 'user_status', 'verification', 'active', 'created_at'])
            ->where(['role' => 'student'])
            ->asArray() // optional: returns the result as an array instead of ActiveRecord objects
            ->all();

        $this->layout = "admin_layout";
        return $this->render('students', [
            'users' => $users,
        ]);
    }


    public function actionJoblist()
    {
        $id = Yii::$app->user->identity->id;

        $query = StudentJobPosts::find();

        // Get distinct values for filters
        $locations = StudentJobPosts::find()
            ->select('location')
            ->distinct()
            ->orderBy('location')
            ->column();

        $budgets = StudentJobPosts::find()
            ->select('budget')
            ->distinct()
            ->orderBy('budget')
            ->column();

        $subjects = StudentJobPosts::find()
            ->select('subject')
            ->distinct()
            ->orderBy('subject')
            ->column();

        // Filter logic
        if (!empty($_GET['search'])) {
            $query->andFilterWhere(['like', 'title', $_GET['search']]);
        }

        if (!empty($_GET['budget'])) {
    $range = explode('-', $_GET['budget']);

    // if it's a proper range (min-max)
    if (count($range) == 2) {
        $min = (int)$range[0];
        $max = (int)$range[1];

        $query->andWhere(['between', 'budget', $min, $max]);
    } 
    // if it's "10000+" type
    elseif (strpos($_GET['budget'], '+') !== false) {
        $min = (int)str_replace('+', '', $_GET['budget']);
        $query->andWhere(['>=', 'budget', $min]);
    }
}


        if (!empty($_GET['subject'])) {
            $query->andWhere(['subject' => $_GET['subject']]);
        }

        // Optional: re-enable if you want location filtering
        // if (!empty($_GET['location'])) {
        //     $query->andWhere(['location' => $_GET['location']]);
        // }

        $query->orderBy(['id' => SORT_DESC]);

        $model = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->layout = "admin_layout";
        return $this->render('joblist', [
            'dataProvider' => $model,
            'locations' => $locations,
            'budgets' => $budgets,
            'subjects' => $subjects,
        ]);
    }


    public function actionSiteSetting()
    {
        $this->layout = "admin_layout";

        // Load existing settings or create new instance
        $model = GeneralSetting::find()->one();
        if (!$model) {
            $model = new GeneralSetting();
        }


 



        // Check for form submission
        if ($model->load(Yii::$app->request->post())) {


            
// Handle image upload
$model->documentsFile = UploadedFile::getInstance($model, 'site_logo');
$model->documentsFile2 = UploadedFile::getInstance($model, 'site_logo_white');


if ($model->validate()) {
    // ✅ For site_logo
    if ($model->documentsFile) {
        // Delete old file if it exists
        if (!empty($model->getOldAttribute('site_logo')) && file_exists(Yii::getAlias('@webroot') . $model->getOldAttribute('site_logo'))) {
            @unlink(Yii::getAlias('@webroot') . $model->getOldAttribute('site_logo'));
        }

        // Upload new file
        $avatarPath = $model->uploadAvatar();
        if ($avatarPath) {
            $model->site_logo = $avatarPath;
        }
    } else {
        // Keep old file if no new upload
        $model->site_logo = $model->getOldAttribute('site_logo');
    }

    // ✅ For site_logo_white
    if ($model->documentsFile2) {
        // Delete old file if it exists
        if (!empty($model->getOldAttribute('site_logo_white')) && file_exists(Yii::getAlias('@webroot') . $model->getOldAttribute('site_logo_white'))) {
            @unlink(Yii::getAlias('@webroot') . $model->getOldAttribute('site_logo_white'));
        }

        // Upload new file
        $avatarPath = $model->uploadAvatar2();
        if ($avatarPath) {
            $model->site_logo_white = $avatarPath;
        }
    } else {
        // Keep old file if no new upload
        $model->site_logo_white = $model->getOldAttribute('site_logo_white');
    }
}





             if($model->save()){

            Yii::$app->session->setFlash('success', 'Settings saved successfully.');
            return $this->redirect(['site-setting']);
             }
        } elseif (Yii::$app->request->isPost) {
            Yii::$app->session->setFlash('error', 'Failed to save settings. Please check the input.');
        }

        return $this->render('site_setting_form', [
            'model' => $model,
        ]);
    }

    public function actionEmailSetting()
    {
        $this->layout = "admin_layout";

        // Load existing settings or create new instance
        $model = GeneralSetting::find()->one();
        if (!$model) {
            $model = new GeneralSetting();
        }

        // Check for form submission
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Settings saved successfully.');
                return $this->redirect(['email-setting']);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to save settings. Please check the input.');
            }
        }

        return $this->render('emial_setting_form', [
            'model' => $model,
        ]);
    }
    // public function actionWallet()
    // {

    //     $id = Yii::$app->user->identity->id;

    //     $my_wallet = Wallets::find()->where(['user_id' => $id])->andWhere(['user_type' => 'superadmin'])->one();

    //     $wallet_transaction = Wallets::find()->with(['transactions'])->where(['user_id' => $id])->one();
    //     //var_dump($wallet_transaction);die;
    //     //$wallet_transaction = WalletTransactions::find()->with(['transactionWallet'])->all();
    //     //var_dump($wallet_transaction);die;
    //     $this->layout = "admin_layout";

    //     return $this->render('admin_wallet', [
    //         'wallet' => $wallet_transaction,
    //         'my_wallet' => $my_wallet
    //     ]);
    // }



    public function actionWallet()
    {
        $id = Yii::$app->user->identity->id;

        // Fetch wallet of superadmin
        $my_wallet = Wallets::find()
            ->where(['user_id' => $id, 'user_type' => 'superadmin'])
            ->one();

        if (!$my_wallet) {
            throw new \yii\web\NotFoundHttpException("Wallet not found.");
        }

        // Fetch transactions of this wallet with pagination
        $query = WalletTransactions::find()
            ->where(['wallet_id' => $my_wallet->id])
            ->orderBy(['created_at' => SORT_DESC]);

        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => Yii::$app->request->get('per-page', 10), // or any number you prefer
        ]);

        $transactions = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $this->layout = "admin_layout";

        return $this->render('admin_wallet', [
            'my_wallet' => $my_wallet,
            'transactions' => $transactions,
            'pagination' => $pagination,
        ]);
    }


    public function actionRecharge()
    {
        $userId = Yii::$app->user->identity->id;
        $coin_count = Yii::$app->request->post('coin_count');
        $code = Yii::$app->request->post('code');

         $userVerification = UserVerifications::find()->where(['user_id' => $userId])
        ->orderBy(['created_at' => SORT_DESC])
        ->one();

        if (
            $coin_count > 0 &&
            $code == $userVerification->email_verification_code &&
            $userVerification->email_verification_expires > time()
        ) {


            $depositCoins = $coin_count;
           

            Helper::admin_recharge($depositCoins);
            Yii::$app->session->setFlash('success', 'Wallet recharged successfully.');
        }else {
            Yii::$app->session->setFlash('error', 'Invalid code or coin count.');
            return $this->redirect(['wallet']);
        }



        return $this->redirect(['/admin/wallet']);
    }


        public function actionVerification()
    {
        $user = Yii::$app->user->identity;
        if (!$user || $user->role != 'superadmin') {
            return $this->asJson(['success' => false, 'message' => 'User not logged in.']);
        }
        $userVerification = UserVerifications::find()->where(['user_id' => $user->id])->orderBy(['created_at' => SORT_DESC])->one();
       


         $otp = rand(100000, 999999);

         if(!$userVerification) {
            
        $userVerification = new UserVerifications();
         }
        $userVerification->user_id = $user->id;
        $userVerification->email = $user->email;
        $userVerification->email_verification_code = (string) $otp;
        $userVerification->email_verification_expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        $verifcationSaved = $userVerification->save();

               if (!$verifcationSaved) {
            echo '<pre>';
            print_r($userVerification->getErrors());
            echo '</pre>';
            die;
        }
       
        $site_setting = GeneralSetting::find()->one();

        $isSend = Mail::send(
            $user->email,
            'Your verification Code for '.$site_setting->site_name.' ' . date("F d,y H:m"),
            'mail/verification-code.php',
            [
                'username' => $user->username,
                'verificationLink' => $otp,
            ]
        );

        if (!$isSend['status']) {
            return $this->asJson(['success' => false, 'message' => 'Failed to send verification code.', 'mail' => $isSend]);
        } else {

            return $this->asJson(['success' => true, 'message' => 'Verification code has been sent.', 'erros' => $isSend['errors']]);
        }
    }


}
