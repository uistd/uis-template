<?php

namespace Uis\Work\Demo;

use UiStd\Uis\Work\Crontab;

/**
 * Class DemoWrok
 * @package Uis\Work
 */
class DemoWork extends Crontab
{

    /**
     * init
     */
    public function init()
    {
        //设置每1秒执行一次
        $this->setLoop(1000);
    }

    /**
     * crontab 主方法
     */
    public function action()
    {
        $str = 'Demo Crontab is running. now time:' . date('Y-m-d H:i:s');
        $this->log($str);
        echo $str, PHP_EOL;
    }
}
