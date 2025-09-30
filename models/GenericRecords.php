<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "generic_records".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $type
 * @property string $title
 * @property string $description
 * @property int $active
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class GenericRecords extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'generic_records';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'type',  'description', 'created_by', 'created_at', 'updated_by', 'updated_at'], 'safe'],
            [['parent_id', 'active', 'created_by', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [[ 'title', 'active' ], 'required'],
            [['type'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 355],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'type' => 'Type',
            'title' => 'Title',
            'description' => 'Description',
            'active' => 'Active',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
