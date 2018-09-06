<?php
/**
 * CodeUP Framework using Yii Framework
 * @author Upik Saleh <upxsal@gmail.com>
 * @license MIT
 */
namespace codeup\assets;
use yii\web\AssetBundle;

class InputmaskAsset extends AssetBundle
{
    public $sourcePath = '@bower/inputmask/dist/min';
    public $js = [
        'jquery.inputmask.bundle.min.js',
    ];
}