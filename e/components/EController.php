<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/22
 * Time: 下午3:54
 */

namespace e\components;

use  Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class EController extends Controller
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->checkLogin();
    }

    public function checkLogin()
    {
        if (!Yii::$app->user->isGuest) {
            $org_id = Yii::$app->user->identity->org_id;
            $org_id = '';
//            var_dump($org_id);
            if (empty($org_id)) {
                throw new BadRequestHttpException("未绑定机构信息");
            }
        }
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