<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/10
 * Time: 下午12:01
 */

namespace common\models\queue;

use AliyunMNS\Client;
use AliyunMNS\Exception\MnsException;
use AliyunMNS\Requests\CreateQueueRequest;
use AliyunMNS\Requests\SendMessageRequest;
use components\UException;
use yii\db\Exception;

require_once(PATH_BASE . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "libraries" . DIRECTORY_SEPARATOR . "mns" . DIRECTORY_SEPARATOR . "mns-autoloader.php");

class QueueOS
{
    /**
     * 队列链接
     * @var null
     */
    protected static $client = null;

    /**
     * 获取客户端链接
     * @return Client|null
     * @throws UException
     */
    public static function getClient()
    {
        if (!empty(self::$client)) {
            return self::$client;
        }

        $config = \Yii::$app->params['mns'];
        if (empty($config)) {
            throw new UException(ERROR_SYS_PARAMS_CONTENT, ERROR_SYS_PARAMS);
        }

        try {
            self::$client = new Client($config['endPoint'], $config['accessId'], $config['accessKey']);
            return self::$client;
        } catch (MnsException $exception) {
            throw new UException($exception->getMessage(), $exception->getMnsErrorCode());
        }
    }

    /**
     * 最长队列名和key长度
     */
    const MAX_STR_LEN = 64;

    /**
     * 队列缓存
     * @var type
     */
    private static $queues = array();

    /**
     * 创建队列
     * @param $queueName 队列名
     * @param null $attributes 队列属性
     * @return mixed
     * @throws UException
     * @throws \AliyunMNS\InvalidArgumentException
     * @throws \AliyunMNS\MnsException
     * @throws \AliyunMNS\QueueAlreadyExistException
     */
    public static function createQueue($queueName, $attributes = null)
    {
        if (!is_string($queueName) || strlen($queueName) >= self::MAX_STR_LEN) {
            throw new UException();
        }

        if (isset(self::$queues[$queueName])) {
            return self::$queues[$queueName];
        }

        $client = self::getClient();

        try {
            self::$queues[$queueName] = $client->getQueueRef($queueName);
            if (isset(self::$queues[$queueName])) {
                return self::$queues[$queueName];
            }
        } catch (MnsException $exception) {
            throw new UException();
        }

        try {
            $request = new CreateQueueRequest($queueName, $attributes);
            $client->createQueue($request);
            self::$queues[$queueName] = $client->getQueueRef($queueName);
            return self::$queues[$queueName];
        } catch (MnsException $exception) {
            throw new UException($exception->getMessage(), $exception->getMnsErrorCode());
        }
    }

    /**
     * 删除队列
     * @param $queueName 队列名
     * @throws UException
     */
    public static function deleteQueue($queueName)
    {
        $client = self::getClient();
        try {
            $client->deleteQueue($queueName);
            unset(self::$queues[$queueName]);
        } catch (MnsException $exception) {
            throw new UException($exception->getMessage(), $exception->getMnsErrorCode());
        }
    }

    /**
     * 发送消息
     * @param $queueName 队列名
     * @param $msg 消息内容
     * @param null $delaySeconds 延迟出现的描述
     * @param null $priority 优先级
     * @return mixed
     * @throws UException
     * @throws \AliyunMNS\InvalidArgumentException
     * @throws \AliyunMNS\MnsException
     * @throws \AliyunMNS\QueueAlreadyExistException
     */
    public static function sendMessage($queueName, $msg, $delaySeconds = null, $priority = null)
    {
        if (!is_string($msg)) {
            $msg = json_encode($msg);
        }
        $queue = self::createQueue($queueName);
        $bodyMD5 = strtoupper(md5(base64_encode($msg)));
        try {
            $request = new SendMessageRequest($msg, $delaySeconds, $priority);
            $result = $queue->sendMessage($request);

            $sendMD5 = strtoupper($result->getMessageBodyMD5());
            if ($sendMD5 != $bodyMD5) {
                throw new UException();
            }
            return $result->getMessageId();
        } catch (MnsException $exception) {
            throw new UException($exception->getMessage(), $exception->getMnsErrorCode());
        }
    }

    /**
     * 接受消息
     * @param $queueName 队列名
     * @param string $msgId 消息id
     * @param int $waitSeconds 等待时间，最大为30s
     * @param bool $needDelete 是否删除，默认接受后删除
     * @return mixed
     * @throws UException
     * @throws \AliyunMNS\InvalidArgumentException
     * @throws \AliyunMNS\MnsException
     * @throws \AliyunMNS\QueueAlreadyExistException
     */
    public static function receiveMessage($queueName, &$msgId = '', $waitSeconds = 0, $needDelete = true)
    {
        $queue = self::createQueue($queueName);
        try {
            $result = $queue->receiveMessage($waitSeconds);
            $msgId = $result->getMessageId();
            $body = $result->getMessageBody();

            if ($needDelete) {
                $receiptHandle = $result->getReceiptHandle();
                $queue->deleteMessage($receiptHandle);
            }
            return $body;
        } catch (MnsException $exception) {
            throw new UException($exception->getMessage(), $exception->getMnsErrorCode());
        }
    }
}