<?php
use kartik\helpers\Html;
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 13.02.16
 * Time: 20:38
 */
echo '<div class="row">';
foreach($dataProvider->getModels() as $model){
    ?>
<div class="col-lg-3 col-md-4 col-xs-6 thumb">
    <?=\yii\bootstrap\Html::a(
        \yii\bootstrap\Html::img(
            $model->image_link?
                $model->image_link:
                'http://placehold.it/400x300',
            ['height'=>'200px','style'=>['max-height'=>'200px','min-height'=>'200px']]),
        $model->url,
        ['target'=>'_blank','class'=>"thumbnail"]
    )
    ?>
    </a>
</div>
<?php
}
echo '</div>';
