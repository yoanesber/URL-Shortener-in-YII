<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "todolist".
 *
 * @property int $id
 * @property string $task_name
 * @property string $task_desc
 * @property int $status_id
 * @property string $createdAt
 * @property int $createdBy
 * @property string $updatedAt
 * @property int $updatedBy
 *
 * @property TodolistStatus $status
 */
class Todolist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'todolist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_name', 'task_desc', 'task_start_date'], 'required'],
            [['task_desc'], 'string'],
            [['status_id', 'createdBy', 'updatedBy'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['task_name'], 'string', 'max' => 255],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => TodolistStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_name' => 'Task Name',
            'task_desc' => 'Task Desc',
            'task_start_date' => 'Start Date',
            'task_end_date' => 'End Date',
            'task_place' => 'Location',
            'status_id' => 'Status ID',
            'createdAt' => 'Created At',
            'createdBy' => 'Created By',
            'updatedAt' => 'Updated At',
            'updatedBy' => 'Updated By',
        ];
    }
}
