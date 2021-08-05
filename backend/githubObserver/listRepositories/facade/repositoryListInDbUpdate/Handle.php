<?php

namespace app\githubObserver\listRepositories\facade\repositoryListInDbUpdate;

use app\components\repository\GithubRepositoriesFromApiRepository;
use app\components\repository\GithubRepositoriesFromDBRepository;
use app\components\repository\interfaces\IGithubUserRepository;
use app\app\package\listRepositories\adapter\entity\GithubRepos;

final class Handle
{

    /** @var \app\components\repository\GithubRepositoriesFromApiRepository */
    private GithubRepositoriesFromApiRepository $apiRepositoriesRepository;

    /** @var \app\components\repository\GithubRepositoriesFromDBRepository */
    private GithubRepositoriesFromDBRepository $dbRepositoriesRepository;

    /** @var \app\components\repository\interfaces\IGithubUserRepository */
    private IGithubUserRepository $githubUserRepository;

    /**
     * @param  \app\components\repository\GithubRepositoriesFromApiRepository  $apiRepositoriesRepository
     * @param  \app\components\repository\GithubRepositoriesFromDBRepository   $dbRepositoriesRepository
     * @param  \app\components\repository\interfaces\IGithubUserRepository     $githubUserRepository
     */
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

    public function handle(): void
    {
        $users = $this->githubUserRepository->getAll();

        /**@var $repositories \app\app\package\listRepositories\adapter\entity\GithubRepos*/
        $repositories = [];

        foreach ($users as $user) {
            $newRepositories = $this->apiRepositoriesRepository->get($user);
            if (!empty($newRepositories)) {
                $repositories = array_merge($repositories, $newRepositories);
            }
        }

        $transaction = \Yii::$app->db->beginTransaction();

        usort($repositories, function(GithubRepos $a, GithubRepos $b){
            if ($a->getUpdatedDateTime() == $b->getUpdatedDateTime()) {
                return 0;
            }
            return ($a->getUpdatedDateTime() < $b->getUpdatedDateTime()) ? 1 : -1;
        });

        $saved = true;
        if (!empty($repositories)) {
            $countOfRepos = count($repositories) > 10 ? 10 : count($repositories);
            for ($i = 0; $i < $countOfRepos; $i++) {
                if (!$this->dbRepositoriesRepository->save($repositories[$i])){
                    $saved = false;
                    break;
                }
            }

            $this->dbRepositoriesRepository->deleteAll();
        }

        !$saved ? $transaction->rollBack() : $transaction->commit();
    }
}