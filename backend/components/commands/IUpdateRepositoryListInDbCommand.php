<?php
namespace app\components\commands;

use app\components\commands\interfaces\IUpdateRepositoryListCommand;
use app\components\entities\interfaces\IGithubRepositoryEntity;
use app\components\repository\GithubRepositoriesFromApiRepository;
use app\components\repository\GithubRepositoriesFromDBRepository;
use app\components\repository\interfaces\IGithubRepositoriesRepository;
use app\components\repository\interfaces\IGithubUserRepository;
use app\enums\DateFormat;
use app\models\GithubRepos;

class IUpdateRepositoryListInDbCommand implements IUpdateRepositoryListCommand
{
    private GithubRepositoriesFromApiRepository $apiRepositoriesRepository;
    private GithubRepositoriesFromDBRepository $dbRepositoriesRepository;
    private IGithubUserRepository $githubUserRepository;

    public function __construct(
        GithubRepositoriesFromApiRepository $apiRepositoriesRepository,
        GithubRepositoriesFromDBRepository $dbRepositoriesRepository,
        IGithubUserRepository $githubUserRepository
    )
    {
        $this->apiRepositoriesRepository = $apiRepositoriesRepository;
        $this->dbRepositoriesRepository = $dbRepositoriesRepository;
        $this->githubUserRepository = $githubUserRepository;
    }

    public function update()
    {
        $users = $this->githubUserRepository->getAll();

        /**@var $repositories GithubRepos[]*/
        $repositories = [];

        foreach ($users as $user) {
            $repositories = array_merge($repositories, $this->apiRepositoriesRepository->get($user));
        }
        $this->dbRepositoriesRepository->deleteAll();

        sort(
            $repositories,
            fn($a, $b) => strcmp($a->getUpdatedDateTime()->format(DateFormat::SERVER_DATE_FORMAT), $b->getUpdatedDateTime()->format(DateFormat::SERVER_DATE_FORMAT))
        );

        for($i = 0; $i < 10; $i++){
            $this->dbRepositoriesRepository->save($repositories[$i]);
        }
    }
}