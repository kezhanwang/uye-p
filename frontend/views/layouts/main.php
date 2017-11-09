<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
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
<!--                                    <li><a href="/about">关于我们</a></li>-->
<!--                                    <li><a href="/contact">联系方式</a></li>-->
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
            <div class="row" align="center">
                <p> &copy; 2017 Bjzhongteng.com <?= Yii::$app->params['company_name'];?>  京ICP备17053228号-1</p>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </footer>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
