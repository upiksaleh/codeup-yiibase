<?php
/**
 * CodeUP Framework using Yii Framework
 * @author Upik Saleh <upxsal@gmail.com>
 * @license MIT
 */

namespace codeup\assets;


use yii\web\AssetBundle;

class BootstrapDatepickerAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-datepicker/dist';
    public $js = [
        'js/bootstrap-datepicker.min.js',
    ];
    public $css = [
        'css/bootstrap-datepicker.min.css',
    ];
}