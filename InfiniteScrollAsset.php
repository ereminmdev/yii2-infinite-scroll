<?php

namespace ereminmdev\yii2\infinite_scroll;

use yii\web\AssetBundle;

/**
 * Class InfiniteScrollAsset
 * @package ereminmdev\yii2\infinite_scroll
 */
class InfiniteScrollAsset extends AssetBundle
{
    public $sourcePath = '@vendor/webcreate/jquery-ias/src';

    public $js = [
        'callbacks.js',
        'jquery-ias.js',
        'extension/history.js',
        'extension/noneleft.js',
        'extension/paging.js',
        'extension/spinner.js',
        'extension/trigger.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
