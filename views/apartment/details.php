<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Apartment */

//$this->title = $model->title;
//$this->params['breadcrumbs'][] = ['label' => 'Apartments', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="clear-fix"></div>
    <div class="apartment-view">

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
//                'id',
//                'title',
                [
                    'label' => 'Title',
                    'format' => 'raw',
                    'value' => Html::a($model->title,$model->url,['target'=>'_blank']),
                ],
//                [
//                    'label'=>'title',
//                    'format' => 'raw',
//                    'value'=>function ($data) {
//                        return Html::a($data->title,$data->url,['target'=>'_blank']);
//                    },
//                ],
//            'description',
                'price',
//            'address',
//            'show_on_map',
//            'html',
                'date'
//            'query.name',
//            'author_id',
//            'updater_id',
//            'created_at:date',
//            'updated_at:date',
            ],
        ]) ?>
        <?php
//        $date = $model->date;
//        echo $date.'<hr>';
//
//
//        if(strpos($date, 'Сегодня')){
//
//        }
//        setlocale( LC_TIME, 'ru_RU', 'russian' );
//
//        var_dump(date_parse($date));
//        echo $date.'<hr>';
//        print_r( date_parse_from_format("M h:i", $date) );
//        echo $date.'<hr>';
//
//        if(strpos($date, 'Вчера')){
//
//        }
//

//        $ru_month = array( 'Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь' );
//        $en_month = array( 'Jan', 'Feb', 'Mar', 'May', 'June', 'July', 'August', 'September', 'Oktober', 'November', 'December' );

//        print_r( date_parse_from_format( "F j Y", str_replace( $ru_month, $en_month, $date ) ) );
//        $info = date_parse($model->date);
//        var_dump($info);

        echo$model->html
        ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
//                'id',
//                'title',
                [
                    'label' => 'Title',
                    'format' => 'raw',
                    'value' => Html::a($model->title,$model->url,['target'=>'_blank']),
                ],
//                [
//                    'label'=>'title',
//                    'format' => 'raw',
//                    'value'=>function ($data) {
//                        return Html::a($data->title,$data->url,['target'=>'_blank']);
//                    },
//                ],
//            'description',
                'price',
//            'address',
//            'show_on_map',
//            'html',
                'date'
//            'query.name',
//            'author_id',
//            'updater_id',
//            'created_at:date',
//            'updated_at:date',
            ],
        ]) ?>


    </div>
</div>