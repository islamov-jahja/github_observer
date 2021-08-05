<?php


namespace app\controllers;


use app\components\repository\interfaces\IGithubUserRepository;
use app\app\package\listRepositories\adapter\entity\GithubUser;
use app\app\package\listRepositories\adapter\entity\User;
use app\components\services\interfaces\IGithubUserProcessor;
use yii\base\BaseObject;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class UserController extends Controller
{
    private IGithubUserProcessor $userProcessor;

    public function __construct($id, $module, IGithubUserProcessor $userProcessor, $config = [])
    {
        $this->userProcessor = $userProcessor;
        parent::__construct($id, $module, $config);
    }

    public function actionDelete(int $id){
        $this->userProcessor->delete($id);
        return $this->redirect(['index']);
    }

    public function actionCreate()
    {
        $model = new GithubUser();

        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(\Yii::$app->request->post()) && $this->userProcessor->add($model)) {
            return $this->redirect('index');
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    function actionIndex()
    {
        $users = $this->userProcessor->getAll();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $users,
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