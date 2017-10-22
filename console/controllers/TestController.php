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
        $olds = \Yii::$app->db2->createCommand("select * from kz_school where sbid=10065")->queryAll();
        foreach ($olds as $item) {
            if ($org = UyeOrg::findOne(['org_name' => $item['name']])) {
                UyeOrgInfo::_addOrgInfo([
                    'org_id' => $org['id'],
                    'map_lat' => $item['lat'],
                    'map_lng' => $item['lng'],
                    'address' => $item['address'],
                    'phone' => $item['phone'],
                    'description' => $item['desp'],
                    'logo' => $item['logo'],
                ]);
            }

        }

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


    }


}