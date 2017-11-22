<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/11/21
 * Time: 下午5:28
 */

namespace app\modules\app\models;


use common\models\ar\UyeInsuredWork;
use yii\data\Pagination;

class WorkModel
{
    public static function getList($insured_id, $page)
    {
        if (empty($insured_id) || !is_numeric($insured_id)) {
            return [];
        }

        $query = UyeInsuredWork::find()
            ->select('*')
            ->from(UyeInsuredWork::TABLE_NAME)
            ->where('insured_id=:insured_id', [':insured_id' => $insured_id]);
        $pageSize = 10;
        $lists = $query->orderBy('date desc')->offset(($page - 1) * $pageSize)->limit($pageSize)->asArray()->all();
        $works = [];
        foreach ($lists as $list) {
            $tmp = [
                'date' => $list['date'], 'desp' => '', 'pic' => []
            ];
            if (is_array(json_decode($list['pic_json'], true))) {
                $tmp['pic'] = json_decode($list['pic_json'], true);
            }

            switch ($list['is_hiring']) {
                case UyeInsuredWork::IS_HIRING_SUCCESS:
                    $desp = "恭喜您成功就业到" . $list['work_name'] . '!';
                    break;
                case UyeInsuredWork::IS_HIRING_WAIT:
                    if ($list['add_type'] == 1) {
                        $desp = "您尝试就业到" . $list['work_name'];
                    } else {
                        $desp = "机构为您推荐就业到" . $list['work_name'];
                    }
                    break;
            }
            $tmp['desp'] = $desp;
            $works[] = $tmp;
        }

        $count = UyeInsuredWork::find()
            ->select('COUNT(id) totalCount')
            ->from(UyeInsuredWork::TABLE_NAME)
            ->where('insured_id=:insured_id', [':insured_id' => $insured_id])
            ->asArray()->one();
        $getPageArr = [
            'totalCount' => $count['totalCount'],
            'totalPage' => ceil($count['totalCount'] / $pageSize),
            'page' => $page,
            'pageSize' => $pageSize
        ];
        return [
            'pages' => $getPageArr,
            'lists' => $works
        ];
    }
}