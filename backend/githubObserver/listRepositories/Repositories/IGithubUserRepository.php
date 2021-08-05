<?php

namespace app\components\repository\interfaces;

use app\githubObserver\listRepositories\domain\entity\interfaces\IGithubUserEntity;

interface IGithubUserRepository
{

    /**
     * @param  \app\githubObserver\listRepositories\domain\entity\interfaces\IGithubUserEntity  $githubUserEntity
     *
     * @return bool
     */
    public function save(IGithubUserEntity $githubUserEntity): bool;

    /**
     * @param  int  $id
     */
    public function delete(int $id): void;

    /**
     * @return IGithubUserEntity[]
     */
    public function getAll(): array;

    /**
     * @param  array  $filters [[id => 5], ['name' => 4]]
     *
     * @return bool
     */
    public function exists(array $filters): bool;
}