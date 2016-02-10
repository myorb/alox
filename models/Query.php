<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 08.02.16
 * Time: 02:46
 */
namespace app\models;

use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\redis\ActiveRecord;
use app\models\User;

class Query extends ActiveRecord
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

    public function rules()
    {
        return [
            [[ 'name', 'url'], 'required'],
            [[ 'name', 'url'], 'safe'],
            [[ 'url'], 'url'],
        ];
    }

    public function attributes()
    {
        return ['id', 'name', 'url', 'author_id','updater_id','created_at','updated_at'];
    }

    public function getApartments()
    {
        return $this->hasMany(Apartment::className(), ['query_id' => 'id']);
    }

    public function getModel()
    {
        $e = $this->model_name;
        return $this->hasOne($e::className(), ['id' => 'model_id']);
    }

    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }
}