<?php

namespace app\models;

use app\components\entities\interfaces\IGithubUserEntity;
use app\components\repository\interfaces\IGithubUserRepository;
use Yii;

/**
 * This is the model class for table "github_user".
 *
 * @property int $id Уникальный идентификатор пользователя
 * @property string $name имя пользотвателя
 *
 * @property GithubRepos[] $githubRepos
 */
class GithubUser extends \yii\db\ActiveRecord implements IGithubUserEntity
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'github_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[GithubRepos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGithubRepos()
    {
        return $this->hasMany(GithubRepos::className(), ['github_user_id' => 'id']);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setRepositories(array $repositories)
    {
        $this->githubRepos = $repositories;
    }

    public function getRepositories(): array
    {
        return $this->githubRepos;
    }
}
