<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_verifications".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $phone_number
 * @property string|null $phone_verification_code
 * @property int|null $phone_verified
 * @property int|null $phone_verification_attempts
 * @property string|null $phone_verification_expires
 * @property string|null $email
 * @property string|null $email_verification_code
 * @property string|null $email_verification_link
 * @property int|null $email_verified
 * @property int|null $email_verification_attempts
 * @property string|null $email_verification_expires
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Users $user
 */
class UserVerifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_verifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'phone_verified', 'phone_verification_attempts', 'email_verified', 'email_verification_attempts'], 'integer'],
            [['phone_verification_expires', 'email_verification_expires', 'created_at', 'updated_at'], 'safe'],
            [['email_verification_link'], 'string'],
            [['phone_number'], 'string', 'max' => 20],
            [['phone_verification_code'], 'string', 'max' => 10],
            [['email'], 'string', 'max' => 150],
            [['email_verification_code'], 'string', 'max' => 64],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'phone_number' => 'Phone Number',
            'phone_verification_code' => 'Phone Verification Code',
            'phone_verified' => 'Phone Verified',
            'phone_verification_attempts' => 'Phone Verification Attempts',
            'phone_verification_expires' => 'Phone Verification Expires',
            'email' => 'Email',
            'email_verification_code' => 'Email Verification Code',
            'email_verification_link' => 'Email Verification Link',
            'email_verified' => 'Email Verified',
            'email_verification_attempts' => 'Email Verification Attempts',
            'email_verification_expires' => 'Email Verification Expires',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
