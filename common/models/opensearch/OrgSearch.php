<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/5
 * Time: 下午3:35
 */

namespace common\models\opensearch;


use components\NearbyUtil;
use components\UException;

class OrgSearch extends SearchOS
{
    /**
     * 创建机构搜索索引
     * @param array $data
     * @throws UException
     */
    public static function createPush($data = array())
    {
        if (empty($data) || !is_array($data)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        $searchData = [];
        foreach ($data as $datum) {
            $tmp = [
                'id' => $datum['id'],
                'org_name' => $datum['org_name'],
                'address' => $datum['address'],
                'phone' => $datum['phone'],
                'map_lng' => $datum['map_lng'],
                'map_lat' => $datum['map_lat'],
                'uye' => 'uye',
                'employment_index' => $datum['employment_index'],
                'avg_course_price' => $datum['avg_course_price'],
                'category' => $datum['category'],
                'logo' => $datum['logo'],
            ];
            array_push($searchData, $tmp);
        }
        self::push(self::SEARCH_ORGANIZE, $searchData);
    }


    public static function getSearch($search)
    {
        try {
            $searchClient = self::getSearchClient();
            $params = self::getSearchParamsBuilder();
            $params->setStart(0);
            //设置config子句的hit值
            $params->setHits(20);
            // 指定一个应用用于搜索
            $params->setAppName(self::$config['appName']);
            // 指定搜索关键词
            $params->setQuery("default:'恒企'");
            // 指定返回的搜索结果的格式为json
            $params->setFormat("fulljson");
            //添加排序字段
            $params->addSort('RANK', 0);
            // 执行搜索，获取搜索结果
            $ret = $searchClient->execute($params->build());
            // 将json类型字符串解码
            return json_decode($ret->result, true);
        } catch (UException $exception) {
            throw new UException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * 搜索学校范围
     * @return type
     */
    public static $distanceRange = array(
        '0-1' => '1千米以内',
        '0-3' => '3千米以内',
        '0-5' => '5千米以内',
        '0-10' => '10千米以内',
    );


    /**
     * 附近机构搜索
     * @param $lng
     * @param $lat
     * @param int $page
     * @return mixed
     * @throws UException
     */
    public static function locationSearch($lng, $lat, $page = 1)
    {
        if (!is_numeric($lng) || empty($lng) || !is_numeric($lat) || empty($lat)) {
            throw new UException(ERROR_GPS_LOCATION_CONTENT, ERROR_GPS_LOCATION);
        }

        $points_arr = NearbyUtil::getNearPoint($lng, $lat, 10);
        $points = array(
            'lng1' => $points_arr['left-top']['lng'],
            'lat1' => $points_arr['left-top']['lat'],
            'lng2' => $points_arr['right-bottom']['lng'],
            'lat2' => $points_arr['right-bottom']['lat'],
        );
        $pageSize = 5;

        try {
            $searchClient = self::getSearchClient();
            $params = self::getSearchParamsBuilder();
            $params->setStart(($page - 1) * $pageSize);
            //设置config子句的hit值
            $params->setHits($pageSize);
            // 指定一个应用用于搜索
            $params->setAppName(self::$config['appName']);
            // 指定搜索关键词
            $params->setQuery("uye:'uye'");
            $filter = 'map_lng>=' . $points['lng1'] . ' AND map_lng<=' . $points['lng2'] . ' AND map_lat>=' . $points['lat2'] . ' AND map_lat<=' . $points['lat1'];

            $params->setFilter($filter);
            // 指定返回的搜索结果的格式为json
            $params->setFormat("fulljson");
            //添加排序字段
            $params->addSort('RANK', 0);
            // 执行搜索，获取搜索结果
            $ret = $searchClient->execute($params->build());
            // 将json类型字符串解码
            $result = json_decode($ret->result, true);
            if (isset($result['status']) && $result['status'] == 'OK' && isset($result['result'])) {
                $getPageArr = [
                    'totalCount' => $result['result']['total'],
                    'totalPage' => ceil($result['result']['total'] / $pageSize),
                    'page' => $page,
                    'pageSize' => $pageSize
                ];

                $data = $result['result']['items'];
                $distances = [];
                $list = [];
                foreach ($data as $datum) {
                    $list[$datum['fields']['id']] = $datum['fields'];
                    $list[$datum['fields']['id']]['distance'] = NearbyUtil::getDistance($lng, $lat, $datum['fields']['map_lng'], $datum['fields']['map_lat']);
                    unset($list[$datum['fields']['id']]['index_name']);
                    $distances[] = $list[$datum['fields']['id']]['distance'];
                }

                array_multisort($distances, SORT_ASC, $list);
                foreach ($list as &$v) {
                    $v['distance'] = $v['distance'] > 999 ? round($v['distance'] / 1000, 2) . 'km' : $v['distance'] . 'm';
                }
                $tmpArr = [
                    'page' => $getPageArr,
                    'organizes' => $list
                ];
            } else {
                $tmpArr = [
                    'page' => ['totalCount' => 0, 'totalPage' => 0, 'page' => $page, 'pageSize' => $pageSize],
                    'organizes' => [],
                ];
            }
            return $tmpArr;
        } catch (UException $exception) {
            throw new UException($exception->getMessage(), $exception->getCode());
        }

    }
}