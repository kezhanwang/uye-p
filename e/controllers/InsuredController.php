<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/20
 * Time: 下午12:00
 */

namespace e\controllers;

use common\models\ar\UyeInsuredOrder;
use components\CsvUtil;
use components\UException;
use e\components\EOutput;
use e\models\search\InsuredSearch;
use e\models\service\InsuredModel;
use Yii;
use e\components\EController;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class InsuredController extends EController
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {

    }

    public function actionList()
    {
        $excel = Yii::$app->request->get('excel');
        $data = InsuredModel::getInsuredOrders(Yii::$app->request->queryParams, $this->org_id);
        if (!$excel) {
            return $this->render('list', $data);
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

    public function actionView($id)
    {
        $templateData = InsuredModel::getInsuredInfo($id, Yii::$app->user->identity->org_id);
        return $this->render('view', $templateData);
    }

    public function actionRefusepay()
    {
        try {
            $id = $this->getParams('id');
            InsuredModel::refusePay($id, $this->org_id);
            EOutput::info(SUCCESS, SUCCESS_CONTENT);
        } catch (UException $exception) {
            EOutput::err($exception->getCode(), $exception->getMessage());
        }
    }
}