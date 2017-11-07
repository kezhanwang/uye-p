<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/15
 * Time: 下午3:45
 */

namespace app\modules\app\components;

use common\models\ar\UyeMobileModel;
use components\CheckUtil;
use components\UException;
use Yii;
use frontend\components\UController;

class AppController extends UController
{
    public $version = null;
    public $plat = 0;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub

        $this->version = $this->getParams('version');
        $this->plat = CheckUtil::checkIsMobile();
        $this->mobileModel();
    }

    /**
     * @param string $key
     * @return array|mixed
     */
    public function getParams($key = '')
    {
        $request = Yii::$app->request;

        $method = strtolower($request->method);
        switch ($method) {
            case 'get':
                return $request->get($key);
                break;
            case 'post':
                return $request->post($key);
                break;
            default:
                return '';
                break;
        }
    }

    /**
     * 计算手机分布情况
     */
    private function mobileModel()
    {
        try {
            if (isset($_SERVER['HTTP_UYEUA'])) {
                $uyeua = $_SERVER['HTTP_UYEUA'];
                $uyeuaArr = explode('||', $uyeua);
                $unique_id = md5($uyeuaArr[4] . $uyeuaArr[5] . $uyeuaArr[6] . $uyeuaArr[7]);
                $filedData = array(
                    'unique_id' => $unique_id,
                    'type' => $this->plat,
                    'brand' => $uyeuaArr[8],
                    'model' => $uyeuaArr[7],
                    'system' => $uyeuaArr[9],
                    'channel' => $uyeuaArr[0],
                    'info' => $uyeua,
                    'created_time' => time(),
                );
                UyeMobileModel::_add($unique_id, $filedData);
            }
        } catch (UException $exception) {
            Yii::error($exception->getMessage());
        }
    }
}