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

        $fields = "o.id,o.org_name,oi.employment_index,oi.avg_course_price,oi.category_1,c.name as category,oi.map_lng,oi.map_lat,oi.logo,oi.address";
        $query = (new \yii\db\Query())
            ->select($fields)
            ->from(UyeOrg::TABLE_NAME . " o")
            ->leftJoin(UyeOrgInfo::TABLE_NAME . " oi", "oi.org_id=o.id")
            ->leftJoin(UyeCategory::TABLE_NAME . " c", "c.id=oi.category_1")
            ->all();

        OrgSearch::createPush($query);


    }
}