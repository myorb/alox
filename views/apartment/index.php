<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ApartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Apartments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apartment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    Pjax::begin(['id' => 'apartments']);

    $opts = [];
    foreach(\app\models\Query::find()->all() as $q){
        $opts[] = [
//            'format' => 'raw',
            'label' => $q->name,
            'content' =>
                Html::a('Upload', ['reload','id'=>$q->id],
                    [
                        'class' => 'btn btn-info',
                        'id' => 'refreshButton',
                        'onclick'=>"
                            var self = $(this);
                            self.attr('disabled', true);
                            $.ajax({
                            type : 'GET',
                            url  : this.href,
                            success  : function(response) {
                                if(response > 0){
                                    $.pjax.reload('#apartments',{timeout:2200});  //Reload GridView
                                }
                                self.next().html(response);
                            }
                            }).done(function(){self.removeAttr('disabled');});
                            return false;",
                    ]
                )
                . '<span id="totalUpdate" class="badge"></span>',
            'url' => ['apartment/index','ApartmentSearch'=>['query_id'=>$q->id]],
            'active' => \yii\helpers\Url::current() == \yii\helpers\Url::current(['ApartmentSearch'=>['query_id'=>$q->id]])
        ];
    }
    ?>
    <?php


echo \yii\bootstrap\Tabs::widget([
    'items' => $opts,
    'options' => ['tag' => 'div'],
    'itemOptions' => ['tag' => 'div'],
    'headerOptions' => ['class' => 'my-class'],
    'clientOptions' => ['collapsible' => true],
    'encodeLabels' => false,
]);



?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout'=>"{items}\n{pager}",
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            'image_link:image',
//            'title',
            [
                'label'=>'title',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Html::a($data->title,$data->url,['target'=>'_blank']);
                },
            ],
//            'query_id',
//            'description',
            'price',
            'address',
            'date',
            // 'show_on_map',
            // 'html',
//             'query.name',
            // 'author_id',
            // 'updater_id',
            // 'created_at',
            // 'updated_at',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
<?php
$this->registerJs(
    '$("document").ready(function(){
    console.log($("#refreshButton"));
         $("#refreshButton").click(function(event) {
            event.preventDefault();
//            var self = $(this);
//            self.attr("disabled", true);
//            $.get(this.href, function(data){
//                if(data > 0){
//                    $.pjax.reload("#apartments",{timeout:2200});  //Reload GridView
//                }
//                $("#totalUpdate").html(data);
//                self.removeAttr("disabled");
//            });
        });
    });'
);
?>