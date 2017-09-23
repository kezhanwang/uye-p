<?php

namespace common\models\search;

use common\models\ar\UyeOrg;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UyeOrgSearch represents the model behind the search form about `app\models\UyeOrg`.
 */
class UyeOrgSearch extends UyeOrg
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'org_type', 'parent_id', 'status', 'is_shelf', 'is_delete', 'is_employment', 'is_high_salary', 'created_time', 'updated_time'], 'integer'],
            [['org_short_name', 'org_name'], 'safe'],
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
        $query = UyeOrg::find();

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
            'org_type' => $this->org_type,
            'parent_id' => $this->parent_id,
            'status' => $this->status,
            'is_shelf' => $this->is_shelf,
            'is_delete' => $this->is_delete,
            'is_employment' => $this->is_employment,
            'is_high_salary' => $this->is_high_salary,
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'org_short_name', $this->org_short_name])
            ->andFilterWhere(['like', 'org_name', $this->org_name]);

        return $dataProvider;
    }
}
