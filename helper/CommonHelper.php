<?php

namespace Uis\Helper;

use UiStd\Cache\CacheFactory;
use UiStd\Cache\CacheInterface;
use UiStd\Uis\Base\ActionException;

/**
 * Class CommonHelper 常用方法
 * @package Helper
 */
class CommonHelper
{
    /**
     * 获取Apc缓存
     * @return CacheInterface
     */
    public static function getApcCache()
    {
        return CacheFactory::get('local');
    }

    /**
     * 获取公共缓存
     * @return CacheInterface
     */
    public static function getPublicCache()
    {
        return CacheFactory::get('public');
    }

    /**
     * 获取当前登录用户的puid.(必须登录)
     * @param bool $login_require 是否必须登录，如果是 true. 未登录状态下会自动报错
     * @return string
     * @throws ActionException
     */
    public static function getLoginPuid($login_require = true)
    {
        $puid = LoginHelper::getPuid();
        if (!$puid) {
            //必须登录
            if ($login_require) {
                throw new ActionException('Authentication failed', 401);
            }
            $puid = '';
        }
        return $puid;
    }
}
