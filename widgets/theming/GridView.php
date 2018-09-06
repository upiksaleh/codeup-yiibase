<?php
/**
 * CodeUP Framework using Yii Framework
 * @author Upik Saleh <upxsal@gmail.com>
 * @license MIT
 */

namespace codeup\widgets\theming;


class GridView extends \yii\grid\GridView
{
    //public $layout= 'asasa';
    public $tableOptions = ['class' => 'table table-striped table-bordered'];
    public function init()
    {
        parent::init();

    }
    public function run()
    {
        $a = parent::run();
    }
}