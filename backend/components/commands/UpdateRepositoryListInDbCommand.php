<?php
namespace app\components\commands;

use app\components\commands\interfaces\IUpdateRepositoryListCommand;
use app\githubObserver\listRepositories\domain\entity\interfaces\IGithubRepositoryEntity;
use app\components\repository\GithubRepositoriesFromApiRepository;
use app\components\repository\GithubRepositoriesFromDBRepository;
use app\components\repository\interfaces\IGithubRepositoriesRepository;
use app\components\repository\interfaces\IGithubUserRepository;
use app\githubObserver\common\enums\DateFormat;
use app\app\package\listRepositories\adapter\entity\GithubRepos;

class UpdateRepositoryListInDbCommand implements IUpdateRepositoryListCommand
{

}