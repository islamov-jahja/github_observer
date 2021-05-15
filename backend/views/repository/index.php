<?php

echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'name',
            'label' => 'Название репозитория',
            'format' => 'raw',
            'value' => function($model){
                return \yii\helpers\Html::a($model->name, $model->link);
            }
        ],
        [
            'attribute' => 'updated_at',
            'label' => 'Дата последнего обновления'
        ],
    ]
]);