<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/12
 * Time: 下午4:52
 */

namespace common\models\udcredit;


use common\models\ar\UyeSimg;
use common\models\ar\UyeUserAuth;
use components\HttpUtil;
use components\PicUtil;
use components\UException;

class NotifyHandle
{
    /**
     * 插入用户数据
     * @param $data
     * @return array|bool
     * @throws \components\UException
     */
    public static function updateData($data)
    {
        if (!$data) {
            return false;
        }
        $picArr = ['front_card', 'back_card', 'photo_get', 'photo_grid', 'photo_living'];
        foreach ($picArr as $key) {
            if (isset($data[$key]) && $data[$key]) {
                $result = self::saveImage($data[$key]);
                self::insertSimg($result['path'], $data['uid']);
                $data[$key] = $result['result'] ? $result['path'] : '';
            } else {
                $data[$key] = '';
            }
        }

        return UyeUserAuth::_updateByOrder($data['order'], $data);
    }

    /**
     * 保存图片
     * @param $base64_image_content
     * @return array
     */
    public static function saveImage($base64_image_content)
    {
        $date_dir = DIRECTORY_SEPARATOR . date("Ym") . DIRECTORY_SEPARATOR . date("d");
        $dir = PATH_UPLOAD_SECRET . $date_dir;
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $fileName = date('His') . '_' . intval(microtime(true)) . '_' . rand(1, 9999) . ".png";
        $filePath = $dir . DIRECTORY_SEPARATOR . $fileName;
        $isSuccess = file_put_contents($filePath, base64_decode($base64_image_content));
        $path = $date_dir . DIRECTORY_SEPARATOR . $fileName;
        return ['result' => $isSuccess, 'path' => $path];
    }

    /**
     * 图片入库
     * @param $path 图片路径
     * @param int $uid 用户id
     * @throws UException
     */
    public static function insertSimg($path, $uid = 0)
    {
        list($null, $yearMonth, $day, $fileName) = explode('/', $path);
        $paySimg = array(
            'path' => $path,
            'year_month' => $yearMonth,
            'day' => $day,
            'file_name' => $fileName,
            'file_suffix' => PicUtil::getSuffix($fileName),
            'type' => UyeSimg::SIMG_TYPE_INSTALMENT,
            'uid' => $uid,
            'create_time' => time(),
        );
        $check = UyeSimg::getSimgByPath($path);
        if (!$check) {
            UyeSimg::_insert($paySimg);
        }
    }

    /**
     * 有盾异步通知处理逻辑
     * @param $data
     * @return array|bool
     * @throws \components\UException
     */
    public static function NotifyHandle($data)
    {
        if ($data['result_auth'] === 'T') {
            $data['result_auth'] = UyeUserAuth::RESULT_AUTH_TRUE;
        } else {
            $data['result_auth'] = UyeUserAuth::RESULT_AUTH_FALSE;
        }
        $data['order'] = $data['no_order'];
        unset($data['no_order']);
        $data['id_card'] = $data['id_no'];
        unset($data['id_no']);
        $data['sex'] = $data['gender'] == '女' ? 2 : 1;
        unset($data['gender']);
        $validityDate = explode('-', $data['validity_period']);
        $data['idcard_start'] = str_replace('.', '-', $validityDate[0]);
        $data['idcard_expired'] = $validityDate[1] == '长期' ? '2099-01-01' : str_replace('.', '-', $validityDate[1]);
        return self::updateData($data);
    }

    /**
     * 有盾最新用户报告
     * @param int $id_card
     * @param int $order
     * @return array
     * @throws UException
     * @throws \Exception
     */
    public static function getUserReport($id_card = 0, $order = 0)
    {
        $header[] = 'Content-Type: application/json;charset=UTF-8';
        $data = ['id_no' => $id_card];
        $optArr = array(
            'request' => json_encode($data),
            'header' => $header,
        );

        $config = \Yii::$app->params['udcredit'];
        if (empty($config)) {
            throw new UException(ERROR_SECRET_CONFIG_NO_EXISTS_CONTENT, ERROR_SECRET_CONFIG_NO_EXISTS);
        }

        $sign = strtoupper(md5($optArr['request'] . '|' . $config['merchant_key']));
        $url = "https://api4.udcredit.com/dsp-front/4.1/dsp-front/default/pubkey/" . $config['merchant_key'] . "/product_code/Y1001003/out_order_id/"
            . time() . "/signature/" . $sign;
        $content = HttpUtil::doPost($url, $optArr);
        $ret_info = json_decode($content, true);
        if ($ret_info['header']['ret_code'] == '000000') {
            UyeUserAuth::_updateByOrder($order, ['user_report' => json_encode($ret_info['body']), 'updated_time' => time()]);
            return $ret_info['body'];
        } else {
            return [];
        }
    }
}