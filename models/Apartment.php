<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 08.02.16
 * Time: 02:47
 */

namespace app\models;


use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\redis\ActiveRecord;

class Apartment extends ActiveRecord
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
            [[ 'query_id'], 'required'],
            [[
                'id',
                'title',
                'description',
                'price',
                'address',
                'show_on_map',
                'html',
                'url',
                'date',
                'query_id',
                'image_link',
                'html',
                'like',
                'currency',
            ], 'safe'],
        ];
    }


    public function attributes()
    {
        return [
            'id',
            'title',
            'description',
            'price',
            'address',
            'show_on_map',
            'html',
            'url',
            'query_id',
            'image_link',
            'date',
            'html',
            'author_id',
            'updater_id',
            'created_at',
            'updated_at',
            'like',
            'currency',
        ];
    }

    public function getQuery()
    {
        return $this->hasOne(Query::className(), ['id' => 'query_id']);
    }

    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'model_id']);
    }

    public function getLikes()
    {
        return $this->hasMany(Like::className(), ['apartment_id' => 'id']);
    }

    public function setlike(){
        return $this->like = $this->like == 1?0:1;
    }
    public function getFullPrice(){
        return number_format(filter_var($this->price, FILTER_SANITIZE_NUMBER_INT)).$this->currency;
    }
    public function getDateformated(){
        return date("M-j H:i",$this->date);
    }
}
