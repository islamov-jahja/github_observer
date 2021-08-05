<?php

namespace app\components\repository;
use app\githubObserver\listRepositories\domain\entity\interfaces\IGithubUserEntity;
use app\components\repository\interfaces\IGithubUserRepository;
use app\models\GithubUser;

class GithubUserMysqlDatabaseRepository implements IGithubUserRepository
{

    public function save(IGithubUserEntity $githubUserEntity): bool
    {
        $userInArray = $githubUserEntity->toArray();

        unset($userInArray['id']);
        $newUser = new GithubUser($userInArray);
        return $newUser->save();
    }

    public function delete(int $id): void
    {
        $githubUser = GithubUser::findOne(['id' => $id]);
        if ($githubUser === null) {
            return;
        }

        $githubUser->delete();
    }

    public function exists(array $filters): bool
    {
        $query = GithubUser::find();

        foreach ($filters as $filter){
            $query->andWhere($filter);
        }

        return $query->exists();
    }

    public function getAll(): array
    {
        return GithubUser::find()->all();
    }
}