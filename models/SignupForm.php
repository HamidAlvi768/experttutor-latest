<?php

namespace app\models;

use app\components\Helper;
use app\components\Mail;
use Yii;
use yii\base\Model;
use app\models\User;

/**
 * SignupForm is the model behind the signup form.
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $role = 'student';
    public $user_status = 'unverified';

    public function rules()
    {
        return [
            // Username rules
            ['username', 'trim'],
            ['username', 'required', 'message' => 'Full Name cannot be blank.'],
            ['username', 'string', 'min' => 4, 'max' => 20],
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_ ]+$/',
 'message' => 'Username can only contain letters, numbers, underscores, and spaces'],

            //['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],

            // Email rules
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            
            // Role rules
            ['role', 'string'],
            ['role', 'required'],
            ['role', 'in', 'range' => ['student', 'tutor', 'admin', 'superadmin']],

            // Password rules
           ['password', 'trim'],
            ['password', 'required'],
            ['password', 'match', 'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,200}$/',
                'message' => 'Password must be at least 6 characters long and contain at least one uppercase letter, one lowercase letter, one number and one special character'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'password' => 'Password ',
        ];
    }

    public function usersignup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->user_slug = User::generateUniqueSlug($this->username);
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->setRole($this->role);
        $saved = $user->save();
        Yii::$app->session->set("loggedUserId", $user->id);
        
        
        if (!$saved) {
            Yii::error($user->getErrors());
            return null;
        }


      
        // $profile_model = new Profiles();

       
        // $profile_model->user_id = $user->id;
        // $profile_model->full_name = $user->username;
                               
        // $profile_model->save(false);








        $token = Yii::$app->security->generateRandomString();
        $emailVerificationLink = Helper::baseUrl("/verify?token={$token}");

        $userVerification = new UserVerifications();
        $userVerification->user_id = $user->id;
        $userVerification->email = $user->email;
        $userVerification->email_verification_link = $emailVerificationLink;
        $userVerification->email_verification_expires = date('Y-m-d H:i:s', strtotime('+24 hours'));
        $userVerification->save();

        Mail::send(
            $user->email,
            'Verify Your Email ' . date("F d,y H:m"),
            'mail/verification-email.php',
            [
                'username' => $user->username,
                'verificationLink' => $emailVerificationLink,
            ]
        );

        $userToLogin = User::findOne($user->id);
        if ($userToLogin instanceof \yii\web\IdentityInterface) {
            Yii::$app->user->login($userToLogin);
        }
        return $saved;
    }



    
}