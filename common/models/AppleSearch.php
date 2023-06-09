<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AppleSearch represents the model behind the search form of `common\models\Apple`.
 */
class AppleSearch extends Apple
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'volume'], 'integer'],
            [['state', 'color', 'createdAt', 'fellAt', 'deletedAt'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
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
    public function search(array $params = []): ActiveDataProvider
    {
        $query = Apple::find()
            ->where(condition: ['deletedAt' => null]);

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
        $query->andFilterWhere([
            'id' => $this->id,
            'volume' => $this->volume,
            'createdAt' => $this->createdAt,
            'fellAt' => $this->fellAt,
            'deletedAt' => $this->deletedAt,
        ]);

        $query->andFilterWhere(['like', 'state', $this->state]);

        return $dataProvider;
    }
}