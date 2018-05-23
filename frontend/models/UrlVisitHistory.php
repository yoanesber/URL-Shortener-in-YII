<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "url_visit_histories".
 *
 * @property int $id
 * @property string $ip_address
 * @property string $phone_number
 * @property string $url_id
 * @property string $createdAt
 * @property int $createdBy
 */
class UrlVisitHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'url_visit_histories';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip_address' => 'IP Address',
            'phone_number' => 'Phone Number',
            'url_id' => 'URL ID',
            'createdAt' => 'Created At',
            'createdBy' => 'Created By',
        ];
    }
}
