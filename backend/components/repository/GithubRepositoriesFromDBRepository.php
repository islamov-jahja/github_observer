<?php


namespace app\components\repository;


use app\components\entities\interfaces\IGithubRepositoryEntity;
use app\components\entities\interfaces\IGithubUserEntity;
use app\components\repository\interfaces\IGithubRepositoriesRepository;
use app\models\GithubRepos;

class GithubRepositoriesFromDBRepository implements IGithubRepositoriesRepository
{
    /**
     * @param IGithubUserEntity|null $user
     * @return IGithubRepositoryEntity[]
     */
    public function get(?IGithubUserEntity $user): array
    {
        return GithubRepos::find()->limit(10)->all();
    }

    public function save(IGithubRepositoryEntity $githubRepositoryEntity): bool
    {
        $githubRepositoryInArray = $githubRepositoryEntity->toArray();
        unset($githubRepositoryInArray['id']);

        $githubRepository = new GithubRepos($githubRepositoryInArray);
        return $githubRepository->save();
    }

    public function deleteAll(): bool
    {
        $githubRepositories = GithubRepos::find()->all();
        foreach ($githubRepositories as $githubRepository){
            $githubRepository->delete();
        }
        return true;
    }

    public function getAll()
    {
        return GithubRepos::find()->all();
    }
}