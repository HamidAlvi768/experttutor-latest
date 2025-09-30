<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "roles".
 *
 * @property int $id
 * @property string $role_name
 * @property string|null $description
 * @property int|null $active
 * @property int|null $deleted
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Users[] $users
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_name'], 'required'],
            [['active', 'deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['role_name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
            [['role_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_name' => 'Role Name',
            'description' => 'Description',
            'active' => 'Active',
            'deleted' => 'Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['role_id' => 'id']);
    }

    public static function addDefaultRoles()
    {
        $roles = [
            ['role_name' => 'superadmin', 'description' => 'Super Administrator', 'active' => 1],
            ['role_name' => 'admin', 'description' => 'Administrator', 'active' => 1],
            ['role_name' => 'tutor', 'description' => 'Tutor', 'active' => 1],
            ['role_name' => 'student', 'description' => 'Student', 'active' => 1]
        ];

        // Use batch insert for better performance
        return Yii::$app->db->createCommand()
            ->batchInsert(self::tableName(), ['role_name', 'description', 'active'], $roles)
            ->execute();
    }
}
