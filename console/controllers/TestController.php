<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/18
 * Time: 上午11:40
 */

namespace console\controllers;


use common\models\ar\UyeCategory;
use common\models\ar\UyeEUser;
use common\models\ar\UyeOrg;
use common\models\ar\UyeOrgInfo;
use common\models\opensearch\OrgSearch;
use yii\console\Controller;

class TestController extends Controller
{

    public function actionIndex()
    {
        $user = new UyeEUser();
        $user->setIsNewRecord(true);
        $user->username = 'demo';
        $user->status = 10;
        $user->created_at = time();
        $user->updated_at = time();
        $user->email = 'demo@uyebang.com';
        $user->setPassword('demo');
        $user->generateAuthKey();
        $user->save();

    }

    public function actionOrgsearch()
    {
        $fields = "o.*,oi.*,c.name as category";
        $org = UyeOrg::find()
            ->select($fields)
            ->from(UyeOrg::TABLE_NAME . " o")
            ->leftJoin(UyeOrgInfo::TABLE_NAME . " oi", "oi.org_id=o.id")
            ->leftJoin(UyeCategory::TABLE_NAME . " c", "c.id=oi.category_1")
            ->asArray()
            ->all();
        OrgSearch::createPush($org);
    }
}