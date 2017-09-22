<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/21
 * Time: 下午6:02
 */

namespace backend\components;


use common\models\ar\UyeAdminMenu;

class MenuHelper
{
    public static function getAssignedMenu()
    {
        $menus = UyeAdminMenu::find()->asArray()->where('status=:status', [':status' => 1])->indexBy('id')->all();
        $key = [__METHOD__, '/login/index'];

        foreach ($menus as $menu) {


        }

    }
}