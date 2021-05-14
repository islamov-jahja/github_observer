<?php


namespace app\components\repository;


use app\components\entities\interfaces\IGithubRepositoryEntity;
use app\components\entities\interfaces\IGithubUserEntity;
use app\components\repository\interfaces\IGithubRepositoriesRepository;
use app\models\GithubRepos;
use yii\httpclient\Client;

class GithubRepositoriesFromApiRepository implements IGithubRepositoriesRepository
{
    private Client $client;
    public const GITHUB_API_URL = "https://api.github.com";

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param IGithubUserEntity|null $user
     * @return GithubRepos[]
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function get(?IGithubUserEntity $user): array
    {
        $repositories = [];

        if ($user === null){
            return $repositories;
        }

        $response = $this->client->baseUrl = $this->client
            ->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl("users/{$user->getName()}/repos")
            ->send();

        foreach ($response->data as $item){
            $githubRepos = new GithubRepos([
                'name' => $item['name'] ?? null,
                'github_user_id' => $user->getId(),
            ]);

            $githubRepos->setUpdateDateTime($item['updated_at']);

            $repositories[] = $githubRepos;
        }

        return $repositories;
    }

    public function save(IGithubRepositoryEntity $githubRepositoryEntity): bool
    {
        return false;
    }

    public function deleteAll(): bool
    {
        return false;
    }
}