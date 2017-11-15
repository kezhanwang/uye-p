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
            $org_id = $this->getParams('org_id', '');
            if (empty($org_id) || !is_numeric($org_id)) {
                throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
            }

            $orgInfo = UyeOrg::getOrgById($org_id);

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
                ],
                'courses' => $courses,
            ];
            Output::info(SUCCESS, SUCCESS_CONTENT, $templateData);
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }
}