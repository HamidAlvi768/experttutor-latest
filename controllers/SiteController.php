<?php

namespace app\controllers;

use app\components\Wallet;
use app\components\Helper;
use app\components\Mail;
use app\components\TwilioHelper;
use app\models\Referrals;
use app\models\UserLeaveLog;
use app\models\UserVerifications;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\GeneralSetting;
use app\models\Roles;
use app\models\SignupForm;
use app\models\User;
use app\models\Profiles;
use app\models\Reviews;
use app\models\StudentJobPosts;
use app\models\UserReferralCodes;
use app\models\PasswordResetRequestForm;
use app\models\PasswordResetForm;
use Exception;
use yii\debug\models\search\Profile;
use yii\web\BadRequestHttpException;
use yii\base\InvalidArgumentException;
use yii\data\Pagination;

class SiteController extends Controller
{
    public function beforeAction($action)
    {

        $actionId = $action->id;
        $controllerId = $this->id;

        // PUBLIC ACTIONS
        $publicActions = ['', '/', 'index', 'tutors', 'tutor-profile', 'contact', 'verify', 'about', 'faq', 'privacy-policy', 'terms', 'help', 'login', 'ajax-suggestions', 'ajax-tutors', 'signup', 'error', 'check-username', 'request-password-reset', 'reset-password', 'ajax-review'];

        // Check if user is guest and trying to access restricted area
        if (Yii::$app->user->isGuest && !in_array($actionId, $publicActions)) {
            // Yii::$app->session->setFlash('error', 'Please login to access this page.');
            return Yii::$app->response->redirect(['/login'])->send();
        }


        // Role-based access control
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity;
            $userRole = $user->role;

            // check user verificaiton
            if (!$user->verification && ($actionId != "verification" && $actionId != "verify" && $actionId != "check-verification")) {
                return $this->redirect(['/verification']);
            }



            // Define role-specific permissions
            $permissions = [
                'superadmin' => ['*'],
                'admin' => ['*'],
                'tutor' => ['', '/', 'index', 'tutors', 'tutor-profile', 'verification', 'verify', 'verify-phone', 'contact', 'about', 'faq', 'privacy-policy', 'terms', 'help', 'error', 'logout', 'log-user-leaving'],
                'student' => ['', '/', 'index', 'tutors', 'tutor-profile', 'verification', 'resend-verification', 'verify', 'verify-phone', 'contact', 'about', 'faq', 'privacy-policy', 'terms', 'help', 'error', 'logout', 'log-user-leaving'],
            ];

            // Check if user has permission
            if ((!in_array($actionId, $permissions[$userRole]) && (!in_array($actionId,  $publicActions)))) {
                //     Yii::$app->session->setFlash('error', 'You do not have permission to access this page.');
                return $this->redirect(['site/index']);
            }
        }

        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    // public function actionLogUserLeaving()
    // {
    //     if (!Yii::$app->user->isGuest) {
    //         $rawData = Yii::$app->request->getRawBody();
    //         $data = json_decode($rawData, true);
    //         if ($data) {
    //             $model = new UserLeaveLog();
    //             $model->message = $data['message'] ?? 'User left the page';
    //             $timestamp = $data['timestamp'] ?? null;
    //             if ($timestamp) {
    //                 $model->user_id = Yii::$app->user->identity->id;
    //                 // Convert JavaScript timestamp (milliseconds) to seconds for PHP
    //                 $model->left_at = date('Y-m-d H:i:s', $timestamp / 1000);
    //             } else {
    //                 // Fallback to current server time if timestamp is missing
    //                  $model->user_id = Yii::$app->user->identity->id;
    //                 $model->left_at = date('Y-m-d H:i:s');
    //             }
    //             $model->save();
    //             return $this->asJson(['status' => 'success']);
    //         }
    //     }
    //     return $this->asJson(['status' => 'error', 'message' => 'Invalid data']);
    // }
    public function actionLogUserLeaving()
    {
        if (!Yii::$app->user->isGuest) {
            $rawData = Yii::$app->request->getRawBody();
            $data = json_decode($rawData, true);
            if ($data) {
                $model = new UserLeaveLog();
                $model->message = $data['message'] ?? 'User left the page';
                $timestamp = $data['timestamp'] ?? null;
                if ($timestamp) {
                    $model->user_id = Yii::$app->user->identity->id;
                    // Convert JavaScript timestamp (milliseconds) to seconds for PHP
                    $model->left_at = date('Y-m-d H:i:s', $timestamp / 1000);
                } else {
                    // Fallback to current server time if timestamp is missing
                    $model->user_id = Yii::$app->user->identity->id;
                    $model->left_at = date('Y-m-d H:i:s');
                }
                $model->save();
                return $this->asJson(['status' => 'success']);
            }
        }
        return $this->asJson(['status' => 'error', 'message' => 'Invalid data']);
    }
    public function actionIndex()
    {

        if (!Yii::$app->user->isGuest) {
            $userRole = Yii::$app->user->identity->role;

            if ($userRole == 'tutor') {

                $profiles = Profiles::profile_completed();
                if (!$profiles) {
                    return $this->redirect(['/tutor/profile']);
                } else {
                    return $this->redirect(['/tutor/dashboard']);
                }

                return $this->redirect(['/tutor/dashboard']);
            } elseif ($userRole == 'student') {
                $profiles = Profiles::profile_completed();
                if (!$profiles) {
                    return $this->redirect(['/profile/create']);
                } else {
                    return $this->redirect(['/post/list']);
                }
            }
        }


        $totalStudents = User::find()->where(['role' => 'student'])->count();
        $totalTeachers = User::find()->where(['role' => 'tutor'])->count();
        $totalcountry =  Profiles::find()->select('country')->distinct()->count();
        $jobPost = StudentJobPosts::find()->count();

        $successRate = $jobPost > 0 ? round((StudentJobPosts::find()->where(['post_status' => 'complete'])->count() / $jobPost) * 100, 1) : 0;




        $stats = (object)[

            'totalStudents'     => $totalStudents,
            'totalTeachers'     => $totalTeachers,
            'totalCountries'    => $totalcountry,
            'successRate'       => $successRate,
        ];


        return $this->render('index', [
            'stats_data' => $stats,
            'subjects' => StudentJobPosts::find()->select('subject')->distinct()->column(),
            'studentReviews' => Reviews::find()
                ->asArray()
                ->select(['review_text', 'star_rating', 'created_at', 'user_id'])
                ->where(['user_type' => 'student'])
                ->all(),
        ]);
    }

