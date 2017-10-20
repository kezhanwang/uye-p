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
            'cookieValidationKey' => 'Q-TAjtqKlLrK2nQLbeDDHBI00UPsApCB',
            'csrfParam' => '_uye_admin',
        ],
        'user' => [
            'identityClass' => 'common\models\ar\UyeAdminUser',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_uye_admin_login', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'allowActions' => [
            //这里是允许访问的action
            //controller/action
            '*'
        ]
    ],
    'params' => $params,
];
