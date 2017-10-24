<?php
$userInfo = \e\components\RbacUtil::checkUserRight(Yii::$app->user->getId());
?>
<!-- header section start-->
<div class="header-section">

    <!--toggle button start-->
    <a class="toggle-btn"><i class="fa fa-bars"></i></a>
    <!--toggle button end-->

    <!--notification menu start -->
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