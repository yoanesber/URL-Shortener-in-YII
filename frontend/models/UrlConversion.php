<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "url_conversions".
 *
 * @property int $id
 * @property string $url_original
 * @property string $url_conversion
 * @property string $createdAt
 * @property int $createdBy
 */
class UrlConversion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'url_conversions';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url_original' => 'URL Original',
            'url_conversion' => 'URL Conversion',
            'createdAt' => 'Created At',
            'createdBy' => 'Created By',
        ];
    }
}