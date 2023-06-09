<?php

declare(strict_types=1);

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class AppleGridAsset extends AssetBundle
{
    public $js = [
        'js/apple-grid.js',
    ];
    public $depends = [
        JqueryAsset::class,
    ];
}
