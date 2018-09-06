<?php
/**
 * CodeUP Framework using Yii Framework
 * @author Upik Saleh <upxsal@gmail.com>
 * @license MIT
 */

namespace codeup\filters;


class AccessControl extends \yii\filters\AccessControl
{
    public $ruleConfig = ['class' => 'codeup\filters\AccessRule'];
}