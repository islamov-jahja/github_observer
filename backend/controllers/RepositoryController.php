<?php


namespace app\controllers;


use app\components\repository\interfaces\IGithubRepositoriesRepository;
use app\components\services\interfaces\IRepositoriesProcessor;
use yii\base\BaseObject;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class RepositoryController extends Controller
{
    private IRepositoriesProcessor $repositoriesProcessor;
    public function __construct($id, $module, IRepositoriesProcessor $repositoriesProcessor,$config = [])
    {
        $this->repositoriesProcessor = $repositoriesProcessor;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(){
        $repositories = $this->repositoriesProcessor->getAll();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $repositories,
            'sort' => [
                'attributes' => ['id'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

}