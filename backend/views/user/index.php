<?php
/**@param \yii\data\ArrayDataProvider $dataProvider*/

use yii\bootstrap\Modal;
?>
<?php \yii\widgets\Pjax::begin()?>
<?= \yii\helpers\Html::button('Добавить пользователя', ['class'=>'open-modal btn btn-primary btn-raised', 'style' => 'margin-bottom: 30px', 'onclick' =>
    '$("#modal-info").modal("show"); 
     $("#modal-info").find(".modal-title").text("Добавить пользователя");
     $("#modal-info").find(".modal-body").load("/user/create");
     console.log("finder");
     '
]) ?>

<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'name',
            'label' => 'Имя'
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttons'=>[
                'delete' => function ($url, $model) {
                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-trash"></span>', ["/user/delete/{$model['id']}"], [
                        'title' => Yii::t('yii', 'Delete'),
                        'class' => 'open-modal table-link',
                        'data-conf' => 'Вы действительно хотите удалить выбранный элемент?',
                    ]);
                }
            ]
        ]
    ],
]); ?>
<?php \yii\widgets\Pjax::end()?>


