<?php
//$menuItmes = \mdm\admin\components\MenuHelper::getAssignedMenu(Yii::$app->user->id, null, function ($menu) {
//    $data = empty($menu['data']) ? [] : json_decode($menu['data'], true);
//    $icon = 'fa fa-circle-o';
//    if (isset($data['icon'])) {
//        $icon = $data['icon'];
//        unset($data['icon']);
//    }
//
//    $route = parse_url($menu['route']);
//    $url = [];
//    if (isset($route['query'])) {
//        parse_url($route['query'], $url);
//    }
//    array_unshift($url, $route['path']);
//    return [
//        'icon' => $icon,
//        'label' => $menu['name'],
//        'url' => $url,
//        'options' => $data,
//        'item' => $menu['children']
//    ];
//});
$menuItems = \common\models\ar\UyeAdminMenu::createMenus();
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
