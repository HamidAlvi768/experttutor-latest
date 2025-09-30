<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "referrals".
 *
 * @property int $id
 * @property int $referrer_id
 * @property int $referred_user_id
 * @property string $referral_code
 * @property string|null $referral_status
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class Referrals extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'referrals';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['referrer_id', 'referred_user_id', 'referral_code'], 'required'],
            [['referrer_id', 'referred_user_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['referral_code'], 'string', 'max' => 100],
            [['referral_status'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'referrer_id' => 'Referrer ID',
            'referred_user_id' => 'Referred User ID',
            'referral_code' => 'Referral Code',
            'referral_status' => 'Referral Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ReferralsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReferralsQuery(get_called_class());
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'referred_user_id']);
    }
}
