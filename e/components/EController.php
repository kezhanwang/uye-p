<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/22
 * Time: 下午3:54
 */

namespace e\components;

use  Yii;
use yii\web\Controller;

class EController extends Controller
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
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

}