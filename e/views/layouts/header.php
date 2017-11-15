<?php
$userInfo = \e\components\RbacUtil::checkUserRight(Yii::$app->user->getId());
?>
<style>
    .searchform span {
        box-shadow: none;
        float: left;
        font-size: 14px;
        height: 35px;
        width: 220px;
        margin: 7px 0px 0px 10px;
        padding: 10px;
    }
</style>
<!-- header section start-->
<div class="header-section">

    <!--toggle button start-->
    <a class="toggle-btn"><i class="fa fa-bars"></i></a>

    <div class="searchform" action="index.html" method="post">
        <span><?= $userInfo['org_name']; ?></span>
    </div>

    <div class="menu-right">
        <ul class="notification-menu">
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
    <!--notification menu end -->
</div>
<!-- header section end-->