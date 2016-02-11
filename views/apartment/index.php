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

        <h1><?php // Html::encode($this->title) ?></h1>
        <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php
        $opts = [];
        foreach($queries as $q){
            $opts[] = [
//            'format' => 'raw',
                'label' => $q->name . '<span id="totalUpdate" class="badge"></span>',
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
                                self.html('Upload ' + '<span class=badge>'+response+'</span>');
                            }
                            }).done(function(){self.removeAttr('disabled');});
                            return false;",
                        ]
                    ) .
                    Html::a('Delete All', ['deleteall','id'=>$q->id],
                        [
                            'class' => 'btn btn-danger',
                            'onclick'=>"
                            var self = $(this);
                            self.attr('disabled', true);
                            $.ajax({
                            type : 'GET',
                            url  : this.href,
                            success  : function(response) {
                                $.pjax.reload('#apartments',{timeout:2200});  //Reload GridView
                            }
                            }).done(function(){self.removeAttr('disabled');});
                            return false;",
                        ]
                    ),
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

        Pjax::begin(['id' => 'apartments']);


        ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'layout'=>"{items}\n{pager}",
            'filterModel' => false,
            'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//            'id',
                'image_link:image',
//            'title',
                [
                    'label'=>'title',
                    'format' => 'raw',
                    'value'=>function ($data) {
                        return Html::a($data->title,$data->url,['target'=>'_blank']).'<br> '.$data->address;
                    },
                ],
                [
                    'header'=>'Fast look',
                    'value'=> function($data)
                    {
                        return  Html::a(Yii::t('app', ' {modelClass}', [
                            'modelClass' => 'details',
                        ]), ['details','id'=>$data->id], ['class' => 'btn btn-success popupModal']);
                    },
                    'format' => 'raw'
                ],
//            'query_id',
//            'description',
                'price',
//                'address',
                'date',
                // 'show_on_map',
                // 'html',
//             'query.name',
                // 'author_id',
                // 'updater_id',
                // 'created_at',
                // 'updated_at',
//                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php Pjax::end(); ?></div>


<?php

$this->registerJs("$(function() {
   $('.popupModal').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-content')
     .load($(this).attr('href'));
   });
});");

?>
<?php
yii\bootstrap\Modal::begin(['id' =>'modal', 'size' => \yii\bootstrap\Modal::SIZE_LARGE,]);
yii\bootstrap\Modal::end();
?>

