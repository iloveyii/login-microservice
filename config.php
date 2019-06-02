<?php
return [
    'id' => 'micro-login-app',
    // the basePath of the application will be the `micro-app` directory
    'basePath' => __DIR__,
    // this is where the application will find all controllers
    'controllerNamespace' => 'micro\controllers',
    // set an alias to enable autoloading of classes from the 'micro' namespace
    'aliases' => [
        '@micro' => __DIR__,
    ],
    'components' => [
        'db2' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'sqlite:@micro/database.sqlite',
        ],
        'db' => [
            'class' => '\yii\db\Connection',
            'dsn' => 'mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=authdb',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'user',
                    'extraPatterns' => [
                        'POST login' => 'login',
                        'POST token' => 'token',
                        'POST register' => 'register',
                        'GET getAuthorizedUser' => 'authorized',
                    ],
                ],
            ],
        ]
    ],
];
