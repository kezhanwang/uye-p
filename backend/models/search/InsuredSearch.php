<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/22
 * Time: 下午6:06
 */

namespace backend\models\search;


use common\models\ar\UyeInsuredOrder;
use common\models\ar\UyeOrg;
use common\models\ar\UyeUserIdentity;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class InsuredSearch extends UyeInsuredOrder
{
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = UyeInsuredOrder::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => ['id'],
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
            'org_name' => $this->getAttribute('org_name')
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