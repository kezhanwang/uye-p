<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/18
 * Time: 上午11:40
 */

namespace console\controllers;


use common\models\ar\UyeOrg;
use common\models\ar\UyeOrgInfo;
use common\models\opensearch\OrgSearch;
use common\models\opensearch\SearchOS;
use yii\console\Controller;

class TestController extends Controller
{

    public function actionIndex()
    {
//        $olds = \Yii::$app->db2->createCommand("select * from kz_school where sbid=10073")->queryAll();
//
//        foreach ($olds as $item) {
//            $ar = new UyeOrg();
//            $ar->setIsNewRecord(true);
//            $ar->org_name = $item['name'];
//            $ar->org_short_name = $item['short_name'];
//            $ar->created_time = time();
//            $ar->updated_time = time();
//            $ar->save();
//            $data = $ar->getAttributes();
//
//            $arInfo = new UyeOrgInfo();
//            $arInfo->setIsNewRecord(true);
//            $arInfo->org_id = $data['id'];
//            $arInfo->map_lat = $item['lat'];
//            $arInfo->map_lng = $item['lng'];
//            $arInfo->created_time = time();
//            $arInfo->updated_time = time();
//            $arInfo->address = $item['address'];
//            $arInfo->phone = $item['phone'];
//            $arInfo->logo = $item['logo'];
//            $arInfo->description = $item['desp'];
//            $arInfo->save();
//        }

        $orgs = \Yii::$app->db->createCommand("select * from uye_org o left join uye_org_info oi on oi.org_id=o.id")->queryAll();
        OrgSearch::createPush($orgs);
    }
}