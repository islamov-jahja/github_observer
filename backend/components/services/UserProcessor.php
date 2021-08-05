<?php

namespace app\components\services;
use app\components\commands\interfaces\IUpdateRepositoryListCommand;
use app\githubObserver\listRepositories\domain\entity\interfaces\IGithubUserEntity;
use app\components\repository\interfaces\IGithubUserRepository;
use app\components\services\interfaces\IGithubUserProcessor;

class UserProcessor implements IGithubUserProcessor
{
    private IUpdateRepositoryListCommand $updateRepositoriesCommand;
    private IGithubUserRepository $userRepository;

    public function __construct(IGithubUserRepository $userRepository, IUpdateRepositoryListCommand $command){
        $this->updateRepositoriesCommand = $command;
        $this->userRepository = $userRepository;
    }

    public function add(IGithubUserEntity $githubUserEntity): bool
    {
        $saved = $this->userRepository->save($githubUserEntity);
        if (!$saved) {
            return $saved;
        }

        $this->updateRepositoriesCommand->update();

        return $saved;
    }

    public function delete(int $id)
    {
        $this->userRepository->delete($id);
        $this->updateRepositoriesCommand->update();
    }

    public function getAll(): array
    {
        return $this->userRepository->getAll();
    }
}