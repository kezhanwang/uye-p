<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/10
 * Time: 下午6:41
 */

namespace app\modules\app\actions;

use common\models\ar\UyeCategory;
use common\models\ar\UyeOrg;
use common\models\ar\UyeOrgCourse;
use common\models\ar\UyeOrgInfo;
use Yii;
use app\modules\app\components\AppAction;
use components\Output;
use components\UException;
use frontend\models\DataBus;

class OrgAction extends AppAction
{

    public function run()
    {
        try {
            $request = Yii::$app->request;
            $org_id = $request->isPost ? $request->post('org_id', '') : $request->get('org_id', '');
            if (empty($org_id) || !is_numeric($org_id)) {
                throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
            }

            $fields = "o.*,oi.*,c.name as category";
            $orgInfo = UyeOrg::find()
                ->select($fields)
                ->from(UyeOrg::TABLE_NAME . " o")
                ->leftJoin(UyeOrgInfo::TABLE_NAME . " oi", "oi.org_id=o.id")
                ->leftJoin(UyeCategory::TABLE_NAME . " c", "c.id=oi.category_1")
                ->where('o.id=:id AND o.status=:status AND o.is_shelf=:is_shelf', [':id' => $org_id, ':status' => UyeOrg::STATUS_OK, ':is_shelf' => UyeOrg::IS_SHELF_ON])
                ->asArray()
                ->one();

            if (empty($orgInfo)) {
                throw new UException(ERROR_ORG_NO_EXISTS_CONTENT, ERROR_ORG_NO_EXISTS);
            }

            $courses = UyeOrgCourse::find()->select('id AS cid,name AS c_name,logo')->from(UyeOrgCourse::TABLE_NAME)->where('org_id=:org_id', [':org_id' => $org_id])->asArray()->all();

            $templateData = [
                'organize' => [
                    'org_id' => $orgInfo['id'],
                    'logo' => $orgInfo['logo'],
                    'org_name' => $orgInfo['org_name'],
                    'employment_index' => $orgInfo['employment_index'],
                    'address' => $orgInfo['address'],
                    'phone' => $orgInfo['phone'],
                    'map_lng' => $orgInfo['map_lng'],
                    'map_lat' => $orgInfo['map_lat'],
                    'is_employment' => $orgInfo['is_employment'],
                    'description' => urlencode($orgInfo['description'])
                ],
                'courses' => $courses,
            ];
            Output::info(SUCCESS, SUCCESS_CONTENT, $templateData);
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }
}