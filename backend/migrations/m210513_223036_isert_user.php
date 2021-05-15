<?php

use yii\db\Migration;

/**
 * Class m210513_223036_isert_user
 */
class m210513_223036_isert_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci';
        }

        $this->createTable('github_user', [
            'id' => $this->primaryKey()->comment('Уникальный идентификатор пользователя'),
            'name' => $this->string()->notNull()->comment('имя пользотвателя')
        ], $tableOptions);

        $this->createTable('github_repos', [
            'id' => $this->primaryKey()->comment('Уникальный идентификатор репозитория'),
            'github_user_id' => $this->integer()->comment('ссылка на пользователя'),
            'name' => $this->string()->comment('название репозитория'),
            'link' => $this->string()->comment('Ссылка на репозиторий'),
            'updated_at' => $this->timestamp()->notNull()->comment('последняя дата обновления')
        ], $tableOptions);

        $this->addForeignKey(
            'fk-github_repos-github_user',
            'github_repos',
            'github_user_id',
            'github_user',
            'id',
            'cascade',
            'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('github_repos');
        $this->dropTable('github_user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210513_223036_isert_user cannot be reverted.\n";

        return false;
    }
    */
}
