<?php
/**
 * CodeUP Framework using Yii Framework
 * @author Upik Saleh <upxsal@gmail.com>
 * @license MIT
 */

namespace codeup\assets;


use yii\web\AssetBundle;

class DatatablesAsset extends AssetBundle
{
    public $sourcePath = '@bower/datatables';

    public $css = [
        'dist/css/select2.min.css',
    ];
    public $js = [
        'dist/js/select2.full.min.js',
    ];
    public $publishOptions = [
        'only'=>[
            'dist/*'
        ]
    ];
}