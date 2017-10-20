<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/18
 * Time: 上午11:40
 */

namespace console\controllers;


use common\models\ar\UyeCategory;
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

        list($t1, $t2) = explode(' ', microtime());
        $msectime = (float)sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
        $order_id_main = date('YmdHis') . rand(100000000, 999999999);
        //订单号码主体长度
        $order_id_len = strlen($order_id_main);
        $order_id_sum = 0;
        for ($i = 0; $i < $order_id_len; $i++) {
            $order_id_sum += (int)(substr($order_id_main, $i, 1));
        }
        //唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）
        $order_id = $order_id_main . str_pad((100 - $order_id_sum % 100) % 100, 2, '0', STR_PAD_LEFT);
        $strlen = strlen($order_id);
        if ($strlen < 32) {
            $order_id = str_pad($order_id, 32, "0", STR_PAD_RIGHT);
        } else {
            $order_id = substr($strlen, 0, 32);
        }
        var_dump($order_id);
    }


}