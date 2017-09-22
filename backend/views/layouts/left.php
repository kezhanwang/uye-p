<?php
//$menuItems = \backend\models\AdminMenu::createMenus();
use yii\helpers\Json;
use mdm\admin\components\MenuHelper;
use yii\web\UrlManager;

/**
 * @var \yii\web\View $this
 */
$menuItems = MenuHelper::getAssignedMenu(1,null,function($menu){
    $data = empty($menu['data'])?[]:json_decode($menu['data'], true);
    $icon ='fa fa-circle-o';
    if(isset($data['icon'])){
        $icon = $data['icon'];
        unset($data['icon']);
    }
    $route = parse_url($menu['route']);
    $url = [];
    if(isset($route['query'])) {
        parse_str($route['query'], $url);
    }
    array_unshift($url, $route['path']);
    return [
        'icon' => $icon,
        'label' => $menu['name'],
        'url' => $url,
        'options' => $data,
        'items' => $menu['children']
    ];
});
?>

<aside class="main-sidebar">
    <section class="sidebar">
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => $menuItems,
            ]
        ) ?>
    </section>
</aside>
