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
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Apartment', ['create'], ['class' => 'btn btn-success']) ?>

    </p>
<?php
//var_dump($dataProvider->getModels());
Pjax::begin(['id' => 'apartments']); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
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
            // 'show_on_map',
            // 'html',
             'query.name',
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
        $("#refreshButton").click("#refreshButton", function(event) {
            event.preventDefault();
            var self = $(this);
            self.attr("disabled", true);
            var form = self.parents("form").serialize();
            $.get(this.href,form, function(data){
                if(data > 0){
                    $.pjax.reload("#apartments",{timeout:2200});  //Reload GridView
                }
                $("#totalUpdate").html(data);
                self.removeAttr("disabled");
            });
        });
    });'
);
?>