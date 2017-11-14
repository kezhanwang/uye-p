<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/11/14
 * Time: 下午3:33
 */

namespace backend\models\service;


use common\models\ar\UyeAppVersion;
use yii\data\Pagination;

class AppModel
{
    public static function getLists()
    {
        $query = UyeAppVersion::find()
            ->select('*')
            ->from(UyeAppVersion::TABLE_NAME);

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => '10']);
        $lists = $query->orderBy('id desc')->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        return [
            'pages' => $pages,
            'lists' => $lists
        ];
    }
}