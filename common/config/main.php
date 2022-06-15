<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
            'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' =>
        [
            'showScriptName' => true, // Disable index.php, boolean
            'enablePrettyUrl' => true
        ],
        'authManager' =>
        [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\PhpManager'
        ],
        'formatter' =>
        [
            'dateFormat' => 'medium',
            'defaultTimeZone' => 'America/Mexico_City',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            //'useFileTransport' => true,
            'useFileTransport' => false, //set this property to false to send mails to real email addresses
            //comment the following array to send mail using php's mail function
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'universidadcidae.com.mx',
                'username' => 'errores@universidadcidae.com.mx',
                'password' => '7h8j9k0l',
                'port' => '26',
                'encryption' => 'tls',
            ],
        ],
    ],
];
