<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/18
 * Time: 下午5:06
 */

use yii\helpers\Html;

$this->title = Yii::$app->name . "机构管理平台";
if (Yii::$app->controller->action->id === 'login') {
    /**
     * Do not use this code in your template. Remove it.
     * Instead, use the code  $this->layout = '//main-login'; in your controller.
     */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {
    \e\assets\AppAsset::register($this);
    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@webroot');
    ?>

    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <script type="text/javascript">
            window.__async = [];
        </script>
    </head>
    <body class="sticky-header left-side-collapsed">
    <?php $this->beginBody() ?>
    <section>
        <?= $this->render(
            'left.php', ['directoryAsset' => $directoryAsset]
        )
        ?>
        <!-- main content start-->
        <div class="main-content">
            <?= $this->render(
                'header.php', ['directoryAsset' => $directoryAsset]
            ) ?>

            <?= $this->render(
                'content.php',
                ['content' => $content, 'directoryAsset' => $directoryAsset]
            ) ?>
        </div>
    </section>
    <?php $this->endBody() ?>
    <script type="text/javascript">
        NProgress.start();
        
        $(document).ready(function () {
            for (var i = 0; i < window.__async.length; i++) {
                window.__async[i]();
            }
            NProgress.done();
        });
    </script>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
