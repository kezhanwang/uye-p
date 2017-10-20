<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
);

return [
    'id' => 'app-e',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'e\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'enableCookieValidation' => true,
            'cookieValidationKey' => 'Q-TAjtqKlLrK2nQLbeDDHBI00UPsdcds',
            'csrfParam' => '_csrf-e',
        ],
        'user' => [
            'identityClass' => 'common\models\ar\UyeEUser',
            'enableAutoLogin' => true,
            'loginUrl' => ['login/login'],
            'identityCookie' => ['name' => '_identity-e', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'bjzhongteng.com',
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
    'params' => $params,
];
