<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/24
 * Time: 下午6:04
 */

namespace e\controllers;


use common\models\ar\UyeInsuredWater;
use components\CsvUtil;
use e\components\EController;
use e\models\service\WaterModel;

class WaterController extends EController
{

    public function actionIndex()
    {
        $params = \Yii::$app->request->queryParams;
        if ($params['excel']) {
            $data = WaterModel::getWaterInfoList($params, $this->org_id);
            $headerData = ['流水ID', '操作时间', '订单数', '支付时间', '机构', '操作人', '支付方式'];
            $list = [];
            foreach ($data as $item) {
                $tmp = [
                    $item['insured_id'],
                    date('Y-m-d H:i:s', $item['created_time']),
                    1,
                    date('Y-m-d H:i:s', $item['created_time']),
                    $item['org_name'],
                    $item['username'],
                    UyeInsuredWater::$paySource[$item['pay_source']],
                ];
                $list[] = $tmp;
            }
            CsvUtil::exportCsv($list, $headerData, "Uye_" . date('YmdHis') . ".csv");

        } else {
            $data = WaterModel::getWaterGroupDate($params, $this->org_id);
            return $this->render('index', $data);
        }
    }
}