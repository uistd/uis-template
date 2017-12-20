<?php

namespace Uis\Filter;

use Uis\Helper\LoginHelper;
use UiStd\Uis\Base\Filter;

/**
 * Class FFanAuthFilter 飞凡通用的登录认证
 * @package Uis\Filter
 */
class FFanAuthFilter extends Filter
{
    /**
     * 执行filter
     * @param string $page
     * @param string $action
     */
    public function call($page, $action)
    {
        $puid = LoginHelper::getPuid();
        //puid获取到了，表示是正确的
        if (null !== $puid) {
            //将所有puid 都赋值一下
            $_GET['puid'] = $_POST['puid'] = $_REQUEST['puid'] = $puid;
        } else {
            //如果 传入的puid 不可用，删除puid
            unset($_GET['puid'], $_POST['puid'], $_REQUEST['puid'], $_COOKIE['puid']);
        }
    }
}
