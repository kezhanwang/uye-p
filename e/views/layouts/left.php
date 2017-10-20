<?php
$menus = \common\models\ar\UyeEMenu::getMenus();
?>
<!-- left side start-->
<div class="left-side sticky-left-side">

    <!--logo and iconic logo start-->
    <div class="logo" align="center" style=" padding:10px 0;">
        <a href="index.html"><img src="/images/logo.png" alt="" align="center"></a>
    </div>

    <div class="logo-icon text-center" align="center" style=" padding:10px 0;">
        <a href="index.html"><img src="/images/logo.png" alt=""></a>
    </div>
    <!--logo and iconic logo end-->

    <div class="left-side-inner">

        <!-- visible to small devices only -->
        <div class="visible-xs hidden-sm hidden-md hidden-lg">
            <div class="media logged-user">
                <img alt="" src="/images/photos/user-avatar.png" class="media-object">
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

        <?= \e\assets\Menu::widget(
            [
                'options' => ['class' => 'nav nav-pills nav-stacked custom-nav'],
                'items' => $menus
            ]
        ) ?>
    </div>
</div>
<!-- left side end-->