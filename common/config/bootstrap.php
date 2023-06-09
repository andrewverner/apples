<?php

use common\repositories\AppleRepository;
use common\repositories\AppleRepositoryInterface;
use common\services\AppleService;
use common\services\AppleServiceInterface;

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

Yii::$container->set(class: AppleServiceInterface::class, definition: AppleService::class);
Yii::$container->set(class: AppleRepositoryInterface::class, definition: AppleRepository::class);