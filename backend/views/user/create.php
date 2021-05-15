<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model \app\models\GithubUser */

$this->title = 'Добавить пользователя';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <?= $this->renderAjax('_form', [
        'model' => $model,
    ]) ?>

</div>