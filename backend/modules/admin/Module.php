<?php

namespace backend\modules\admin;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    public $layout = 'main.php';
    public $controllerNamespace = 'backend\modules\admin\controllers';

    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }
}
