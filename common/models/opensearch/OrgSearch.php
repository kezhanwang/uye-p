<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/5
 * Time: 下午3:35
 */

namespace common\models\opensearch;


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
                'name' => $datum['name'],
                'address' => $datum['address'],
                'phone' => $datum['phone'],
                'map_lng' => $datum['map_lng'],
                'map_lat' => $datum['map_lat'],
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
     * @param $dist
     * @param int $page
     * @return mixed
     * @throws UException
     */
    public static function locationSearch($lng = null, $lat = null, $dist, $page = 1)
    {
        if ($lng == null || $lat == null) {
            throw new UException(ERROR_GPS_LOCATION_CONTENT, ERROR_GPS_LOCATION);
        }
        if (empty($dist)) {
            foreach (self::$distanceRange as $key => $value) {
                list($notdist, $distance) = explode('-', $key);

            }
        } else {
            if (!array_key_exists($dist, self::$distanceRange)) {
                throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
            }
        }


        try {
            $searchClient = self::getSearchClient();
            $params = self::getSearchParamsBuilder();
            $params->setStart(0);
            //设置config子句的hit值
            $params->setHits(20);
            // 指定一个应用用于搜索
            $params->setAppName(self::$config['appName']);
            // 指定搜索关键词
            $query = "map_lng:'" . $lng . "'" . " AND " . "map_lat:'" . $lat . "'";
            $params->setQuery("id:'100'");
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
}