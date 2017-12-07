<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/12/7
 * Time: 下午3:06
 */

namespace e\controllers;

use common\models\ar\UyeInsuredOrder;
use components\CsvUtil;
use e\models\service\InsuredModel;
use Yii;
use e\components\EController;

class JobController extends EController
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function actionIndex()
    {
        $excel = Yii::$app->request->get('excel');
        $params = Yii::$app->request->queryParams;
        $params['insured_status'] = INSURED_STATUS_JOB_SEARCH;
        $data = InsuredModel::getInsuredOrders($params, $this->org_id);
        if (!$excel) {
            return $this->render('index', $data);
        } else {
            $headerData = ['单号', '状态', '姓名', '身份证号', '手机号', '分校', '课程', '顾问', '申请时间', '支付时间', '学费', '服务费'];
            $list = [];
            foreach ($data as $item) {
                $tmp = [
                    $item['insured_order'],
                    UyeInsuredOrder::getInsuredStatusDesp($item['insured_status']),
                    $item['full_name'],
                    $item['id_card'],
                    $item['auth_mobile'],
                    $item['org_name'],
                    $item['c_name'],
                    $item['course_consultant'],
                    date('Y-m-d H:i:s', $item['created_time']),
                    date('Y-m-d H:i:s', $item['created_time']),
                    "￥" . number_format(($item['tuition'] / 100), 2),
                    "￥" . number_format(($item['premium_amount'] / 100), 2)
                ];
                $list[] = $tmp;
            }

            CsvUtil::exportCsv($list, $headerData, "Uye_" . date('YmdHis') . ".csv");
        }
    }
}