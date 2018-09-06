<?php
/**
 * CodeUP Framework using Yii Framework
 * @author Upik Saleh <upxsal@gmail.com>
 * @license MIT
 */

namespace codeup\widgets\theming;

use yii\helpers\ArrayHelper;

class Theme extends \codeup\theming\Theme
{
    public static function btnType($type = '')
    {
        if (isset(self::CLASS_BUTTON[$type]))
            return self::CLASS_BUTTON[$type];
        return self::CLASS_BUTTON['default'];
    }
    /**
     * @param string $optName
     * @param Widget $widget
     */
    // --------------------------------------------------------------------
    public static function initWidget($optName, $widget){
        if(isset(self::$options[$optName])){
            $widget->options = ArrayHelper::merge($widget->options, self::$options[$optName]);
        }
    }
}