<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "membership".
 *
 * @property int $id
 * @property int $user_id
 * @property int $premium_coins
 * @property string $memb_expiry
 * @property tinyint $auto_renew
 * @property tinyint $cancelled_from_next_month
 * @property int $rank
 * @property string $location
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string $created_at
 * @property string $updated_at
 * @property int $discount
 *
 * @property User $user
 */
class Membership extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'membership';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'premium_coins', 'location'], 'required'],
            [['user_id', 'premium_coins', 'rank', 'created_by', 'updated_by', 'discount', 'auto_renew', 'cancelled_from_next_month'], 'integer'],
            [['memb_expiry', 'created_at', 'updated_at'], 'safe'],
            [['location'], 'string', 'max' => 255],
            
            // Ensure non-negative values
            [['user_id', 'premium_coins', 'rank'], 'integer', 'min' => 0, 'message' => 'Value must be non-negative.'],
            [['discount'], 'integer', 'min' => 0, 'max' => 100, 'message' => 'Discount must be between 0 and 100 percent.'],
            [['auto_renew', 'cancelled_from_next_month'], 'boolean'],
            
            // Ensure created_by and updated_by are non-negative if provided
            [['created_by', 'updated_by'], 'integer', 'min' => 0],
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
            'premium_coins' => 'Premium Coins',
            'memb_expiry' => 'Membership Expiry',
            'auto_renew' => 'Auto Renew',
            'cancelled_from_next_month' => 'Cancelled From Next Month',
            'rank' => 'Rank',
            'location' => 'Location',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'discount' => 'Discount',
        ];
    }

    /**
     * Get the related User.
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Get total active membership coins for a user (sum across unexpired purchases)
     * @param int $userId
     * @return int
     */
    public static function getTotalActiveCoins($userId)
    {
        return self::find()
            ->select(['SUM(premium_coins)'])
            ->where(['user_id' => $userId])
            ->andWhere(['>', 'memb_expiry', date('Y-m-d H:i:s')])
            ->scalar() ?? 0;
    }

    /**
     * Check if user has active membership (any unexpired purchase)
     * @param int $userId
     * @return bool
     */
    public static function hasActiveMembership($userId)
    {
        return self::find()
            ->where(['user_id' => $userId])
            ->andWhere(['>', 'memb_expiry', date('Y-m-d H:i:s')])
            ->exists();
    }


    public static function getTotalRenewal($userId)
    {
       return self::find()
            ->select(['SUM(premium_coins)'])
            ->where(['user_id' => $userId])
            ->andWhere(['auto_renew'=> 1])
            ->scalar() ?? 0;
    }


    /**
     * Get user's memberships (for list view, sorted by expiry)
     * @param int $userId
     * @return array
     */
    public static function getUserMemberships($userId)
    {
        return self::find()
            ->where(['user_id' => $userId])
            ->orderBy(['memb_expiry' => SORT_DESC])
            ->all();
    }
}