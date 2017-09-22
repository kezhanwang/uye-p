<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/22
 * Time: 下午3:54
 */

namespace backend\components;

use Yii;
use yii\web\Controller;

class UAdminController extends Controller
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
//        $this->rbacConfInit();
    }

    /**
     * 初始化rbac 配置初始化
     */
    protected function rbacConfInit()
    {
        Yii::$container->set('mdm\admin\components\Configs',
            [
                'db' => 'customDb',
                'menuTable' => 'uye_admin_menu',
                'userTable' => 'uye_admin_user',
            ]
        );
    }
}