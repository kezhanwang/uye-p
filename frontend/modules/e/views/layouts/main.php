<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/18
 * Time: 下午5:06
 */

use yii\helpers\Html;

$this->title = Yii::$app->name . "机构管理平台";
\app\modules\e\assets\AppAsset::register($this);
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

</head>
<body class="sticky-header">
<?php $this->beginBody() ?>
<section>
    <?= $this->render(
        'left.php'
    )
    ?>
    <!-- main content start-->
    <div class="main-content">
        <?= $this->render(
            'header.php'
        ) ?>

        <?= $this->render(
            'content.php',
            ['content' => $content]
        ) ?>
    </div>
</section>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

