<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ApartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Apartments';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php

$this->registerJs("$(function() {
   $('.popupModal').click(function(e) {
     e.preventDefault();
     $('#modal').modal('show').find('.modal-content')
     .load($(this).attr('href'));
   });
});
");


?>
    <div class="apartment-index">

        <h1><?php // Html::encode($this->title) ?></h1>
        <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

        <div class="dropdown pull-right">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle">View <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <?=Html::a('<span class="glyphicon glyphicon-th"> Gallery</span>', [\yii\helpers\Url::current(['view'=>'grid'])]) ?>
                    <?=Html::a('<span class="glyphicon glyphicon-th-list"> Table</span>', [\yii\helpers\Url::current(['view'=>'table'])]) ?>
                    <?=Html::a('<span class="glyphicon glyphicon-globe"> Map</span>', [\yii\helpers\Url::current(['view'=>'map'])]) ?>
                </li>
            </ul>
        </div>

        <?php

//
//        $h = $view=='grid'?'-list':'';
//        echo Html::a('<span class="glyphicon glyphicon-th'.$h.' "></span>', [\yii\helpers\Url::current(['view'=>$view=='grid'?'table':'grid'])],
//                [
//                    'class' => 'btn btn-primary pull-right',
//                    'onclick'=>"$.pjax.reload('#apartments');",
//                ]
//            );

        $opts[] = [
            'label' => ' All<span id="totalUpdate" class="badge"></span>',
            'content' => '',
            'url' => ['index'],
            'active' => \yii\helpers\Url::current() == \yii\helpers\Url::current(['index'])
        ];

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
                                    $.pjax.reload('#apartments',{timeout:2200});
                                    $('#apartments').on('pjax:complete', function() {
                                        $('#apartments tbody tr').slice( 0, response ).css( 'background', 'yellow' );
                                    });
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
                                response == 'ok'?
                                $.pjax.reload('#apartments',{timeout:2200}):
                                alert(response);
                            }
                            }).done(function(){self.removeAttr('disabled');});
                            return false;",
                        ]
                    )
                ,
                'url' => ['apartment/index','ApartmentSearch'=>['query_id'=>$q->id]],
                'active' => \yii\helpers\Url::current() == \yii\helpers\Url::current(['ApartmentSearch'=>['query_id'=>$q->id]])
            ];
        }

        echo \yii\bootstrap\Tabs::widget([
            'items' => $opts,
            'options' => ['tag' => 'div'],
            'itemOptions' => ['tag' => 'div'],
            'headerOptions' => ['class' => 'my-class'],
            'clientOptions' => ['collapsible' => true],
            'encodeLabels' => false,
        ]);

        Pjax::begin(['id' => 'apartments']);
        echo $this->render($view,['dataProvider' => $dataProvider, 'searchModel' => $searchModel,]);
        Pjax::end();
        ?>
    </div>

<?php
yii\bootstrap\Modal::begin([
    'id' =>'modal',
    'size' => \yii\bootstrap\Modal::SIZE_LARGE,
    'header' => '<h4 class="modal-title">View</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
]);
yii\bootstrap\Modal::end();
?>
