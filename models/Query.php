<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 08.02.16
 * Time: 02:46
 */
namespace app\models;

use app\models\search\ApartmentSearch;
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

    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    public function getToday(){
//        return Apartment::find([['author_id', $this->author_id],['query_id', $this->id]])->count();
        return ApartmentSearch::count($this->id);
//        $this->getDb()->executeCommand('');

    }

    public function getTotalApartments(){
        return Apartment::find()->where(['author_id' => \Yii::$app->user->id])->andWhere(['query_id' => $this->id])->count();
    }

    public function getCountAllNew(){
        return Apartment::find()
            ->where(['author_id' => \Yii::$app->user->id])
            ->andFilterWhere(['in','query_id',$this->id])
            ->andFilterWhere(['less','date',date('yesterday')])
//            ->andWhere('query_id='.$this->id)
            ->count();
    }
}