<?php

namespace app\components\services\interfaces;

use app\githubObserver\listRepositories\domain\entity\interfaces\IGithubUserEntity;

interface IGithubUserProcessor
{
    public function add(IGithubUserEntity $githubUserEntity): bool;
    public function delete(int $id);

    /**@return IGithubUserEntity[]*/
    public function getAll(): array;
}