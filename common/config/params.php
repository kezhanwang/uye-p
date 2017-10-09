<?php


$params = [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'company_name' => '北京中腾惠达投资有限公司',
    'pageSize' => 10,
];

return \yii\helpers\ArrayHelper::merge(
    $params,
    require PATH_BASE . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "secret.php"
);
