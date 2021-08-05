<?php

namespace app\components\repository\interfaces;

use app\githubObserver\listRepositories\domain\entity\interfaces\IGithubRepositoryEntity;
use app\githubObserver\listRepositories\domain\entity\interfaces\IGithubUserEntity;

interface IGithubRepositoriesRepository
{

    /**
     * @param  \app\githubObserver\listRepositories\domain\entity\interfaces\IGithubUserEntity|null  $user
     *
     * @return IGithubRepositoryEntity[]
     */
    public function get(?IGithubUserEntity $user): array;

    /**
     * @param  \app\githubObserver\listRepositories\domain\entity\interfaces\IGithubRepositoryEntity  $githubRepositoryEntity
     *
     * @return bool
     */
    public function save(IGithubRepositoryEntity $githubRepositoryEntity): bool;

    /**
     * @return array
    */
    public function getAll(): array;

    /**
     * @return bool
     */
    public function deleteAll(): bool;
}