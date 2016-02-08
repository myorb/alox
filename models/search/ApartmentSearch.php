<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Apartment;

/**
 * ApartmentSearch represents the model behind the search form about `app\models\Apartment`.
 */
class ApartmentSearch extends Apartment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'title', 'description', 'price', 'address', 'show_on_map', 'html', 'query_id', 'author_id', 'updater_id', 'created_at', 'updated_at'], 'safe'],
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
        $query = Apartment::find()->orderBy(['id' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'show_on_map', $this->show_on_map])
            ->andFilterWhere(['like', 'html', $this->html])
            ->andFilterWhere(['like', 'query_id', $this->query_id])
            ->andFilterWhere(['like', 'author_id', $this->author_id])
            ->andFilterWhere(['like', 'updater_id', $this->updater_id])
            ->andFilterWhere(['like', 'created_at', $this->created_at])
            ->andFilterWhere(['like', 'updated_at', $this->updated_at]);

        return $dataProvider;
    }
}
