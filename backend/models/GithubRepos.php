<?php

namespace app\models;

use app\components\commands\interfaces\IUpdateRepositoryListCommand;
use app\components\entities\interfaces\IGithubRepositoryEntity;
use app\components\entities\interfaces\IGithubUserEntity;
use app\enums\DateFormat;
use Yii;

/**
 * This is the model class for table "github_repos".
 *
 * @property int $id Уникальный идентификатор репозитория
 * @property int|null $github_user_id ссылка на пользователя
 * @property string|null $name название репозитория
 * @property string $updated_at последняя дата обновления
 *
 * @property GithubUser $githubUser
 */
class GithubRepos extends \yii\db\ActiveRecord implements IGithubRepositoryEntity
{
    public IUpdateRepositoryListCommand $updateRepositoryListCommand;

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->updateRepositoryListCommand !== null){
            $this->updateRepositoryListCommand->update();
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'github_repos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['github_user_id'], 'integer'],
            [['updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['github_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => GithubUser::className(), 'targetAttribute' => ['github_user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'github_user_id' => 'Github User ID',
            'name' => 'Name',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[GithubUser]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGithubUser()
    {
        return $this->hasOne(GithubUser::className(), ['id' => 'github_user_id']);
    }

    public function getUpdatedDateTime(): \DateTime
    {
        return new \DateTime($this->updated_at);
    }

    public function setUpdateDateTime(\DateTime $updatedDatetime)
    {
        $this->updated_at = $updatedDatetime->format(DateFormat::SERVER_DATE_FORMAT);
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

    public function getGithubUserEntity(): IGithubUserEntity
    {
        return $this->githubUser;
    }

    public function setGithubUserEntity(IGithubUserEntity $githubUserRepository)
    {
        $this->githubUser = $githubUserRepository;
    }
}
