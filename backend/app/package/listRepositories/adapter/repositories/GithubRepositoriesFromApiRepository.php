<?php

namespace app\components\repository;

use app\githubObserver\common\enums\DateFormat;
use app\githubObserver\listRepositories\domain\entity\interfaces\IGithubRepositoryEntity;
use app\githubObserver\listRepositories\domain\entity\interfaces\IGithubUserEntity;
use app\components\repository\interfaces\IGithubRepositoriesRepository;
use app\models\GithubRepos;
use yii\httpclient\Client;

class GithubRepositoriesFromApiRepository implements IGithubRepositoriesRepository
{

    public const GITHUB_API_URL = "https://api.github.com";

    /** @var \yii\httpclient\Client */
    private Client $client;

    /**
     * @param  \yii\httpclient\Client  $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get(?IGithubUserEntity $user): array
    {
        $repositories = [];

        if ($user === null) {
            return $repositories;
        }

        $url      = self::GITHUB_API_URL . "/users/{$user->getName()}/repos";
        $response = $this->client
            ->get($url)
            ->addHeaders(['User-Agent' => 'Personal-Computer'])
            ->setFormat(Client::FORMAT_JSON)
            ->send();

        return array_map(
            fn(array $item): GithubRepos => new GithubRepos(
                [
                    'name'           => $item['name'] ?? null,
                    'github_user_id' => $user->getId(),
                    'link'           => $item['html_url'],
                    'updated_at'     => (new \DateTime($item['updated_at']))->format(DateFormat::SERVER_DATE_FORMAT),
                ]
            ),
            $response->data
        );
    }

    public function save(IGithubRepositoryEntity $githubRepositoryEntity): bool
    {
        return false;
    }

    public function deleteAll(): bool
    {
        return false;
    }

    public function getAll(): array
    {
        return [];
    }
}