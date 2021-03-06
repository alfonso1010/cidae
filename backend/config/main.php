<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'language' => 'es',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log','api'],
    'modules' => [
        'api'    => [
            'class' => 'backend\\api\\VersionContainer',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                'email'    => [
                    'class'   => 'yii\log\EmailTarget',
                    'except'  => [
                        'yii\web\HttpException:404', 
                        'yii\log\Dispatcher::dispatch', 
                        'yii\web\HttpException:401', 
                        'yii\caching\FileCache::setValue', 
                        'yii\i18n\PhpMessageSource::loadFallbackMessages',
                        'yii\debug\Module::checkAccess'
                    ],
                    'levels'  => ['error', 'warning'],
                    'message' => [
                        'from'   => 'errores@universidadcidae.com.mx',
                        'to'     => [
                            'alfonsoarellanes42@gmail.com'
                        ],
                        'subject' => 'Error CIDAE'

                    ],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
       'urlManager'       => [
            'enablePrettyUrl' => true,
            'showScriptName'                          => true,
            'rules'                                   => [
                '<controller:\w+>/<id:\d+>'              => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'          => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
