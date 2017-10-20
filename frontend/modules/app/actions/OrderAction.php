<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/18
 * Time: 下午2:05
 */

namespace app\modules\app\actions;


use app\modules\app\components\AppAction;
use common\models\ar\UyeInsuredOrder;
use common\models\ar\UyeOrg;
use common\models\ar\UyeOrgCourse;
use components\Output;
use components\UException;
use frontend\models\DataBus;

class OrderAction extends AppAction
{
    public function run()
    {
        try {
            $request = \Yii::$app->request;
            $page = $request->getBodyParam('page', 1);

            $data = $this->getInsuredOrder($page);


            Output::info(SUCCESS, SUCCESS_CONTENT, $data);
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

    private function getInsuredOrder($page = 1)
    {
        try {
            $uid = 1000003;
            $fields = "io.*,o.org_name,oc.name as c_name";
            $insuredOrder = UyeInsuredOrder::find()
                ->select($fields)
                ->from(UyeInsuredOrder::TABLE_NAME . " io")
                ->leftJoin(UyeOrg::TABLE_NAME . " o", "o.id=io.org_id")
                ->leftJoin(UyeOrgCourse::TABLE_NAME . " oc", "oc.id=io.c_id")
                ->where('io.uid=:uid', [':uid' => $uid])
                ->orderBy('id desc')
                ->limit(1)
                ->offset(($page - 1))
                ->asArray()->one();

            $count = UyeInsuredOrder::find()
                ->select("COUNT(io.id) AS count")
                ->from(UyeInsuredOrder::TABLE_NAME . " io")
                ->leftJoin(UyeOrg::TABLE_NAME . " o", "o.id=io.org_id")
                ->leftJoin(UyeOrgCourse::TABLE_NAME . " oc", "oc.id=io.c_id")
                ->where('io.uid=:uid', [':uid' => $uid])
                ->asArray()->one();

            $getPageArr = [
                'totalCount' => $count['count'],
                'totalPage' => $count['count'],
                'page' => $page,
                'pageSize' => 1
            ];

            $result = [
                'insured_order' => $insuredOrder['insured_order'],
                'insured_status' => $insuredOrder['insured_status'],
                'insured_status_desp' => $insuredOrder['insured_status'],
                'org_name' => $insuredOrder['org_name'],
                'insured_type' => UyeInsuredOrder::$insuredType[$insuredOrder['insured_type']],
                'tuition' => $insuredOrder['tuition'],
                'remark' => 'xxxx',
                'premium_amount_top' => $insuredOrder['premium_amount'],
                'career_time' => '2018-01-01~2018-03-01',
                'repay_time' => '2018-03-01~2018-10-01',
                'train' => [
                    'first_train' => $insuredOrder['class_start'] . "~" . $insuredOrder['class_end'],
                    'second_train' => '',
                    'end_train' => '',
                ]
            ];

            return [
                'page' => $getPageArr,
                'insured_order' => $result
            ];
        } catch (UException $exception) {
            \Yii::error($exception->getMessage());
        }
    }
}