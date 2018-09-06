<?php
$config = [
    'id' => 'codeup',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'name'=>'CodeUP',
    'language' => 'id',
    'aliases' => [
        '@vendor'=> dirname(__DIR__).'/vendor',
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@codeup'   => dirname(__DIR__),
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '1AF2b26p-mXnBWGgAnnKqpaoRhD3t9aU',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'codeup\models\UserIdent',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-codeup', 'httpOnly' => true],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            //'defaultRoles' => ['superuser','admin'],
            // 'itemFile' => '@codeup/rbac/items.php',
            // 'assignmentFile' => '@codeup/rbac/assignments.php',
            // 'ruleFile' => '@codeup/rbac/rules.php'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                //'<action:(login|logout|error)>'       => 'sys/default/<action>'
                //'sys/login'   => 'sys/default/login'
            ],
        ],
        /**
         * @property \codeup\core\Formatter $formatter
         */
        'formatter' =>[
            'class'=>'codeup\core\Formatter'
        ]
//        'assetManager' => [
//            'bundles' => [
//                'yii\web\JqueryAsset' => [
//                    'js' => [
//                        'jquery.min.js'
//                    ]
//                ],
//            ],
//        ],
        
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
