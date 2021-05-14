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
     * @return GithubRepos[]
    */
    public function getFor(IGithubUserEntity $user): array
    {
        $repositories = [];

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
}