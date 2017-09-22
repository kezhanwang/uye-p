<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/9/22
 * Time: 下午4:48
 */

namespace backend\models;


use common\models\ar\UyeAdminMenu;

class AdminMenu
{
    public static function createMenus()
    {
        $menus = UyeAdminMenu::getMenus();

        $menuItems = [];

        $requestURI = $_SERVER['REQUEST_URI'];

        foreach ($menus as $key => $menu) {
            if ($menu['parent'] == 0) {
                $menuItems[$menu['id']] = array(
                    'icon' => !empty($menu['icon']) ? $menu['icon'] : 'circle-o',
                    'label' => $menu['name'],
                    'url' => $menu['route'],
                    'options' => [],
                    'items' => []
                );
                if ($requestURI == $menu['route']) {
                    $menuItems[$menu['id']]['options'] = ['class' => 'active'];
                }
                unset($menus[$key]);
            }
        }

        foreach ($menus as $key => $menu) {
            if (array_key_exists($menu['parent'], $menuItems)) {
                $menuItems[$menu['parent']]['items'][$menu['id']] = array(
                    'icon' => !empty($menu['icon']) ? $menu['icon'] : 'share',
                    'label' => $menu['name'],
                    'url' => $menu['route'],
                    'options' => [],
                    'items' => []
                );
                $menuItems[$menu['parent']]['options'] = ['class' => 'treeview'];
                if ($requestURI == $menu['route']) {
                    $menuItems[$menu['parent']]['items'][$menu['id']]['options'] = ['class' => 'active'];
                    $menuItems[$menu['parent']]['options'] = ['class' => 'treeview active'];
                }
            }
        }

        return $menuItems;
    }

    public static function getMenuByRequestURI()
    {
        $requestURI = $_SERVER['REQUEST_URI'];
        return UyeAdminMenu::getMenuByRoute($requestURI);
    }
}