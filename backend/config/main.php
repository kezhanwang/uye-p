<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);
Yii::$container->set('mdm\admin\components\Configs',
    [
        'authManager' => 'authManager',
        'db' => 'db',
        'menuTable' => 'uye_admin_menu',
        'userTable' => 'uye_admin_user',
    ]
);
return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    "modules" => [
        "admin" => [
            "class" => "mdm\admin\Module",
        ],
    ],
    "aliases" => [
        "@mdm/admin" => "@vendor/mdmsoft/yii2-admin",
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'XP0YeEnp5iWwj0q8mW4dofAcZLvYwtfK/pYY/FgNom0=',
            'csrfParam' => 'DHB_uye_admin',
        ],
        'user' => [
            'identityClass' => 'common\models\ar\UyeAdminUser',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => 'DHB_uye_admin_login', 'httpOnly' => true],
            'authTimeout' => 60,
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 's_uye_admin',
            'timeout' => 60,
        ],
        "authManager" => [
            "class" => 'yii\rbac\DbManager', //这里记得用单引号而不是双引号
            "defaultRoles" => ["guest"],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ],
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => []
    ],
    'params' => $params,
];
