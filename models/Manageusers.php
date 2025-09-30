<?php

namespace app\models;

use Yii;

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
 * @property string|null $authKey
 * @property string|null $accessToken
 * @property int|null $active
 * @property int|null $deleted
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */



class Manageusers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $plainPassword;


    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role', 'username', 'email'], 'required'],
            [['user_status'], 'string'],
            [['verification', 'active', 'deleted', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['role'], 'string', 'max' => 20],
            [['username'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 150],
            [['authKey', 'accessToken'], 'string', 'max' => 255],
            // [['username'], 'unique'],
            ['email', 'unique', 'message' => 'This email address has already been taken.'],
                     // Password rules
            ['plainPassword', 'trim'],
            ['plainPassword', 'required'],
            ['plainPassword', 'match', 'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,200}$/',
                'message' => 'Password must be at least 6 characters long and contain at least one uppercase letter, one lowercase letter, one number and one special character'],

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
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'active' => 'Active',
            'deleted' => 'Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
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
}
