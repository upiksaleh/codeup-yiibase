<?php
/**
 * CodeUP Framework using Yii Framework
 * @author Upik Saleh <upxsal@gmail.com>
 * @license MIT
 */

namespace codeup\assets;


use yii\web\AssetBundle;

class AdminLTEPluginsAsset extends AssetBundle
{
    public $sourcePath = '@bower/admin-lte/plugins';

    public $css = [
        'iCheck/all.css',
    ];

    public $js = [
        'iCheck/icheck.min.js',
    ];
    public $depends = [
        'codeup\assets\AdminLTEAsset',
        'codeup\assets\InputmaskAsset',
    ];

}