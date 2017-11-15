<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/19
 * Time: 上午10:29
 */

namespace app\modules\app\controllers;


use app\modules\app\components\AppController;
use common\models\ar\UyeOrg;
use common\models\ar\UyeOrgInfo;

class OrgController extends AppController
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function actionView()
    {
        $this->layout = "main_h5";
        $org_id = $this->getParams('org_id');
        $orgInfo = UyeOrg::getOrgById($org_id, null, null, true);
        return $this->render('view', $orgInfo);

    }
}