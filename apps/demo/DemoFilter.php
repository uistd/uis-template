<?php

namespace Uis\Demo;

use FFan\Dop\Uis\Application;
use FFan\Dop\Uis\Filter;
use FFan\Std\Common\Ip;

/**
 * Class DemoFilter 过滤器
 * @package Uis\Demo
 */
class DemoFilter extends Filter
{
    /**
     * 只允许内网IP访问
     * @param string $page
     * @param string $action
     */
    public function call($page, $action)
    {
        $ip = Ip::get();
        if (!Ip::isInternal($ip)) {
            $this->setError(403, 'Access denied');
        }
        Application::getInstance()->getResponse()->appendData('filter_msg', 'Access allowed');
    }
}
