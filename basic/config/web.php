<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'homeUrl'=> '/statistics/charges-by-network',

    'bootstrap' => ['log'],
    'timeZone' => 'Europe/Kiev',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'XgaffFa9X1bbkReK465oBRTgMtipJc93',
            'baseUrl'=> '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
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
        'db' => require(__DIR__ . '/db.php'),
        'db2' => require (__DIR__ . '/db2.php'),
        'db3' => require (__DIR__ . '/db3.php'),
        'db4' => require (__DIR__ . '/db4.php'),

        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'defaultTimeZone' => 'Europe/Kiev',
           // 'defaultTimeZone' => date_default_timezone_set('Europe/Kiev'),
           // 'timeZone' => 'GMT+2',
            //'dateFormat' => 'd MMMM yyyy',
            //'datetimeFormat' => 'd-M-Y H:i:s',
            //'timeFormat' => 'H:i:s',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'enableStrictParsing' => true,
            'rules' => [
                [
                    'pattern' => 'home',
                    'route' => 'site/index',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'charges',
                    'route' => 'statistics/charges-by-network',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'about',
                    'route' => 'site/about',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],

                [
                    'pattern' => 'charges/<type:[1-7]>-<year:20[0-9][0-9]>',
                    'route' => 'statistics/charges-year',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'charges/<type:[1-7]>-<year:20[0-9][0-9]>-<month:[01][0-9]>',
                    'route' => 'statistics/charges-month',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'charges/<type:[1-7]>-<year:20[0-9][0-9]>-<month:[01][0-9]>/table',
                    'route' => 'statistics/get-data-table',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'charges/<type:[1-7]>-<year:20[0-9][0-9]>/table',
                    'route' => 'statistics/get-data-table',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'charges/<type:[1-7]>/table',
                    'route' => 'statistics/get-data-table',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'charges/no-data',
                    'route' => 'site/no-data',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo/no-data',
                    'route' => 'site/no-data-todo',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'requests/no-data',
                    'route' => 'site/no-data-requests',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo/<type:[1-6]>-<year:20[0-9][0-9]>-<month:[01][0-9]>/no-data-in-request',
                    'route' => 'site/no-data-in-request',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo/<type:[1-6]>-<year:20[0-9][0-9]>/no-data-in-request',
                    'route' => 'site/no-data-in-request',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'charges/select-data',
                    'route' => 'statistics/select-data',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'charges/select-data/line',
                    'route' => 'statistics/get-data-line',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'charges/select-data/table',
                    'route' => 'statistics/get-data-table',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'charges/<type:[1-7]>-<year:20[0-9][0-9]>/line',
                    'route' => 'statistics/get-data-line',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'charges/<type:[1-7]>-<year:20[0-9][0-9]>-<month:[01][0-9]>/line',
                    'route' => 'statistics/get-data-line',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'charges/<type:[1-7]>/<year:20[0-9][0-9]><years:(-20[0-9][0-9]){1,8}>',
                    'route' => 'statistics/charges-multi-year',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'charges/<type:[1-7]>/<year:20[0-9][0-9]><years:(-20[0-9][0-9]){1,8}>/table',
                    'route' => 'statistics/get-data-table',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'charges/multi-years',
                    'route' => 'statistics/select-data-multi-years',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'charges/multi-years/table',
                    'route' => 'statistics/get-data-table',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo/<type:[1-6]>-<year:20[0-9][0-9]>',
                    'route' => 'todo/todo-quantity-year',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo/<type:[1-6]>-<year:20[0-9][0-9]>/line',
                    'route' => 'todo/todo-data-line',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo/<type:[1-6]>-<year:20[0-9][0-9]>/table',
                    'route' => 'todo/todo-data-table',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo/<type:[1-6]>-<year:20[0-9][0-9]>-<month:[01][0-9]>',
                    'route' => 'todo/todo-quantity-month',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo/<type:[1-6]>-<year:20[0-9][0-9]>-<month:[01][0-9]>/line',
                    'route' => 'todo/todo-data-line',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo/<type:[1-6]>-<year:20[0-9][0-9]>-<month:[01][0-9]>/table',
                    'route' => 'todo/todo-data-table',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo/<type:[1-6]>',
                    'route' => 'todo/todo-quantity-all',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo/<type:[1-6]>/table',
                    'route' => 'todo/todo-data-table',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo/<type:[1-6]>/line',
                    'route' => 'todo/todo-data-line',
                    //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo/select-data',
                    'route' => 'todo/select-data',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo/select-data/line',
                    'route' => 'todo/todo-data-line',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo/select-data/table',
                    'route' => 'todo/todo-data-table',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo-time/<type:[1-5]>-<year:20[0-9][0-9]>-<status:([1-9]|[1-2][0-7])>',
                    'route' => 'todo-time/todo-time-year',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo-time/<type:[1-5]>-<year:20[0-9][0-9]>-<status:([1-9]|[1-2][0-7])>/two-columns',
                    'route' => 'todo-time/todo-time-year',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo-time/<type:[1-5]>-<year:20[0-9][0-9]>-<status:([1-9]|[1-2][0-7])>/table',
                    'route' => 'todo-time/todo-time-table',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo-time/select-data',
                    'route' => 'todo-time/select-data',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo-time/select-data/two-columns',
                    'route' => 'todo-time/select-data',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo-time/<type:[1-5]>-<year:20[0-9][0-9]>-<status:([1-9]|[1-2][0-7])>/no-data-in-request',
                    'route' => 'site/no-data-in-request',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo-time/select-data/no-data-in-request',
                    'route' => 'site/no-data-in-request',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'todo-time/select-data/table',
                    'route' => 'todo-time/todo-time-table',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],









                [
                    'pattern' => 'requests/<org:[1-6]>',
                    'route' => 'requests/requests-quantity-all',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'requests/<org:[1-6]>-<year:20[0-9][0-9]>',
                    'route' => 'requests/requests-quantity-year',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'requests/<org:[1-6]>-<year:20[0-9][0-9]>/line',
                    'route' => 'requests/requests-data-line',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'requests/<org:[1-6]>-<year:20[0-9][0-9]>/table',
                    'route' => 'requests/requests-data-table',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'requests/<org:[1-6]>-<year:20[0-9][0-9]>-<month:[01][0-9]>',
                    'route' => 'requests/requests-quantity-month',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'requests/<org:[1-6]>-<year:20[0-9][0-9]>-<month:[01][0-9]>/line',
                    'route' => 'requests/requests-data-line',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'requests/<org:[1-6]>-<year:20[0-9][0-9]>-<month:[01][0-9]>/table',
                    'route' => 'requests/requests-data-table',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],

                [
                    'pattern' => 'requests/<org:[1-6]>/table',
                    'route' => 'requests/requests-data-table',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'requests/<org:[1-6]>/line',
                    'route' => 'requests/requests-data-line',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'requests/select-data',
                    'route' => 'requests/select-data',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'requests/select-data/line',
                    'route' => 'requests/requests-data-line',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'requests/select-data/table',
                    'route' => 'requests/requests-data-table',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'requests/<org:[1-6]>-<year:20[0-9][0-9]>-<month:[01][0-9]>/no-data-in-request',
                    'route' => 'site/no-data-in-request',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'requests/<org:[1-6]>-<year:20[0-9][0-9]>/no-data-in-request',
                    'route' => 'site/no-data-in-request',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'requests/multi-years',
                    'route' => 'requests/select-data-multi-years',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],




                [
                    'pattern' => 'switchdown/realtime',
                    'route' => 'switchdown/realtime',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'switchdown/realtime-old',
                    'route' => 'switchdown/realtime-old',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'switchdown/get-linked-switch',
                    'route' => 'switchdown/get-linked-switch',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'switchdown/get-history/<year:20[0-9][0-9]>-<month:[01][0-9]>-<days:[0-3][0-9]>',
                    'route' => 'switchdown/get-history-day',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'switchdown/get-history/<year:20[0-9][0-9]>-<month:[01][0-9]>',
                    'route' => 'switchdown/get-history-day',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],

                [
                    'pattern' => 'switchdown/get-history/<year:20[0-9][0-9]>',
                    'route' => 'switchdown/get-history-day',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],
                [
                    'pattern' => 'switchdown/get-history/from-<year:20[0-9][0-9]>-<month:[01][0-9]>-<days:[0-3][0-9]>-to-<year2:20[0-9][0-9]>-<month2:[01][0-9]>-<days2:[0-3][0-9]>',
                    'route' => 'switchdown/get-history-day',
                        //'defaults' => ['page' => 1, 'tag' => ''],
                ],






            ],
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
