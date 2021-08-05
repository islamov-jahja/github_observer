<?php


namespace app\components\repository;


use app\githubObserver\listRepositories\domain\entity\interfaces\IGithubRepositoryEntity;
use app\githubObserver\listRepositories\domain\entity\interfaces\IGithubUserEntity;
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

        $url = self::GITHUB_API_URL. "/users/{$user->getName()}/repos";
        $response = $this->client
            ->get($url)
            ->addHeaders(['User-Agent' => 'Personal-Computer'])
            ->setFormat(Client::FORMAT_JSON)
            ->send();

        foreach ($response->data as $item){
            $githubRepos = new GithubRepos([
                'name' => $item['name'] ?? null,
                'github_user_id' => $user->getId(),
                'link' => $item['html_url']
            ]);

            $githubRepos->setUpdateDateTime(new \DateTime($item['updated_at']));

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

    public function getAll()
    {
        return [];
    }
}