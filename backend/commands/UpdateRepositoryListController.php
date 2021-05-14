<?php


namespace app\commands;


use app\components\commands\interfaces\IUpdateRepositoryListCommand;
use http\Client;

class UpdateRepositoryListController
{
    private IUpdateRepositoryListCommand $updateRepositoryListCommand;

    public function __construct(IUpdateRepositoryListCommand $updateRepositoryListCommand)
    {
        $this->updateRepositoryListCommand = $updateRepositoryListCommand;
    }

    public function actionIndex()
    {
        $this->updateRepositoryListCommand->update();
    }
}