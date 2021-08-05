<?php


namespace app\components\services\interfaces;


use app\githubObserver\listRepositories\domain\entity\interfaces\IGithubRepositoryEntity;

interface IRepositoriesProcessor
{
    /**
     * @return IGithubRepositoryEntity[]
     */
    public function getAll(): array;
}