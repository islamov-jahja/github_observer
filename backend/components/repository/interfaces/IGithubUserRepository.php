<?php

namespace app\components\repository\interfaces;

use app\components\entities\interfaces\IGithubUserEntity;

interface IGithubUserRepository
{
    public function save(IGithubUserEntity $githubUserEntity): bool;
    public function delete(int $id);

    /**
     * @return IGithubUserEntity[]
    */
    public function getAll();

    /**
     * @param array $filters [[id => 5], ['name' => 4]]
    */
    public function exists(array $filters): bool;
}