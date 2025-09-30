<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "saved_jobs".
 *
 * @property int $id
 * @property int $tutor_id
 * @property int $job_id
 * @property string $created_at
 */
class SavedJobs extends ActiveRecord
{
    public static function tableName()
    {
        return 'saved_jobs';
    }
    public function rules()
    {
        return [
            [['tutor_id', 'job_id'], 'required'],
            [['tutor_id', 'job_id'], 'integer'],
            [['created_at'], 'safe'],
            [['tutor_id', 'job_id'], 'unique', 'targetAttribute' => ['tutor_id', 'job_id']],
        ];
    }
} 