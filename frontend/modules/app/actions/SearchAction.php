<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/9
 * Time: 下午7:05
 */

namespace app\modules\app\actions;


use app\modules\app\components\AppAction;
use common\models\ar\UyeCategory;
use common\models\ar\UyeSearchLog;
use components\Output;
use frontend\models\DataBus;

class SearchAction extends AppAction
{
    public function run()
    {
        try {
            //拉取机构分类面包屑
            $categorys = UyeCategory::find()->asArray()->all();

            if (DataBus::get('uid')) {
                $searchHistory = UyeSearchLog::find()->select('')->where('uid=:uid', [':uid' => DataBus::get('uid')])->limit(5)->offset(0)->orderBy('id desc');
            } else {
                $searchHistory = [];
            }

            //获取周边的学校
            $templateData = [
                'categorys' => $categorys,
                'history' => $searchHistory,
            ];
            Output::info(SUCCESS, SUCCESS_CONTENT, $templateData, $this->token());
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage(), array(), DataBus::get('uid'), $this->token());
        }
    }
}