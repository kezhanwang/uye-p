<?php
$userInfo = \e\components\RbacUtil::checkUserRight(Yii::$app->user->getId());
?>
<style>
    .org_name span {
        box-shadow: none;
        float: left;
        font-size: 14px;
        height: 35px;
        margin: 7px 0px 0px 10px;
        padding: 10px;
    }
</style>
<div class="header-section">
    <a class="toggle-btn"><i class="fa fa-bars"></i></a>
    <div class="org_name">
        <span><?= $userInfo['org_name']; ?></span>
    </div>
    <div class="menu-right">
        <ul class="notification-menu">
            <li>
                <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-mobile-phone"></i>
                    手机U业帮
                    <span class="caret"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-head pull-right" style="min-width: 129px;">
                    <h5 class="title">下载U业帮客户端</h5>
                    <a href="#">
                        <img src="http://www.bjzhongteng.com/images/1510212394.png" style="width: 128px">
                    </a>

                </div>
            </li>
            <li>
                <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <img src="/images/photos/user-avatar.png" alt=""/>
                    <?= Yii::$app->user->identity->username; ?>(<?= $userInfo['role_name']; ?>)
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                    <li>
                        <a href="<?= \yii\helpers\Url::toRoute(['login/logout']); ?>">
                            <i class="fa fa-sign-out"></i>退出
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>