    // public function actionTutors()
    // {
    //     $tutors = User::find()->with(['reviews', 'profile', 'subjects'])->where(['role' => 'tutor'])->all();

    //     return $this->render('tutors', ['tutors' => $tutors]);
    // }
    // public function actionTutors()
    // {
    //     $query = User::find()
    //         ->with(['reviews', 'profile', 'subjects'])
    //         ->where(['role' => 'tutor'])
    //         ->joinWith(['profile', 'subjects']); // ensure relationships are joined

    //     // Check if 'search' query param exists
    //     $search = Yii::$app->request->get('search');
    //     if (!empty($search)) {
    //         $query->andFilterWhere([
    //             'or',
    //             ['like', 'username', $search],
    //             ['like', 'email', $search],
    //             ['like', 'first_name', $search],
    //             ['like', 'last_name', $search],
    //             ['like', 'subject', $search], // now works due to join
    //         ]);
    //     }

    //     $tutors = $query->all();

    //     return $this->render('tutors', ['tutors' => $tutors]);


    //     $tutors = $query->all();

    //     return $this->render('tutors', [
    //         'tutors' => $tutors,
    //         'search' => $search
    //     ]);
    // }

    public function actionTutors()
    {
        $query = User::find()
            ->with(['reviews', 'profile', 'subjects'])
            ->where(['role' => 'tutor'])
            ->joinWith(['profile', 'subjects']);

        $search = Yii::$app->request->get('search');
        if (!empty($search)) {
            $query->andFilterWhere([
                'or',
                ['like', 'username', $search],
                ['like', 'email', $search],
                ['like', 'first_name', $search],
                ['like', 'last_name', $search],
                ['like', 'subject', $search],
                ['like', 'country', $search],
            ]);
        }

        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 12,
        ]);

        $tutors = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        if (!Yii::$app->user->isGuest) {

            $user_role = Yii::$app->user->identity->role;

            if ($user_role == 'student') {
                $this->layout = "tutor_layout";
            }
        }


        return $this->render('tutors', [
            'tutors' => $tutors,
            'pages' => $pages,
            'search' => $search
        ]);
    }

    public function actionAjaxTutors()
    {
        $search = Yii::$app->request->get('search', '');
        $page = Yii::$app->request->get('page', 1);

        $query = User::find()
            ->with(['reviews', 'profile', 'subjects'])
            ->where(['role' => 'tutor'])
            ->joinWith(['profile', 'subjects']);

        if (!empty($search)) {
            $query->andFilterWhere([
                'or',
                ['like', 'username', $search],
                ['like', 'email', $search],
                ['like', 'first_name', $search],
                ['like', 'last_name', $search],
                ['like', 'subject', $search],
                ['like', 'country', $search],
            ]);
        }

        $countQuery = clone $query;
        $totalCount = $countQuery->count();
        $pageSize = 12;

        $pages = new Pagination([
            'totalCount' => $totalCount,
            'pageSize' => $pageSize,
            'page' => $page - 1,
        ]);

        $tutors = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $html = $this->renderPartial('_tutors_grid', [
            'tutors' => $tutors,
            'pages' => $pages,
            'search' => $search
        ]);

        return $this->asJson([
            'html' => $html,
            'total' => $totalCount,
        ]);
    }

    public function actionAjaxSuggestions()
    {
        $term = Yii::$app->request->get('term', '');
        if (empty($term)) {
            Yii::debug('No search term provided', __METHOD__);
            return $this->asJson([]);
        }

        $suggestions = [];
        try {
            // Fetch users with matching username, first_name, last_name, email
            try {
                $nameQuery = User::find()
                    ->select(['username'])
                    ->distinct()
                    ->where(['role' => 'tutor'])
                    //->joinWith('subjects')
                    ->andWhere(['like', 'username', '%' . $term . '%', false])
                    ->column();
                $suggestions = array_merge($suggestions, $nameQuery);
                Yii::debug('Name suggestions: ' . json_encode($nameQuery), __METHOD__);
            } catch (Exception $e) {
                Yii::error('Name query failed: ' . $e->getMessage(), __METHOD__);
            }

            // Fetch subjects
            try {
                $subjectQuery = User::find()
                    ->select(['subject'])
                    ->distinct()
                    ->where(['role' => 'tutor'])
                    ->joinWith('subjects')
                    ->andWhere(['like', 'subject', '%' . $term . '%', false])
                    ->column();
                $suggestions = array_merge($suggestions, $subjectQuery);
                Yii::debug('Subject suggestions: ' . json_encode($subjectQuery), __METHOD__);
            } catch (Exception $e) {
                Yii::error('Subjects query failed: ' . $e->getMessage(), __METHOD__);
            }

            // Fetch countries
            try {
                $countryQuery = User::find()
                    ->select(['country'])
                    ->distinct()
                    ->where(['role' => 'tutor'])
                    ->joinWith('profile')
                    ->andWhere(['like', 'country', '%' . $term . '%', false])
                    ->andWhere(['not', ['country' => null]])
                    ->column();
                $suggestions = array_merge($suggestions, $countryQuery);
                Yii::debug('Country suggestions: ' . json_encode($countryQuery), __METHOD__);
            } catch (Exception $e) {
                Yii::error('Countries query failed: ' . $e->getMessage(), __METHOD__);
            }

            // Remove duplicates, filter out empty values, and sort
            $suggestions = array_unique(array_filter($suggestions));
            sort($suggestions);
        } catch (Exception $e) {
            Yii::error('Error in actionAjaxSuggestions: ' . $e->getMessage(), __METHOD__);
            return $this->asJson(['error' => 'Internal server error: ' . $e->getMessage()]);
        }

        Yii::debug('Final suggestions for term "' . $term . '": ' . json_encode($suggestions), __METHOD__);
        return $this->asJson($suggestions);
    }



    public function actionTutorProfile()
    {
        $tutor = User::find()
            ->with(['reviews', 'profile', 'subjects', 'educations', 'experiences', 'details', 'description'])
            //->where(['role' => 'tutor'])
            ->where(['user_slug' => $_GET['id']])
            ->one();

        if (!Yii::$app->user->isGuest) {
            $user_role = Yii::$app->user->identity->role;

            if ($user_role == 'student') {
                $this->layout = "tutor_layout";
            }
        }


        return $this->render('tutor-profile', ['tutor' => $tutor]);
    }

    // public function actionAjaxReview()
    // {
    //     $tutor = User::find()
    //         ->with(['profile', 'subjects', 'educations', 'experiences', 'details', 'description'])
    //         ->where(['id' => Yii::$app->request->get('id')])
    //         ->one();

    //     if (!$tutor) {
    //         \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    //         return [
    //             'reviews' => [],
    //             'total' => 0,
    //             'currentPage' => 1,
    //             'totalPages' => 0,
    //             'error' => 'Tutor not found'
    //         ];
    //     }

    //     // If it's an AJAX request for reviews pagination
    //     if (Yii::$app->request->isAjax && Yii::$app->request->get('page')) {
    //         $page = (int)Yii::$app->request->get('page', 1);
    //         $perPage = 15;

    //         // ✅ Correct: use ActiveQuery, not array
    //         $query = $tutor->getReviews();

    //         $totalReviews = $query->count();
    //         $reviews = $query->offset(($page - 1) * $perPage)
    //                          ->limit($perPage)
    //                          ->all();

    //         $reviewData = [];
    //         foreach ($reviews as $review) {
    //             $review_date = date('j M Y', strtotime($review->created_at));
    //             $profile_image = Helper::getuserimage($review->user_id);
    //             $profile_image = $profile_image ? Helper::baseUrl($profile_image) : null;
    //             $user_name = User::getusername($review->user_id);

    //             $reviewData[] = [
    //                 'avatar' => $profile_image ?: 'https://ui-avatars.com/api/?name=' . urlencode($user_name),
    //                 'name'   => $user_name ?: 'Student',
    //                 'date'   => $review_date,
    //                 'rating' => $review->star_rating,
    //                 'text'   => $review->review_text,
    //             ];
    //         }

    //         \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    //         return [
    //             'reviews'     => $reviewData,
    //             'total'       => $totalReviews,
    //             'currentPage' => $page,
    //             'totalPages'  => ceil($totalReviews / $perPage),
    //         ];
    //     }

    //     return $this->render('tutor-profile', ['tutor' => $tutor]);
    // }







    public function actionLogin()
    {

        $usersCount = User::find()->count();
        if ($usersCount == 0) {
            // Add roles
            Roles::addDefaultRoles();

            // Add first admin
            $user = User::createAdmin();
            $user_id = $user->id;

            Helper::createwallet($user_id, '', 'superadmin');
        }

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post();
            if ($model->load($postData)) {
                $loginResult = $model->login();

                if ($loginResult) {
                    Yii::$app->session->setFlash('success', 'Login Successfully.');
                    $userRole = Yii::$app->user->identity->role;

                    // If there’s a return URL, go back there
                    if (Yii::$app->user->getReturnUrl() && Yii::$app->user->getReturnUrl() !== Yii::$app->homeUrl) {
                        return $this->goBack();
                    }

                    // Otherwise, fallback to role-based redirects
                    if ($userRole == 'superadmin' || $userRole == 'admin') {
                        return $this->redirect(['/admin/dashboard']);
                    } elseif ($userRole == 'tutor') {
                        $profiles = Profiles::profile_completed();
                        if (!$profiles) {
                            return $this->redirect(['/tutor/profile']);
                        } else {
                            return $this->redirect(['/tutor/dashboard']);
                        }
                    } elseif ($userRole == 'student') {
                        $profiles = Profiles::profile_completed();
                        if (!$profiles) {
                            return $this->redirect(['/profile/create']);
                        } else {
                            return $this->redirect(['/post/list']);
                        }
                    } else {
                        return $this->goHome();
                    }
                }
            }
        }

        $model->password = '';
        $this->layout = "main_login";
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            $isSignup = $model->usersignup();
            if ($isSignup) {
                $referralCode = Yii::$app->request->get("referral-code");
                if (!empty($referralCode)) {
                    $referrer = UserReferralCodes::find()->with(['referrer'])->where(['referral_code' => $referralCode])->one();

                    $referral = new Referrals();
                    $referral->referrer_id = $referrer->user_id;
                    $referral->referred_user_id = Yii::$app->session->get("loggedUserId");
                    $referral->referral_code = $referralCode;
                    $referral->referral_status = "Pending";
                    $referral->save();
                }

                Yii::$app->session->setFlash('success', 'Thank you for signing up. Please check your email for verification link.');
                return $this->redirect(['/login']);
            } else {
                Yii::$app->session->setFlash('error', 'There was an error during signup. Please try again.');
            }
        }
        $this->layout = "main_login";
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->session->setFlash('success', 'Logout Successfully.');

        return $this->goHome();
    }


    public function actionSwitchRole($role)
    {
        if (Yii::$app->user->identity->role != 'superadmin') {
            if ($role === 'tutor') {
                //Yii::$app->session->set('role', 'tutor');
                Yii::$app->user->identity->role = 'tutor';
                $model = Yii::$app->user->identity;
                $model->role = 'tutor';
                $model->save(false);

                Yii::$app->session->setFlash('success', 'Account Switched To Tutor Successfully');



                return $this->redirect(['/tutor/dashboard']);
            } elseif ($role === 'student') {
                //Yii::$app->session->set('role', 'student');

                Yii::$app->user->identity->role = 'student';

                $model = Yii::$app->user->identity;
                $model->role = 'student';
                $model->save(false);   // saves without validation

                Yii::$app->session->setFlash('success', 'Account Switched To Student Successfully');


                //    echo '<pre>';
                //     print_r( Yii::$app->user->identity);die;


                return $this->redirect(['/post/list']);
            }
        } else {

            return $this->redirect(['/site/index']);
        }
    }


    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        $this->layout = "main_login";
        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new PasswordResetForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');
            return $this->goHome();
        }

        $this->layout = "main_login";
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionVerification()
    {
        $user = Yii::$app->user->identity;

        $verification = Yii::$app->user->identity->verification;

        if ($verification == 1) {
            return $this->redirect(['/']);
        }

        $this->layout = "verify_layout";
        return $this->render('verification', [
            'user' => $user,
        ]);
    }

    public function actionTest()
    {
        $otp = rand(100000, 999999);
        //TwilioHelper::send_sms_verify($user);
        $r = TwilioHelper::send_whatsapp_verify("+923405870886", $otp);
        echo '<pre>';
        print_r($r);
        echo '</pre>';
        echo "Send";
    }
    public function actionResendVerification()
    {
        $user = Yii::$app->user->identity;
        if (!$user) {
            return $this->asJson(['success' => false, 'message' => 'User not logged in.']);
        }
        $userVerification = UserVerifications::find()->where(['user_id' => $user->id])->orderBy(['created_at' => SORT_DESC])->one();
        if (!$userVerification) {
            return $this->asJson(['success' => false, 'message' => 'No verification record found.']);
        }

        $token = Yii::$app->security->generateRandomString();
        $emailVerificationLink = Helper::baseUrl("/verify?token={$token}");

        $userVerification = new UserVerifications();
        $userVerification->user_id = $user->id;
        $userVerification->email = $user->email;
        $userVerification->email_verification_link = $emailVerificationLink;
        $userVerification->email_verification_expires = date('Y-m-d H:i:s', strtotime('+24 hours'));
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
            'Your verification link for ' . $site_setting->site_name . ' ' . date("F d,y H:m"),
            'mail/verification-email.php',
            [
                'username' => $user->username,
                'verificationLink' => $emailVerificationLink,
            ]
        );

        if (!$isSend['status']) {
            return $this->asJson(['success' => false, 'message' => 'Failed to send verification email.', 'mail' => $isSend]);
        } else {

            return $this->asJson(['success' => true, 'message' => 'Verification email has been resent.', 'erros' => $isSend['errors']]);
        }
    }

    public function actionVerify()
    {
        // get url link
        $verificationUrl = Yii::$app->request->getAbsoluteUrl();
        $userToVerify = UserVerifications::find()
            ->where(['email_verification_link' => $verificationUrl])
            ->orderBy(['created_at' => SORT_DESC])
            ->one();
        if ($userToVerify) {
            if ($userToVerify->email_verification_expires < date('Y-m-d H:i:s')) {
                Yii::$app->session->setFlash('error', 'Verification link has expired.');
                return $this->redirect(['/login']);
            }

            $user = User::findOne($userToVerify->user_id);

            $userToVerify->email_verified = 1;
            $attempts = $userToVerify->email_verification_attempts + 1;
            $userToVerify->email_verification_attempts = $attempts;
            $userToVerify->save();

            $isReffered = Referrals::find()->where(['referred_user_id' => $user->id])->one();
            if ($isReffered) {
                $isReffered->referral_status = "Verified";
                $isReffered->save();

                $coins = 50;
                Wallet::Credit($isReffered->referrer_id, $coins, "recieved", "Recieved on referral approch.");
            }

            if ($user instanceof \yii\web\IdentityInterface) {
                $user->verification = 1;
                $user->save();
                Yii::$app->user->login($user);
                $userRole = Yii::$app->user->identity->role;

                if ($userRole == 'tutor') {

                    $profiles = Profiles::profile_completed();
                    if (!$profiles) {
                        return $this->redirect(['/tutor/profile']);
                    } else {
                        return $this->redirect(['/tutor/dashboard']);
                    }

                    return $this->redirect(['/tutor/dashboard']);
                } elseif ($userRole == 'student') {
                    $profiles = Profiles::profile_completed();
                    if (!$profiles) {
                        return $this->redirect(['/profile/create']);
                    } else {
                        return $this->redirect(['/post/list']);
                    }
                } else {
                    return $this->goHome();
                }
            }
        } else {
            echo 'no link found';
        }
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        try {
            // Fetch real statistics from the database
            $stats = [
                'tutors' => User::find()->where(['role' => 'tutor', 'active' => 1, 'deleted' => 0])->count(),
                'students' => User::find()->where(['role' => 'student', 'active' => 1, 'deleted' => 0])->count(),
                'subjects' => \app\models\TeacherSubjects::find()->select('subject')->distinct()->count(),
            ];

            // Ensure minimum values for display and handle potential null/0 values
            $stats['tutors'] = max($stats['tutors'] ?: 0, 500);
            $stats['students'] = max($stats['students'] ?: 0, 1000);
            $stats['subjects'] = max($stats['subjects'] ?: 0, 50);
        } catch (\Exception $e) {
            // Fallback to default values if database queries fail
            Yii::error('Failed to fetch statistics for About page: ' . $e->getMessage());
            $stats = [
                'tutors' => 500,
                'students' => 1000,
                'subjects' => 50,
            ];
        }

        return $this->render('about', [
            'stats' => $stats
        ]);
    }

    public function actionFaq()
    {


        $this->layout = "main";
        return $this->render('faq', []);
    }

    public function actionPrivacyPolicy()
    {
        $this->layout = "main";
        return $this->render('privacy-policy', []);
    }

    public function actionTerms()
    {
        $this->layout = "main";
        return $this->render('terms', []);
    }

    public function actionHelp()
    {
        $this->layout = "main";
        return $this->render('help', []);
    }



    public function actionCheckUsername($username)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $exists = User::find()->where(['username' => $username])->exists();

        $suggested = null;
        if ($exists) {
            // Suggest a new username by appending a random number
            $i = 1;
            do {
                $suggested = strtolower(trim(preg_replace('/\s+/', '_', $username  . rand(100, 999))));;
                $i++;
            } while (User::find()->where(['username' => $suggested])->exists() && $i < 10);
        }

        return [
            'exists' => $exists,
            'suggested' => $suggested
        ];
    }


    public function actionCheckVerification()
    {


        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


        try {
            // Check if user is logged in
            if (Yii::$app->user->isGuest) {
                return [
                    'verified' => false,
                    'error' => 'User not authenticated'
                ];
            }

            $userId = Yii::$app->user->id;
            $user = User::findOne($userId);

            if (!$user) {
                return [
                    'verified' => false,
                    'error' => 'User not found'
                ];
            }

            return [
                'verified' => ($user->verification == 1),
                'timestamp' => time(),
                'user_id' => $userId
            ];
        } catch (\Exception $e) {
            Yii::error('Error checking verification: ' . $e->getMessage());
            return [
                'verified' => false,
                'error' => 'Server error checking verification status'
            ];
        }
    }

    public function actionUserDash()
    {


        $userRole = Yii::$app->user->identity->role;

        if ($userRole == 'tutor') {

            $profiles = Profiles::profile_completed();
            if (!$profiles) {
                return $this->redirect(['/tutor/profile']);
            } else {
                return $this->redirect(['/tutor/dashboard']);
            }

            return $this->redirect(['/tutor/dashboard']);
        } elseif ($userRole == 'student') {
            $profiles = Profiles::profile_completed();
            if (!$profiles) {
                return $this->redirect(['/profile/create']);
            } else {
                return $this->redirect(['/post/list']);
            }
        } else {
            return $this->goHome();
        }
    }
}
