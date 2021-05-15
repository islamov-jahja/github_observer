<?php


namespace app\commands;


use app\components\commands\interfaces\IUpdateRepositoryListCommand;
use http\Client;
use yii\console\Controller;

class UpdateRepositoryListController extends Controller
{
    private IUpdateRepositoryListCommand $updateRepositoryListCommand;

    public function __construct($id, $module, IUpdateRepositoryListCommand $updateRepositoryListCommand, $config = [])
    {
        $this->updateRepositoryListCommand = $updateRepositoryListCommand;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $this->updateRepositoryListCommand->update();
    }
}