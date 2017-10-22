<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/18
 * Time: 上午11:40
 */

namespace console\controllers;


use common\models\ar\UyeCategory;
use common\models\ar\UyeConfig;
use common\models\ar\UyeInsuredOrder;
use common\models\ar\UyeOrg;
use common\models\ar\UyeOrgInfo;
use common\models\opensearch\OrgSearch;
use common\models\opensearch\SearchOS;
use yii\console\Controller;

class TestController extends Controller
{

    public function actionIndex()
    {
//        $olds = \Yii::$app->db2->createCommand("select id,name,areaid from kz_school where sbid=10073")->queryAll();
//
//        foreach ($olds as $item) {
//            if ($org=UyeOrg::findOne(['org_name'=>$item['name']])){
//                UyeOrgInfo::_updateOrgInfo($org['id'], ['area' => $item['areaid']]);
//            }
//
//        }

//        $fields = "o.*,oi.*,c.name as category";
//        $query = (new \yii\db\Query())
//            ->select($fields)
//            ->from(UyeOrg::TABLE_NAME . " o")
//            ->leftJoin(UyeOrgInfo::TABLE_NAME . " oi", "oi.org_id=o.id")
//            ->leftJoin(UyeCategory::TABLE_NAME . " c", "c.id=oi.category_1")
//            ->all();
//
//        OrgSearch::createPush($query);

//        $orgs = UyeOrgInfo::find()->select('org_id,city')->asArray()->all();
//        foreach ($orgs as $org) {
//            $sql = "select * from uye_areas where areaid='" . $org['city'] . "'";
//            $result = \Yii::$app->db->createCommand($sql)->queryOne();
//            if ($result){
//                $result = UyeOrgInfo::_updateOrgInfo($org['org_id'], ['province' => $result['parentid']]);
//            }
//
//        }

        $data = [
            [
                'id' => 1,
                'type' => 1,
                'question' => '您对自己所学行业感兴趣吗？',
                'answer' => [
                    '感兴趣',
                    '一般 ',
                    '纯粹为了找工作'
                ],
            ],
            [
                'id' => 2,
                'type' => 1,
                'question' => '您了解所学行业，或有相关基础吗？',
                'answer' => [
                    '了解并有基础',
                    '了解没有基础',
                    '不了解没有基础'
                ],
            ],
            [
                'id' => 3,
                'type' => 1,
                'question' => '您期望毕业以后的就业薪资是多少？',
                'answer' => [
                    '5000以内',
                    '5000-8000',
                    '8000-10000',
                    '10000+'
                ],
            ],
            [
                'id' => 4,
                'type' => 1,
                'question' => '您期望的就业地点是？',
                'answer' => [
                    '北上广深',
                    '二线省会城市',
                    '其他'
                ],
            ],
            [
                'id' => 5,
                'type' => 1,
                'question' => '您学费是怎样缴纳的？',
                'answer' => [
                    '一次性全款',
                    '贷款分期',
                ],
            ],
        ];

        $d = json_encode($data);
        UyeConfig::_updateConfig(4,['value'=>$d]);
    }


}