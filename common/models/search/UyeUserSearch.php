<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/22
 * Time: 下午11:02
 */

namespace common\models\search;


use common\models\ar\UyeUser;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UyeUserSearch extends UyeUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'status', 'created_time', 'updated_time'], 'integer'],
            [['username', 'password', 'phone', 'email', 'head_portrait'], 'safe'],
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
        $query = UyeUser::find();

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
            'uid' => $this->uid,
            'status' => $this->status,
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'head_portrait', $this->head_portrait]);

        return $dataProvider;
    }
}