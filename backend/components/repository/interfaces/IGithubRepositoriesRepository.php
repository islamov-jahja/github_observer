<?php


namespace app\components\repository\interfaces;


use app\githubObserver\listRepositories\domain\entity\interfaces\IGithubRepositoryEntity;
use app\githubObserver\listRepositories\domain\entity\interfaces\IGithubUserEntity;

interface IGithubRepositoriesRepository
{
    /**
     * @param string $userName
     * @return IGithubRepositoryEntity[]
    */
    public function get(?IGithubUserEntity $user): array;
    public function save(IGithubRepositoryEntity $githubRepositoryEntity): bool;
    public function getAll();
    public function deleteAll(): bool;
}