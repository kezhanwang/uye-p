<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/9
 * Time: 上午11:36
 */

namespace app\modules\app\actions;

use common\models\ar\UyeCategory;
use common\models\ar\UyeOrg;
use common\models\ar\UyeOrgInfo;
use components\BaiduMap;
use components\NearbyUtil;
use frontend\models\DataBus;
use Yii;
use app\modules\app\components\AppAction;
use components\Output;
use components\UException;

class IndexAction extends AppAction
{
    private $pageSize = 10;


    public function run()
    {
        try {
            //确定用户城市
            $request = Yii::$app->request;
            $lng = $request->get('lng');
            $lat = $request->get('lat');
            $gps = BaiduMap::getPosInfo($lng, $lat);

            $dist = $request->get('dist');
            $page = $request->get('page', 1);

            //拉取机构分类面包屑
            $categorys = UyeCategory::find()->asArray()->all();

            $location = $this->location($lng, $lat, $dist, $page);
            //获取周边的学校
            $templateData = [
                'loaction' => $gps['addressComponent']['city'],
                'categorys' => $categorys,
                'location' => $location
            ];
            Output::info(SUCCESS, SUCCESS_CONTENT, $templateData, $this->token());
        } catch (UException $exception) {
            Output::err($exception->getCode(), $exception->getMessage(), array(), DataBus::get('uid'), $this->token());
        }
    }

    public function location($lng, $lat, $dist, $page = 1)
    {
        if (!is_numeric($lng) || !is_numeric($lat)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        if (empty($dist)) {
            foreach (NearbyUtil::$distanceRange as $key => $val) {
                list($notdist, $distance) = explode('-', $key);
                //重置
                $schools = $this->getSchools($lng, $lat, $distance, $notdist);
                $count = count($schools);
                if ($count > $this->pageSize) {
                    break;
                }
            }
        } else {
            if (!array_key_exists($dist, NearbyUtil::$distanceRange)) {
                throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
            }
            list($notdist, $distance) = explode('-', $dist);
            $schools = $this->getSchools($lng, $lat, $distance, $notdist);
        }
        $list = $this->schoolFormat($schools, $lng, $lat);
        $data = array_slice($list, ($page - 1) * $this->pageSize, $this->pageSize, true);
        $result = array(
            'organizes' => $data,
//            'distanceRange' => NearbyUtil::$distanceRange,
            'page' => $this->getPage($page, count($list)),
//            'distance' => $dist,
        );
        return $result;
    }

    private function getSchools($lng, $lat, $distance, $notdist)
    {
        $points_arr = NearbyUtil::getNearPoint($lng, $lat, $distance);
        $points = array(
            'lng1' => $points_arr['left-top']['lng'],
            'lat1' => $points_arr['left-top']['lat'],
            'lng2' => $points_arr['right-bottom']['lng'],
            'lat2' => $points_arr['right-bottom']['lat'],
        );
        if (empty($notdist)) {
            $schools = $this->NearbySchools($points);
        } elseif (is_numeric($notdist)) {
            $not_points_arr = self::getNearPoint($lng, $lat, $notdist);
            $not_points = array(
                'lng1' => $not_points_arr['left-top']['lng'],
                'lat1' => $not_points_arr['left-top']['lat'],
                'lng2' => $not_points_arr['right-bottom']['lng'],
                'lat2' => $not_points_arr['right-bottom']['lat'],
            );
            $schools = $this->NearbySchools($points, $not_points);
        } else {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }
        return $schools;
    }

    private function NearbySchools($points, $not_points = array(), $page = 1)
    {
        //$lng1 左上角经度  //$lat1 左上角纬度  //$lng1 左上角经度  //$lat1 左上角纬度
        if (empty($points)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }
        $fields = "o.id,o.org_name,oi.employment_index,oi.avg_course_price,oi.category_1,c.name as category,oi.map_lng,oi.map_lat,oi.logo";
        $query = (new \yii\db\Query())
            ->select($fields)
            ->from(UyeOrg::TABLE_NAME . " o")
            ->leftJoin(UyeOrgInfo::TABLE_NAME . " oi", "oi.org_id=o.id")
            ->leftJoin(UyeCategory::TABLE_NAME . " c", "c.id=oi.category_1");

        if (empty($not_points)) {
            $query->where("oi.map_lng BETWEEN :lng1 AND :lng2 AND oi.map_lat BETWEEN :lat1 AND :lat2", [':lng1' => $points['lng1'], ':lng2' => $points['lng2'], ':lat1' => $points['lat2'], ':lat2' => $points['lat1']]);
        } else {
            $query->where("((oi.map_lng >= :lng1 OR oi.map_lng< :lng2) OR (oi.map_lng >= :lng3 OR oi.map_lng< :lng4)) OR ((oi.map_lat >= :lat1 OR oi.map_lat< :lat2) OR (oi.map_lat >= :lat3 OR oi.map_lat< :lat4))",
                [
                    ':lng1' => $points['lng1'], ':lng2' => $not_points['lng1'], ':lng3' => $points['lng2'], ':lng4' => $not_points['lng2'],
                    ':lat1' => $points['lat1'], ':lat2' => $not_points['lat1'], ':lat3' => $points['lat2'], ':lat4' => $not_points['lat2']
                ]
            );
        }
        $result = $query->all();
        return $result;
    }

    private function schoolFormat($schools, $lng, $lat)
    {
        if (empty($schools)) return array();
        $list = $distance = array();
        foreach ($schools as $val) {
            $list[$val['id']]['id'] = $val['id'];
            $list[$val['id']]['org_name'] = $val['org_name'];
            $list[$val['id']]['logo'] = $val['logo'];
            $list[$val['id']]['employment_index'] = $val['employment_index'];
            $list[$val['id']]['avg_course_price'] = $val['avg_course_price'];
            $list[$val['id']]['category'] = $val['category'];
//            $list[$val['id']]['lng'] = $val['map_lng'];
//            $list[$val['id']]['lat'] = $val['map_lat'];
            $list[$val['id']]['distance'] = NearbyUtil::getDistance($lng, $lat, $val['map_lng'], $val['map_lat']);
            $distances[] = $list[$val['id']]['distance'];
        }
        //根据距离由近到远进行排序
        array_multisort($distances, SORT_ASC, $list);
        foreach ($list as &$v) {
            $v['distance'] = $v['distance'] > 999 ? round($v['distance'] / 1000, 2) . 'km' : $v['distance'] . 'm';
        }
        return $list;
    }

    private function getPage($page, $count)
    {
        return array(
            'page' => $page,
            'totalCount' => $count,
            'totalPage' => ceil($count / $this->pageSize),
            'pageSize' => $this->pageSize,
        );
    }
}