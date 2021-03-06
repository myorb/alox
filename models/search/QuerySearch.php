<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Query;
use yii\filters\AccessControl;

/**
 * QuerySearch represents the model behind the search form about `app\models\Query`.
 */
class QuerySearch extends Query
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'url', 'author_id', 'updater_id', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Query::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $this->author_id = Yii::$app->user->isGuest ? 0 :\Yii::$app->user->id;

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['in', 'id', $this->id])
            ->andFilterWhere(['in', 'name', $this->name])
            ->andFilterWhere(['in', 'url', $this->url])
            ->andFilterWhere(['in', 'author_id', $this->author_id])
            ->andFilterWhere(['in', 'updater_id', $this->updater_id])
            ->andFilterWhere(['in', 'created_at', $this->created_at])
            ->andFilterWhere(['in', 'updated_at', $this->updated_at]);

        return $dataProvider;
    }

    public static function takeAll(){
        $query = Query::find();
        return $query->where(['author_id' => Yii::$app->user->isGuest ? 0 : Yii::$app->user->id])->all();
    }

    var $avaragePrice;


}
