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
use common\models\ar\UyeOrgCourse;
use common\models\ar\UyeOrgInfo;
use common\models\opensearch\OrgSearch;
use common\models\opensearch\SearchOS;
use yii\console\Controller;

class TestController extends Controller
{

    public function actionIndex()
    {
//        $sql = "select c.name as c_name,s.name as org_name,c.logo,c.tuition from pay_course c ,kz_school s where s.id=c.sid and s.sbid=10073;";
//        $olds = \Yii::$app->db2->createCommand($sql)->queryAll();
//        foreach ($olds as $item) {
//            $org = UyeOrg::find()->select('id')->where('org_name=:org_name', [':org_name' => $item['org_name']])->asArray()->one();
//            if ($org) {
////                UyeOrgInfo::_addOrgInfo([
////                    'org_id' => $org['id'],
////                    'map_lat' => $item['lat'],
////                    'map_lng' => $item['lng'],
////                    'address' => $item['address'],
////                    'phone' => $item['phone'],
////                    'description' => $item['desp'],
////                    'logo' => $item['logo'],
////                ]);
//
//                $ar = new UyeOrgCourse();
//                $ar->setIsNewRecord(true);
//                $ar->name = $item['c_name'];
//                $ar->tunit_price = $item['tuition'] * 100;
//                $ar->org_id = $org['id'];
//                $ar->created_time = time();
//                $ar->updated_time = time();
//                $ar->save();
//                var_dump($ar->getAttributes());
//            }
//
//        }

        $fields = "o.*,oi.*,c.name as category";
        $query = (new \yii\db\Query())
            ->select($fields)
            ->from(UyeOrg::TABLE_NAME . " o")
            ->leftJoin(UyeOrgInfo::TABLE_NAME . " oi", "oi.org_id=o.id")
            ->leftJoin(UyeCategory::TABLE_NAME . " c", "c.id=oi.category_1")
            ->all();

        OrgSearch::createPush($query);

//        $orgs = UyeOrgInfo::find()->select('org_id,city')->asArray()->all();
//        foreach ($orgs as $org) {
//            $sql = "select * from uye_areas where areaid='" . $org['city'] . "'";
//            $result = \Yii::$app->db->createCommand($sql)->queryOne();
//            if ($result){
//                $result = UyeOrgInfo::_updateOrgInfo($org['org_id'], ['province' => $result['parentid']]);
//            }
//
//        }

//        $order_id_main = date('YmdHis')  . rand(100000000, 999999999);
//        $order_id_len = strlen($order_id_main);
//        $order_id_sum = 0;
//        for ($i = 0; $i < $order_id_len; $i++) {
//            $order_id_sum += (int)(substr($order_id_main, $i, 1));
//        }
//        $order_id = $order_id_main . str_pad((100 - $order_id_sum % 100) % 100, 2, '0', STR_PAD_LEFT);
//        var_dump($order_id);


    }


}