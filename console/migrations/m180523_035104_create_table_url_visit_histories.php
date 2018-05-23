<?php

use yii\db\Migration;

/**
 * Class m180523_035104_create_table_url_visit_histories
 */
class m180523_035104_create_table_url_visit_histories extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('url_visit_histories', [
            'id'        => $this->primaryKey(),
            'ip_address' => $this->string()->notNull(),
            'phone_number' => $this->string(),
            'url_id' => $this->integer()->notNull(),
            'createdAt' => $this->dateTime()->notNull()->defaultValue(date('Y-m-d H:i:s')),
            'createdBy' => $this->integer()->notNull()->defaultValue(1)
        ], $tableOptions);

        $this->addForeignKey(
            'fk_url_visit_histories_url_conversions',
            'url_visit_histories',
            'url_id',
            'url_conversions',
            'id',
            'NO ACTION'
        );
    }

    public function down()
    {
        echo "m180523_035104_create_table_url_visit_histories cannot be reverted.\n";

        return false;
    }
}
