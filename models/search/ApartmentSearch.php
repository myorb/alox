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
            [['id', 'title', 'description', 'price', 'address', 'show_on_map', 'html', 'query_id', 'author_id', 'updater_id', 'created_at', 'updated_at','like'], 'safe'],
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
        $query = Apartment::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'date' => SORT_DESC,
                ]
            ],
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
        $this->author_id = Yii::$app->user->isGuest ? 0 :\Yii::$app->user->id;

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['in', 'id', $this->id])
            ->andFilterWhere(['in', 'title', $this->title])
            ->andFilterWhere(['in', 'description', $this->description])
            ->andFilterWhere(['in', 'price', $this->price])
            ->andFilterWhere(['in', 'address', $this->address])
            ->andFilterWhere(['in', 'show_on_map', $this->show_on_map])
            ->andFilterWhere(['in', 'html', $this->html])
            ->andFilterWhere(['in', 'query_id', $this->query_id])
            ->andFilterWhere(['in', 'author_id', $this->author_id])
            ->andFilterWhere(['in', 'updater_id', $this->updater_id])
            ->andFilterWhere(['in', 'created_at', $this->created_at])
            ->andFilterWhere(['in', 'like', $this->like])
            ->andFilterWhere(['in', 'updated_at', $this->updated_at]);

        return $dataProvider;
    }
}
