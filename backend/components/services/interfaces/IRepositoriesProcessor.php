<?php


namespace app\components\services\interfaces;


use app\components\entities\interfaces\IGithubRepositoryEntity;

interface IRepositoriesProcessor
{
    /**
     * @return IGithubRepositoryEntity[]
     */
    public function getAll(): array;
}