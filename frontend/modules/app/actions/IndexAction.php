<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/9
 * Time: 上午11:36
 */

namespace app\modules\app\actions;

use common\models\ar\UyeCategory;
use components\BaiduMap;
use Yii;
use app\modules\app\components\AppAction;
use components\Output;
use components\UException;

class IndexAction extends AppAction
{
    public function run()
    {
        try {
            //确定用户城市
            $request = Yii::$app->request;
            $lng = $request->get('lng');
            $lat = $request->get('lat');
            $gps = BaiduMap::getPosInfo($lng, $lat);

            //拉取机构分类面包屑
            $categorys = UyeCategory::find()->asArray()->all();

            //获取周边的学校
            $templateData = [
                'loaction' => $gps['addressComponent']['city'],
                'categorys' => $categorys
            ];
            Output::info(SUCCESS, SUCCESS_CONTENT, $templateData, $this->newToken);
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }
}