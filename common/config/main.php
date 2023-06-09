<?php

use common\services\AppleService;
use common\services\AppleServiceInterface;
use yii\caching\FileCache;
use yii\rbac\DbManager;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => FileCache::class,
        ],
        'authManager' => [
            'class' => DbManager::class,
        ],
    ],
];
