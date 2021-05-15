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

class UpdateRepositoryListInDbCommand implements IUpdateRepositoryListCommand
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
            $newRepositories = $this->apiRepositoriesRepository->get($user);
            if (!empty($newRepositories)) {
                $repositories = array_merge($repositories, $newRepositories);
            }
        }
        $this->dbRepositoriesRepository->deleteAll();

        usort($repositories, function(GithubRepos $a, GithubRepos $b){
            if ($a->getUpdatedDateTime() == $b->getUpdatedDateTime()) {
                return 0;
            }
            return ($a->getUpdatedDateTime() < $b->getUpdatedDateTime()) ? 1 : -1;
        });

        if (!empty($repositories)) {
            $countOfRepos = count($repositories) > 10 ? 10 : count($repositories);
            for ($i = 0; $i < $countOfRepos; $i++) {
                $this->dbRepositoriesRepository->save($repositories[$i]);
            }
        }
    }
}