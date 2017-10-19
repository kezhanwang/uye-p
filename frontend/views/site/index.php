<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->name;
?>

<form action="/common/upload" method="post" enctype="multipart/form-data">
    <input type="file" name="fileUpload"/>
    <input type="submit" value="上传文件"/>
</form>