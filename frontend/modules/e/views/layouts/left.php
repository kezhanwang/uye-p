<?php
$menus = \common\models\ar\UyeOrgManageMenu::getMenus();
?>
<!-- left side start-->
<div class="left-side sticky-left-side">

    <!--logo and iconic logo start-->
    <div class="logo" align="center" style=" padding:10px 0;">
        <a href="index.html"><img src="/e/images/logo.png" alt="" align="center"></a>
    </div>

    <div class="logo-icon text-center" align="center" style=" padding:10px 0;">
        <a href="index.html"><img src="/e/images/logo.png" alt=""></a>
    </div>
    <!--logo and iconic logo end-->

    <div class="left-side-inner">

        <!-- visible to small devices only -->
        <div class="visible-xs hidden-sm hidden-md hidden-lg">
            <div class="media logged-user">
                <img alt="" src="/e/images/photos/user-avatar.png" class="media-object">
                <div class="media-body">
                    <h4><a href="#">John Doe</a></h4>
                    <span>"Hello There..."</span>
                </div>
            </div>

            <h5 class="left-nav-title">Account Information</h5>
            <ul class="nav nav-pills nav-stacked custom-nav">
                <li><a href="#"><i class="fa fa-user"></i> <span>Profile</span></a></li>
                <li><a href="#"><i class="fa fa-cog"></i> <span>Settings</span></a></li>
                <li><a href="#"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
            </ul>
        </div>

        <?= \app\modules\e\assets\Menu::widget(
            [
                'options' => ['class' => 'nav nav-pills nav-stacked custom-nav'],
                'items' => $menus
            ]
        ) ?>

        <!--sidebar nav start-->
        <!--        <ul class="nav nav-pills nav-stacked custom-nav">-->
        <!---->
        <!---->
        <!--            <li class="active"><a href="index.html"><i class="fa fa-home"></i> <span>首页</span></a></li>-->
        <!--            <li class="menu-list"><a href=""><i class="fa fa-tasks"></i> <span>保单管理</span></a>-->
        <!--                <ul class="sub-menu-list">-->
        <!--                    <li><a href="blank_page.html"> Blank Page</a></li>-->
        <!--                    <li><a href="boxed_view.html"> Boxed Page</a></li>-->
        <!--                    <li><a href="leftmenu_collapsed_view.html"> Sidebar Collapsed</a></li>-->
        <!--                    <li><a href="horizontal_menu.html"> Horizontal Menu</a></li>-->
        <!---->
        <!--                </ul>-->
        <!--            </li>-->
        <!--            <li><a href="login.html"><i class="fa fa-sign-in"></i> <span>退出</span></a></li>-->
        <!--        </ul>-->
        <!--        <!--sidebar nav end-->

    </div>
</div>
<!-- left side end-->