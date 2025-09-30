<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_referral_codes".
 *
 * @property int $id
 * @property int $user_id
 * @property string $referral_code
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class UserReferralCodes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_referral_codes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'referral_code'], 'required'],
            [['user_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['referral_code'], 'string', 'max' => 100],
            [['referral_code'], 'unique'],
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
            'referral_code' => 'Referral Code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserReferralCodesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserReferralCodesQuery(get_called_class());
    }
    public function getReferrer()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
