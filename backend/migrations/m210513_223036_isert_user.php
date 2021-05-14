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
        $this->createTable('github_user', [
            'id' => $this->primaryKey()->comment('Уникальный идентификатор пользователя'),
            'name' => $this->string()->notNull()->comment('имя пользотвателя')
        ]);

        $this->createTable('github_repos', [
            'id' => $this->primaryKey()->comment('Уникальный идентификатор репозитория'),
            'github_user_id' => $this->integer()->comment('ссылка на пользователя'),
            'name' => $this->string()->comment('название репозитория'),
            'updated_at' => $this->timestamp()->notNull()->comment('последняя дата обновления')
        ]);

        $this->addForeignKey(
            'fk-github_repos-github_user',
            'github_repos',
            'github_user_id',
            'github_user',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210513_223036_isert_user cannot be reverted.\n";

        return false;
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
