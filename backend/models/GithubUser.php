<?php

namespace app\models;

use app\components\entities\interfaces\IGithubUserEntity;
use app\components\repository\GithubRepositoriesFromApiRepository;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\httpclient\Client;

/**
 * This is the model class for table "github_user".
 *
 * @property int           $id   Уникальный идентификатор пользователя
 * @property string        $name имя пользотвателя
 *
 * @property GithubRepos[] $githubRepos
 */
class GithubUser extends ActiveRecord implements IGithubUserEntity
{

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'github_user';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique', 'message' => 'Такой пользователь уже был добавлен'],
            [
                ['name'],
                function ($attribute) {
                    /** @var $client \yii\httpclient\Client */
                    $client = \Yii::$container->get(Client::class);

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
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id'   => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGithubRepos(): ActiveQuery
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

    public function toArray(): array
    {
        return [];
    }
}
