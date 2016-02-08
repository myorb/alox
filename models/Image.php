<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 08.02.16
 * Time: 02:59
 */

namespace app\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\redis\ActiveRecord;

class Image extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                // 'value' => new Expression('NOW()'),
            ],
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'author_id',
                'updatedByAttribute' => 'updater_id',
            ],
        ];
    }

    public function attributes()
    {
        return ['id','model_name','model_id','file','path','link','author_id','updater_id','created_at','updated_at'];
    }

    public function getModel()
    {
        $e = $this->model_name;
        return $this->hasOne($e::className(), ['id' => 'model_id']);
    }
}