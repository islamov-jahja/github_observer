<?php

namespace app\models;

use app\components\entities\interfaces\IGithubRepositoryEntity;
use app\components\entities\interfaces\IGithubUserEntity;
use app\enums\DateFormat;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "github_repos".
 *
 * @property int         $id             Уникальный идентификатор репозитория
 * @property int|null    $github_user_id ссылка на пользователя
 * @property string|null $name           название репозитория
 * @property string      $link           ;
 * @property string      $updated_at     последняя дата обновления
 *
 * @property GithubUser  $githubUser
 */
class GithubRepos extends ActiveRecord implements IGithubRepositoryEntity
{

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'github_repos';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['github_user_id'], 'integer'],
            [['updated_at'], 'safe'],
            [['name', 'link'], 'string', 'max' => 255],
            [
                ['github_user_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => GithubUser::className(),
                'targetAttribute' => ['github_user_id' => 'id'],
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id'             => 'ID',
            'github_user_id' => 'Github User ID',
            'name'           => 'Name',
            'updated_at'     => 'Updated At',
            'link'           => 'Ссылка на репозиторий',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGithubUser(): ActiveQuery
    {
        return $this->hasOne(GithubUser::className(), ['id' => 'github_user_id']);
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedDateTime(): \DateTime
    {
        return \DateTime::createFromFormat(DateFormat::SERVER_DATE_FORMAT, $this->updated_at);
    }

    public function setUpdateDateTime(\DateTime $updatedDatetime): void
    {
        $this->updated_at = $updatedDatetime->format(DateFormat::SERVER_DATE_FORMAT);
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

    public function getGithubUserEntity(): IGithubUserEntity
    {
        return $this->githubUser;
    }

    public function setGithubUserEntity(IGithubUserEntity $githubUserRepository): void
    {
        $this->githubUser = $githubUserRepository;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    public function toArray(): array
    {
        return [];
    }
}
