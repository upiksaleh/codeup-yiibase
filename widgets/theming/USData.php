<?php
/**
 * CodeUP Framework using Yii Framework
 * @author Upik Saleh <upxsal@gmail.com>
 * @license MIT
 */
namespace codeup\widgets\theming;
use codeup\widgets\theming\Gridview;
use yii\helpers\ArrayHelper;

class USData extends Widget
{
    public $data = [
        'id'    => 'usdata'
    ];
    public $gridView = [];
    public function init()
    {
        $this->setId('usdata-'.$this->data['id']);
        $this->options['usdata'] = true;
        parent::init();
    }
    public function run()
    {
        //$c = \Yii::createObject($this->gridView);
        return $this->render('usdata', ArrayHelper::toArray($this));
    }
}