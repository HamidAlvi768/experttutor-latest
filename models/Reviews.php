<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property int $review_to
 * @property int|null $user_id
 * @property string $user_type
 * @property int $star_rating
 * @property string $review_text
 * @property int|null $active
 * @property int|null $deleted
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['review_to', 'user_type', 'star_rating', 'review_text'], 'required'],
            [['review_to', 'user_id', 'star_rating', 'active', 'deleted', 'created_by', 'updated_by'], 'integer'],
            [['user_type', 'review_text'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'review_to' => 'Review To',
            'user_id' => 'User ID',
            'user_type' => 'User Type',
            'star_rating' => 'Star Rating',
            'review_text' => 'Review Text',
            'active' => 'Active',
            'deleted' => 'Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     * @return ReviewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReviewsQuery(get_called_class());
    }
    
    public function getSender()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
