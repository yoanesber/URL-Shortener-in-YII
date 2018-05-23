<?php

use yii\db\Migration;

/**
 * Class m180523_034511_create_table_url_convertions
 */
class m180523_034511_create_table_url_conversions extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('url_conversions', [
            'id'        => $this->primaryKey(),
            'url_original' => $this->text(),
            'url_conversion' => $this->text(),
            'createdAt' => $this->dateTime()->notNull()->defaultValue(date('Y-m-d H:i:s')),
            'createdBy' => $this->integer()->notNull()->defaultValue(1)
        ], $tableOptions);

        $this->addForeignKey(
            'fk_url_conversions_user',
            'url_conversions',
            'createdBy',
            'user',
            'id',
            'NO ACTION'
        );
    }

    public function down()
    {
        echo "m180523_034511_create_table_url_conversions cannot be reverted.\n";

        return false;
    }
}
