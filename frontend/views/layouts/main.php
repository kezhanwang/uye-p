<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="北京中腾汇达投资管理有限公司，U业帮">
    <meta name="description" content="北京中腾汇达投资管理有限公司">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?>-北京中腾汇达投资管理有限公司</title>

    <?php $this->head() ?>
    <!--[if lt IE 9]>
    <script src="/js/html5shiv.js"></script>
    <script src="/js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="header-sticky">
<?php $this->beginBody() ?>

<!-- Preloader -->
<section class="loading-overlay">
    <div class="Loading-Page">
        <h2 class="loader">Loading</h2>
    </div>
</section>
<!-- Boxed -->
<div class="boxed">
    <!-- Header -->
    <header id="header" class="header header-classic clearfix">
        <div class="container">
            <div class="row">
                <div class="header-wrap clearfix">
                    <div class="col-md-4">
                        <div id="logo" class="logo mgl2">
                            <a href="/" rel="home">
                                <img src="/images/logo.png" alt="image">
                            </a>
                        </div><!-- /.logo -->
                        <div class="btn-menu">
                            <span></span>
                        </div><!-- //mobile menu button -->
                    </div>
                    <div class="col-md-8">
                        <div class="nav-wrap">
                            <nav id="mainnav" class="mainnav">
                                <ul class="menu">
                                    <li><a href="/">首页</a></li>
                                </ul><!-- /.menu -->
                            </nav><!-- /.mainnav -->
                        </div><!-- /.nav-wrap -->
                    </div>
                </div><!-- /.header-inner -->
            </div><!-- /.row -->
        </div>
    </header><!-- /.header -->
    <?= $content ?>
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="widget widget-infomation">
                        <h3 class="logo-footer"><a href="/" rel="home">
                                <img src="/images/logo.png" alt="image">
                            </a></h3>
                        <p><?= Yii::$app->params['company_name']; ?></p>
                        <ul class="flat-information">
                            <!--                            <li class="phone"><a href="#"></a></li>-->
                            <!--                            <li class="address"><a href="#">J</a></li>-->
                            <!--                            <li class="email"><a href="#"></a></li>-->
                            <!--                            <li class="skype"><a href="#"></a></li>-->
                        </ul>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="widget widget-out-link">
                        <h4 class="widget-title">链接</h4>
                        <ul class="one-half">
                            <li><a href="/">首页</a></li>
                        </ul>
                        <ul class="one-half">

                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="widget widget-letter">
                        <h4 class="widget-title">下载U业帮APP</h4>
                        <img src="http://res1.kezhanwang.cn/static/images/qrcode_app_abda20.png" style="width: 104px">
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="bottom">
        <div class="container">
            <div class="copyright">
                <p> &copy; <?= date('Y'); ?> Bjzhongteng.com <?= Yii::$app->params['company_name']; ?>
                    京ICP备17053228号-1</p>
            </div>
        </div>
    </div>
    <a class="go-top">
        <i class="fa fa-angle-up"></i>
    </a>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
