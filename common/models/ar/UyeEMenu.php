<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/18
 * Time: 下午6:52
 */

namespace common\models\ar;


class UyeEMenu extends UActiveRecord
{
    const TABLE_NAME = 'uye_e_menu';

    public static function tableName()
    {
        return self::TABLE_NAME;
    }

    public static function getMenus()
    {
        $menuList = self::find()->asArray()->all();
        $menus = self::getTree($menuList, 0);

        foreach ($menus as &$menu) {
            if (!empty($menu['items'])) {
                $menu['options'] = ['class' => 'menu-list'];
            }
        }

        return $menus;
    }

    private static function getTree($data, $pID)
    {
        $tree = [];
        foreach ($data as &$datum) {
            if ($datum['parent'] == $pID) {
                $tmpArr = [
                    'icon' => !empty($datum['icon']) ? $datum['icon'] : 'fa fa-circle-o',
                    'label' => $datum['name'],
                    'url' => $datum['route'],
                    'options' => [],
                    'items' => [],
                ];
                $children = self::getTree($data, $datum['id']);
                $tmpArr['items'] = $children;
                $tree[] = $tmpArr;
            }
        }
        return $tree;
    }


}