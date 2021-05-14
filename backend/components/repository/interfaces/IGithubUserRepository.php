<?php

namespace app\components\repository\interfaces;

use app\components\entities\interfaces\IGithubUserEntity;

interface IGithubUserRepository
{
    public function add(IGithubUserEntity $githubUserEntity);
    public function delete(int $id);

    /**
     * @param array $filters [[id => 5], ['name' => 4]]
    */
    public function exists(array $filters): bool;
}