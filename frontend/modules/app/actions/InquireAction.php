<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/10
 * Time: 上午10:06
 */

namespace app\modules\app\actions;

use common\models\ar\UyeSearchLog;
use common\models\opensearch\OrgSearch;
use components\UException;
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
                'word' => OrgSearch::strFilter($this->getParams('word', '')),
                'map_lng' => $this->getParams('map_lng', ''),
                'map_lat' => $this->getParams('map_lat', ''),
                'page' => $this->getParams('page', 1)
            ];


            $data = OrgSearch::getSearchOrgs($params['word'], $params['map_lng'], $params['map_lat'], $params['page']);
            $this->addSearchLog($params['map_lng'], $params['map_lat'], DataBus::get('uid'), $params['word'], $request->get());
            foreach ($data['organizes'] as &$organize) {
                $organize['org_id'] = $organize['id'];
                unset($organize['id']);
            }
            Output::info(SUCCESS, SUCCESS_CONTENT, $data);
        } catch (\Exception $exception) {
            Output::err($exception->getCode(), $exception->getMessage());
        }
    }

    private function addSearchLog($lng, $lat, $uid, $words, $request)
    {
        try {
            $filterWords = OrgSearch::strFilter($words);
            UyeSearchLog::addSearchLog($lng, $lat, $uid, $words, $filterWords, json_encode($request));
        } catch (UException $exception) {
            Yii::error();
        }

    }
}