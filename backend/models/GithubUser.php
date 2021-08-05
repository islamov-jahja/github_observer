<?php

namespace app\models;

use app\components\entities\interfaces\IGithubUserEntity;
use app\components\repository\GithubRepositoriesFromApiRepository;

/**
 * This is the model class for table "github_user".
 *
 * @property int           $id   Уникальный идентификатор пользователя
 * @property string        $name имя пользотвателя
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
            [['name'], 'unique', 'message' => 'Такой пользователь уже был добавлен'],
            [
                ['name'],
                function ($attribute) {
                    /**@var $client Client */
                    $client = \Yii::$container->get(Client::className());

                    $url = GithubRepositoriesFromApiRepository::GITHUB_API_URL . "/users/{$this->getName()}";
                    try {
                        $response = $client
                            ->get($url)
                            ->addHeaders(
                                [
                                    'User-Agent'    => 'My_computer',
                                    'Authorization' => "token " . \Yii::$app->params['token'],
                                ]
                            )
                            ->send();

                        if ($response->getStatusCode() != 200) {
                            $this->addError($attribute, 'Данного пользователя Github не сущесвует');
                        }
                    } catch (\Exception $exception) {
                        $this->addError($attribute, 'Некоррктные данные');
                    }
                },
            ],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'   => 'ID',
            'name' => 'Name',
        ];
    }

    public function getGithubRepos()
    {
        return $this->hasMany(GithubRepos::class, ['github_user_id' => 'id']);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setRepositories(array $repositories): void
    {
        $this->githubRepos = $repositories;
    }

    public function getRepositories(): array
    {
        return $this->githubRepos;
    }
}
