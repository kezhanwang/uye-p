<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/5
 * Time: 下午3:35
 */

namespace common\models\opensearch;


use common\models\ar\UyeOrg;
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
                'status' => $datum['status'],
                'is_shelf' => $datum['is_shelf'],
                'is_employment' => $datum['is_employment'],
                'is_high_salary' => $datum['is_high_salary'],
                'province' => $datum['province'],
                'city' => $datum['city'],
                'area' => $datum['area'],
                'popular' => $datum['org_name'] . ";" . $datum['org_num'] . ";" . $datum['org_name'],
            ];
            array_push($searchData, $tmp);
        }
        self::push(self::SEARCH_ORGANIZE, $searchData);
    }

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
        $pageSize = 10;

        try {
            $searchClient = self::getSearchClient();
            $params = self::getSearchParamsBuilder();
            $params->setStart(($page - 1) * $pageSize);
            //设置config子句的hit值
            $params->setHits($pageSize);
            // 指定一个应用用于搜索
            $params->setAppName(self::$config['appName']);
            // 指定搜索关键词
            $query = "uye:'uye' && kvpairs=lng_b:{$lng},lat_b:{$lat}";
            $params->setQuery($query);
            $filter = "status=" . UyeOrg::STATUS_OK . " AND is_shelf=" . UyeOrg::IS_SHELF_ON;
            $params->setFilter($filter);
            // 指定返回的搜索结果的格式为json
            $params->setFormat("fulljson");
            //添加排序字段
            $params->addSort('RANK', 1);
            // 执行搜索，获取搜索结果
            $ret = $searchClient->execute($params->build());
            // 将json类型字符串解码
            $result = json_decode($ret->result, true);
            $tmpArr = self::resultFormat($result, $lng, $lat, $page, $pageSize);
            return $tmpArr;
        } catch (UException $exception) {
            throw new UException($exception->getMessage(), $exception->getCode());
        }
    }

    public static function getSearchOrgs($words, $lng, $lat, $page = 1)
    {
        if (!is_numeric($lng) || empty($lng) || !is_numeric($lat) || empty($lat)) {
            throw new UException(ERROR_GPS_LOCATION_CONTENT, ERROR_GPS_LOCATION);
        }

        try {
            $filterWords = self::strFilter($words);
            $pageSize = 10;

            $searchClient = self::getSearchClient();
            $params = self::getSearchParamsBuilder();
            $params->setStart(($page - 1) * $pageSize);
            //设置config子句的hit值
            $params->setHits($pageSize);
            // 指定一个应用用于搜索
            $params->setAppName(self::$config['appName']);
            // 指定搜索关键词
            $query = "uye:'uye'";
            if (is_numeric($filterWords)) {
                $query .= ' AND id:"' . $filterWords . '"';
            } else {
                $query .= ' AND default:"' . $filterWords . '"';
            }
            $query .= " && kvpairs=lng_b:{$lng},lat_b:{$lat}";
            $params->setQuery($query);
            $filter = "status=" . UyeOrg::STATUS_OK . " AND is_shelf=" . UyeOrg::IS_SHELF_ON;
            $params->setFilter($filter);
            // 指定返回的搜索结果的格式为json
            $params->setFormat("fulljson");
            //距离计算
            //添加排序字段
            $params->addSort('RANK', 1);
            // 执行搜索，获取搜索结果
            $ret = $searchClient->execute($params->build());

            // 将json类型字符串解码
            $result = json_decode($ret->result, true);
            $tmpArr = self::resultFormat($result, $lng, $lat, $page, $pageSize);
            return $tmpArr;
        } catch (UException $exception) {
            throw new UException($exception->getMessage(), $exception->getCode());
        }
    }

    private static function resultFormat($searchResult, $lng, $lat, $page, $pageSize)
    {
        if (isset($searchResult['status']) && $searchResult['status'] == 'OK' && isset($searchResult['result'])) {
            $getPageArr = [
                'totalCount' => $searchResult['result']['total'],
                'totalPage' => ceil($searchResult['result']['total'] / $pageSize),
                'page' => $page,
                'pageSize' => $pageSize
            ];

            $data = $searchResult['result']['items'];
            foreach ($data as $key => $datum) {
                $list[$key] = $datum['fields'];
                $list[$key]['distance'] = $datum['variableValue']['distance_value'][0] . "km";
                unset($list[$key]['index_name']);
                unset($list[$key]['uye']);
            }

            foreach ($list as &$v) {
                $search = '.cn/';
                $pos = strpos($v['logo'], $search);
                if ($pos === false) {
                    $v['logo'] = "http://img.kezhanwang.cn" . $v['logo'];
                }
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
    }

    //特殊字符串过滤
    public static function strFilter($str)
    {
        if (empty($str)) {
            return '';
        }

        $str = str_replace("!", "", $str);
        $str = str_replace('/', "", $str);
        $str = str_replace("\\", "", $str);
        $str = str_replace(">", "", $str);
        $str = str_replace("<", "", $str);
        $str = str_replace("&", "", $str);
        $str = str_replace(">", "", $str);
        $str = str_replace("<", "", $str);
        $str = str_replace("''", "", $str);
        $str = str_replace("(", "", $str);
        $str = str_replace("（", "", $str);
        $str = str_replace(")", "", $str);
        $str = str_replace("）", "", $str);
        $str = str_replace("[", "", $str);
        $str = str_replace("]", "", $str);
        $str = str_replace("*", "", $str);
        $str = str_replace("|", "", $str);
        return $str;
    }
}