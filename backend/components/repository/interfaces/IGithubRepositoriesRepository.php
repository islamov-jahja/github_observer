<?php


namespace app\components\repository\interfaces;


use app\components\entities\interfaces\IGithubRepositoryEntity;
use app\components\entities\interfaces\IGithubUserEntity;

interface IGithubRepositoriesRepository
{
    /**
     * @param string $userName
     * @return IGithubRepositoryEntity[]
    */
    public function getFor(IGithubUserEntity $user): array;
}