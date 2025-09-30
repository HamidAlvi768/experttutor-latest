<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $role
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string|null $user_status
 * @property int|null $verification
 * @property int|null $active
 * @property int|null $deleted
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $authKey
 * @property string|null $accessToken
 *
 * @property Profiles[] $profiles
 * @property UserVerifications[] $userVerifications
 * @property StudentJobPosts[] $studentJobPosts
 * @property ChatMessages[] $sentMessages
 * @property ChatMessages[] $receivedMessages
 * @property JobApplications[] $jobApplications
 * @property Reviews[] $givenReviews
 * @property UserReferralCodes[] $userReferralCodes
 * @property UserLeaveLog[] $userLeaveLogs
 */
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
        public $last_seen; // custom attribute for joined data

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    // public function init()
    // {
    //     parent::init();
        
    //     // Attach event handler for beforeDelete
    //     $this->on(self::EVENT_BEFORE_DELETE, [$this, 'beforeDeleteHandler']);
    // }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role', 'username', 'email', 'password_hash'], 'required'],
            [['user_status'], 'string'],
            [['verification', 'active', 'deleted'], 'integer'],
            [['created_at', 'updated_at','user_status'], 'safe'],
            [['role'], 'string', 'max' => 20],
            [['username'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 150],
            [['password_hash'], 'string', 'max' => 60],
            [['authKey', 'accessToken', 'password_reset_token'], 'string', 'max' => 255],
            // [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role' => 'Role',
            'username' => 'Username',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'user_status' => 'User Status',
            'verification' => 'Verification',
            'active' => 'Active',
            'deleted' => 'Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'password_reset_token' => 'Password Reset Token',
        ];
    }

    /**
     * Gets query for [[Profiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profiles::class, ['user_id' => 'id']);
    }

    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['review_to' => 'id']);
    }
    public function getSubjects()
    {
        return $this->hasMany(TeacherSubjects::class, ['teacher_id' => 'id']);
    }
    public function getEducations()
    {
        return $this->hasMany(TeacherEducation::class, ['teacher_id' => 'id']);
    }
    public function getExperiences()
    {
        return $this->hasMany(TeacherProfessionalExperience::class, ['teacher_id' => 'id']);
    }
    public function getDetails()
    {
        return $this->hasOne(TeacherTeachingDetails::class, ['teacher_id' => 'id']);
    }
    public function getDescription()
    {
        return $this->hasOne(TeacherJobDescriptions::class, ['teacher_id' => 'id']);
    }

    public function getProfile()
    {
        return $this->hasOne(Profiles::class, ['user_id' => 'id']);
    }

    public function getWallet()
    {
        return $this->hasOne(Wallets::class, ['user_id' => 'id']);
    }

    public function getRole()
    {
        return $this->hasOne(Roles::class, ['id' => 'role_id']);
    }

    public function getUserVerifications()
    {
        return $this->hasMany(UserVerifications::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[StudentJobPosts]].
     * Virtual relation for student job posts.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentJobPosts()
    {
        return $this->hasMany(StudentJobPosts::class, ['posted_by' => 'id']);
    }

    /**
     * Gets query for [[ChatMessages]] where user is sender.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSentMessages()
    {
        return $this->hasMany(ChatMessages::class, ['sender_id' => 'id']);
    }

    /**
     * Gets query for [[ChatMessages]] where user is receiver.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReceivedMessages()
    {
        return $this->hasMany(ChatMessages::class, ['receiver_id' => 'id']);
    }

    /**
     * Gets query for [[JobApplications]] where user is applicant.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJobApplications()
    {
        return $this->hasMany(JobApplications::class, ['applicant_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]] where user is the reviewer.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGivenReviews()
    {
        return $this->hasMany(Reviews::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserReferralCodes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserReferralCodes()
    {
        return $this->hasMany(UserReferralCodes::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserLeaveLog]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserLeaveLogs()
    {
        return $this->hasMany(UserLeaveLog::class, ['user_id' => 'id']);
    }

    /**
     * Event handler for beforeDelete.
     * Deletes related records when a user is deleted.
     */
   // public function beforeDeleteHandler($event)
   // {

   public function beforeDelete()
{
    if (!parent::beforeDelete()) {
        return false;
    }

        
        // Delete chat messages (both sent and received)
        $sentMessages = $this->sentMessages;
        foreach ($sentMessages as $message) {
            $message->delete();
        }
        
        $receivedMessages = $this->receivedMessages;
        foreach ($receivedMessages as $message) {
            $message->delete();
        }

        // Delete job applications
        $jobApplications = $this->jobApplications;
        foreach ($jobApplications as $application) {
            $application->delete();
        }

        // Delete reviews given by this user
        $givenReviews = $this->givenReviews;
        foreach ($givenReviews as $review) {
            $review->delete();
        }

        // Delete user referral codes
        $referralCodes = $this->userReferralCodes;
        foreach ($referralCodes as $code) {
            $code->delete();
        }

        // Delete user leave logs
        $leaveLogs = $this->userLeaveLogs;
        foreach ($leaveLogs as $log) {
            $log->delete();
        }

        // Role-specific cleanup
        
            // Delete student job posts
            $posts = $this->studentJobPosts;
            foreach ($posts as $post) {
                $post->delete();
            }
         
            // Delete teacher-related records
            $subjects = $this->subjects;
            foreach ($subjects as $subject) {
                $subject->delete();
            }

            $educations = $this->educations;
            foreach ($educations as $education) {
                $education->delete();
            }

            $experiences = $this->experiences;
            foreach ($experiences as $experience) {
                $experience->delete();
            }

            $details = $this->details;
            if ($details) {
                $details->delete();
            }

            $description = $this->description;
            if ($description) {
                $description->delete();
            }
        

        // Delete profile
        $profile = $this->profile;
        if ($profile) {
            $profile->delete();
        }

        // Delete wallet
        $wallet = $this->wallet;
        if ($wallet) {
            $wallet->delete();
        }

        // Delete user verifications
        $verifications = $this->userVerifications;
        foreach ($verifications as $verification) {
            $verification->delete();
        }
    }




    public static function findIdentity($id)
    {
        return static::findOne($id);
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }


    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public static function getusername($id)
    {
            return User::findOne(['id'=>$id])?->username;

    }
       public static function getuserrole($id)
    {
            return User::findOne(['id'=>$id])?->role;

    }
    public function getMemberships()
    {
        return $this->hasMany(Membership::class, ['user_id' => 'id']);
    }

    /**
     * Gets the active membership for this user (most recent valid subscription).
     * @return \yii\db\ActiveQuery
     */
    public function getActiveMembership()
    {
        return $this->hasOne(Membership::class, ['user_id' => 'id'])
            ->andWhere(['>=', 'expiry_date', date('Y-m-d H:i:s')])
            ->andWhere(['cancelled_from_next_month' => 0])
            ->orderBy(['expiry_date' => SORT_DESC])
            ->limit(1);
    }

    public function getId()
    {
        return $this->id;
    }


    public function getAuthKey()
    {
        return $this->authKey;
    }


    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public static function createAdmin()
    {
        $admin = new self();
        $admin->username = 'admin';
        $admin->email = 'admin@gmail.com';
        $admin->password_hash = Yii::$app->security->generatePasswordHash('12345678');
        $admin->role = 'superadmin';
        $admin->verification = 1;
        $admin->active = 1;
        $admin->deleted = 0;
        $admin->authKey = Yii::$app->security->generateRandomString();
        $admin->accessToken = Yii::$app->security->generateRandomString();
        $admin->save();
        return $admin;
    }
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }
    public function generateAccessToken()
    {
        $this->accessToken = Yii::$app->security->generateRandomString();
    }
    public function setRole($rolename)
    {
        $this->role = $rolename; // Assuming 2 is user role
    }

    /**
     * Generates password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'active' => 1,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr(strrchr($token, '_'), 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'] ?? 3600;
        return $timestamp + $expire >= time();
    }

    public static function generateUniqueSlug($username)
{
    // 1. Convert to a clean slug (e.g., "John Doe" → "john-doe")
    $baseSlug = Inflector::slug($username);

    $slug = $baseSlug;
    $i = rand(1, 1000);

    // 2. Loop until we find a slug that doesn't exist
    while (User::find()->where(['user_slug' => $slug])->exists()) {
        $slug = $baseSlug + $i;
        $i++;
    }

    return $slug;
}



}
