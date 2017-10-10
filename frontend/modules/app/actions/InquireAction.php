<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/10
 * Time: 上午10:06
 */

namespace app\modules\app\actions;

use common\models\opensearch\OrgSearch;
use Yii;
use app\modules\app\components\AppAction;
use components\Output;
use frontend\models\DataBus;

class InquireAction extends AppAction
{
    public function run()
    {
        try {
            $request = Yii::$app->request;
            $params = [
                'word' => $request->get('word', ''),
                'map_lng' => $request->get('map_lng', ''),
                'map_lat' => $request->get('map_lat', ''),
                'page' => $request->get('page', 1)
            ];

            if ($params['word'] == 'location') {
                $data = OrgSearch::locationSearch($params['map_lng'], $params['map_lat'], $params['page']);
            } else {
                $data = array();
            }
            Output::info(SUCCESS, SUCCESS_CONTENT, $data, $this->token());
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage(), [], DataBus::get('uid'), $this->token());
        }
    }
}