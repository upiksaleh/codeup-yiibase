<?php
/**
 * CodeUP Framework using Yii Framework
 * @author Upik Saleh <upxsal@gmail.com>
 * @license MIT
 */

namespace codeup\core;


class ActiveRecord extends \yii\db\ActiveRecord
{
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create']=$scenarios['default'];
        $scenarios['update']=$scenarios['default'];
        return $scenarios;
    }
}