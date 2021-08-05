<?php


namespace app\components\services;


use app\githubObserver\listRepositories\domain\entity\interfaces\IGithubRepositoryEntity;
use app\components\repository\interfaces\IGithubRepositoriesRepository;
use app\components\services\interfaces\IRepositoriesProcessor;

class RepositoryProcessor implements IRepositoriesProcessor
{
    private IGithubRepositoriesRepository $githubRepositoriesRepository;
    public function __construct(IGithubRepositoriesRepository $githubRepositoriesRepository)
    {
        $this->githubRepositoriesRepository = $githubRepositoriesRepository;
    }

    public function getAll(): array
    {
        return $this->githubRepositoriesRepository->getAll();
    }
}