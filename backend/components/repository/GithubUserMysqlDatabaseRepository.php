<?php

namespace app\components\repository;
use app\components\entities\GithubUserEntity;
use app\components\entities\interfaces\IGithubUserEntity;
use app\components\repository\interfaces\IGithubUserRepository;
use app\models\GithubUser;

class GithubUserMysqlDatabaseRepository implements IGithubUserRepository
{

    public function add(IGithubUserEntity $githubUserEntity)
    {
        $userInArray = $githubUserEntity->toArray();
        unset($userInArray['id']);
        $newUser = new GithubUser($userInArray);
        $newUser->save();
    }

    public function delete(int $id)
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
}