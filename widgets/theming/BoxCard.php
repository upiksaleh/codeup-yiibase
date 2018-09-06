<?php
/**
 * CodeUP Framework using Yii Framework
 * @author Upik Saleh <upxsal@gmail.com>
 * @license MIT
 */


namespace codeup\widgets\theming;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * Class BoxCard
 * Widget boxcard, seperti panel pada bootstrap
 * @package codeup\widgets\theming
 */
class BoxCard extends Widget
{
    /**
     * @var string inner body pada boxcard
     */
    public $body = '';
    /**
     * @var string judul untuk boxcard
     */
    public $title;
    /**
     * @var string type class boxcard contoh: primary|success|danger|warning|info
     */
    public $type = 'default';
    /**
     * @var false|array option untuk header
     */
    public $headerOptions = [];

    public $preBody = FALSE;
    public $bodyOptions = [];
    /**
     * @var false|array option untuk footer
     */
    public $footerOptions = FALSE;

    // --------------------------------------------------------------------
    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        ob_start();

    }

    // --------------------------------------------------------------------
    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->body = ob_get_clean();
        $render = $this->render('boxcard', $this->getViewParams());

        //$this->registerPlugin('aaaa');
        echo $render;
    }

    // --------------------------------------------------------------------
    /**
     * params yang akan dipakai pada view
     * @return array
     */
    public function getViewParams()
    {
        return ArrayHelper::toArray($this);
        return [
            'title' => $this->title,
            'body' => $this->body,
            'type' => $this->type,
            'options' => $this->options,
            'headerOptions' => $this->headerOptions,
            'bodyOptions' => $this->bodyOptions,
            'footerOptions' => $this->footerOptions,
        ];
    }
}