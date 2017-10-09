<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/30
 * Time: 下午5:38
 */

namespace common\models\opensearch;

require_once(PATH_BASE . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "OpenSearch" . DIRECTORY_SEPARATOR . "Autoloader" . DIRECTORY_SEPARATOR . "Autoloader.php");

use components\UException;
use OpenSearch\Client\AppClient;
use OpenSearch\Client\OpenSearchClient;
use OpenSearch\Client\DocumentClient;
use OpenSearch\Client\SearchClient;
use OpenSearch\Util\SearchParamsBuilder;

class SearchOS
{
    /**
     * 机构搜索
     */
    const SEARCH_ORGANIZE = 'tbl_organize';
    /**
     * 客户端链接信息
     * @var null
     */
    public static $client = null;

    /**
     * 配置项
     * @var array
     */
    public static $config = array();


    /**
     * openSearch服务客户端链接
     * @return null|OpenSearchClient
     * @throws UException
     */
    public static function getClient()
    {
        if (self::$client) {
            return self::$client;
        }
        try {
            self::$config = \Yii::$app->params['openSearch'];
            if (empty(self::$config)) {
                throw new UException();
            }
            self::$client = new OpenSearchClient(self::$config['accessKeyId'], self::$config['secret'], self::$config['endPoint'], self::$config['options']);
        } catch (UException $exception) {
            throw new UException($exception->getMessage(), $exception->getCode());
        }
    }


    /**
     * @return SearchClient
     * @throws UException
     */
    public static function getSearchClient()
    {
        if (empty(self::$client)) {
            self::getClient();
        }

        try {
            $searchClient = new SearchClient(self::$client);
            return $searchClient;
        } catch (\Exception $exception) {
            throw new UException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @return SearchParamsBuilder
     * @throws UException
     */
    public static function getSearchParamsBuilder()
    {
        if (empty(self::$client)) {
            self::getClient();
        }

        try {
            $params = new SearchParamsBuilder();
            return $params;
        } catch (\Exception $exception) {
            throw new UException($exception->getMessage(), $exception->getCode());
        }
    }


    const PUSH_CMD_ADD = 'ADD';
    const PUSH_CMD_UPDATE = 'UPDATE';
    const PUSH_CMD_DELETE = 'DELETE';

    /**
     * openSearch推送
     * @param $tableName
     * @param array $data
     * @param string $cmd
     * @return \OpenSearch\Client\OpenSearch\Generated\Common\OpenSearchResult
     * @throws UException
     */
    public static function push($tableName, $data = array(), $cmd = self::PUSH_CMD_ADD)
    {
        if (empty($tableName) || empty($data)) {
            throw new UException();
        }

        if (!in_array($tableName, [self::SEARCH_ORGANIZE])) {
            throw new UException();
        }

        if (!is_array($data)) {
            $pushData[] = $data;
        } else {
            $pushData = $data;
        }

        if (empty(self::$client)) {
            self::getClient();
        }
        try {
            $documentClient = new DocumentClient(self::$client);

            $docs_to_upload = array();

            foreach ($pushData as $pushDatum) {
                $item = [];
                $item['cmd'] = $cmd;
                $item['fields'] = $pushDatum;
                $docs_to_upload[] = $item;
            }

            $json = json_encode($docs_to_upload);
            $ret = $documentClient->push($json, self::$config['appName'], $tableName);
            return $ret;
        } catch (\Exception $exception) {
            throw new UException($exception->getMessage(), $exception->getCode());
        }
    }
}
