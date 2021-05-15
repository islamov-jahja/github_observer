<?php


namespace app\controllers;


use yii\web\Controller;

class ErrorController extends Controller
{
    public function actionError()
    {
        $exception = \Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            $statusCode = $exception->statusCode;
            $name = $exception->getName();
            $message = $exception->getMessage();
            $this->layout = 'custom-error-layout';
            return $exception;
        }
    }
}