<?php

namespace Uis\Demo;

use UiStd\Uis\Base\Filter;
use UiStd\Common\Ip;

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
    }
}
