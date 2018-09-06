<?php
/**
 * CodeUP Framework using Yii Framework
 * @author Upik Saleh <upxsal@gmail.com>
 * @license MIT
 */

namespace codeup\assets;

use yii\web\AssetBundle;

class AdminLTEAsset extends AssetBundle
{
    public $sourcePath = '@bower/admin-lte/dist';
//    public $basePath = '@bower';
//    public $baseUrl = '@web/assets/';
//    public $css = [
//        'bootstrap/dist/css/bootstrap.min.css',
//        'font-awesome/css/font-awesome.min.css',
//        'select2/dist/css/select2.min.css',
//        'admin-lte/dist/css/AdminLTE.min.css',
//        'admin-lte/dist/css/skins/_all-skins.min.css',
//        'admin-lte/plugins/iCheck/all.css',
//        'datatables/datatables.min.css',
//        'bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css',
//    ];
//    public $js = [
//        'bootstrap/dist/js/bootstrap.min.js',
//        'jquery-slimscroll/jquery.slimscroll.min.js',
//        'admin-lte/dist/js/adminlte.min.js',
//        'admin-lte/plugins/iCheck/icheck.min.js',
//        'jquery-slimscroll/jquery.slimscroll.min.js',
//        'datatables/datatables.min.js',
//        'bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
//        'select2/dist/js/select2.full.min.js',
//        ];
    public $css = [
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
    ];
    public $js = [
        'js/adminlte.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'codeup\assets\BootstrapAsset',
        'codeup\assets\BootstrapDatepickerAsset',
        'codeup\assets\FontAwesomeAsset',
        'codeup\assets\SlimScrollAsset',
        'codeup\assets\Select2Asset',
    ];
}