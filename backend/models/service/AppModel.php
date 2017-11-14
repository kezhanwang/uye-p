<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/11/14
 * Time: 下午3:33
 */

namespace backend\models\service;


use common\models\ar\UyeAppVersion;
use yii\base\NotSupportedException;
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

    public static function created($params)
    {
        $params = $params['UyeAppVersion'];
        if ($params['type'] == UyeAppVersion::TYPE_IOS) {
            $params['url'] = 'https://itunes.apple.com/cn/app/id1309404350?mt=8';
        } else if ($params['type'] == UyeAppVersion::TYPE_ANDROID) {
            $params['url'] = DOMAIN_IMAGE . "/app_sdk/" . $params['app_name'];
        }

        $check = UyeAppVersion::find()->select('*')->from(UyeAppVersion::TABLE_NAME)->where('version_code=:version_code', [':version_code' => $params['version_code']])->asArray()->all();
        if (!empty($check)) {
            throw new NotSupportedException('版本号重复');
        }
        return UyeAppVersion::_add($params);
    }
}