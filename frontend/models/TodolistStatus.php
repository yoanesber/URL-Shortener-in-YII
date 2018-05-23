<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "todolist_status".
 *
 * @property int $id
 * @property string $status_name
 * @property string $status_desc
 *
 * @property Todolist[] $todolists
 */
class TodolistStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'todolist_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_name'], 'required'],
            [['status_desc'], 'string'],
            [['status_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_name' => 'Status Name',
            'status_desc' => 'Status Desc',
        ];
    }
}
