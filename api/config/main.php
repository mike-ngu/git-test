<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => 'v1/country',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ]
                    
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/student',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],

                ],
                [
                    // route rule for custom rest 'actionImageUpload'
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/student',
                    'extraPatterns' => [
                        'POST {id}/imageupload' => 'image-upload',
                    ],
                ],
                /*
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/upload',
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST imageupload' => 'image-upload',
                    ],
                ],
                */
            ],        
        ]
    ],
    'params' => $params,
];



