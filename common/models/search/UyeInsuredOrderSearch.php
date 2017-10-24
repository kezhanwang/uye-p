<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/20
 * Time: 下午2:01
 */

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ar\UyeInsuredOrder;

class UyeInsuredOrderSearch extends UyeInsuredOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'insured_status', 'insured_type', 'uid', 'org_id', 'c_id', 'payment_method', 'created_time', 'updated_time'], 'integer'],
            [['insured_order', 'class', 'class_start', 'class_end', 'course_consultant', 'group_pic', 'training_pic', 'phoneid'], 'safe'],
            [['tuition', 'premium_amount', 'pay_ceiling', 'actual_repay_amount', 'map_lng', 'map_lat'], 'number'],
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
        $query = UyeInsuredOrder::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'insured_status' => $this->insured_status,
            'insured_type' => $this->insured_type,
            'uid' => $this->uid,
            'org_id' => $this->org_id,
            'c_id' => $this->c_id,
            'tuition' => $this->tuition,
            'premium_amount' => $this->premium_amount,
            'payment_method' => $this->payment_method,
            'pay_ceiling' => $this->pay_ceiling,
            'actual_repay_amount' => $this->actual_repay_amount,
            'class_start' => $this->class_start,
            'class_end' => $this->class_end,
            'map_lng' => $this->map_lng,
            'map_lat' => $this->map_lat,
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
        ]);


        $query->andFilterWhere(['like', 'insured_order', $this->insured_order])
            ->andFilterWhere(['like', 'class', $this->class])
            ->andFilterWhere(['like', 'course_consultant', $this->course_consultant])
            ->andFilterWhere(['like', 'group_pic', $this->group_pic])
            ->andFilterWhere(['like', 'training_pic', $this->training_pic])
            ->andFilterWhere(['like', 'phoneid', $this->phoneid]);

        return $dataProvider;
    }
}