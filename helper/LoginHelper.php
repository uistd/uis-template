<?php

namespace Uis\Helper;

use Helper\CommonHelper;
use Uis\Sdk\UserPlatform\ApiCheckTokenByPuid;

/**
 * Class Login
 */
class LoginHelper
{
    /**
     * @var string 通过检查的puid
     */
    private static $puid;

    /**
     * @var bool 是否已经check过了
     */
    private static $is_check = false;

    /**
     * 登录token值检查
     */
    private static function loginTokenCheck()
    {
        if (!empty($_POST['puid']) && !empty($_POST['pLoginToken'])) {
            $puid = $_POST['puid'];
            $token = $_POST['pLoginToken'];
        } elseif (!empty($_GET['puid']) && !empty($_GET['pLoginToken'])) {
            $puid = $_GET['puid'];
            $token = $_GET['pLoginToken'];
        } elseif (!empty($_COOKIE['puid'])) {
            //cookie里叫 ploginToken 或者 pLoginToken
            if (isset($_COOKIE['pLoginToken'])) {
                $token = $_COOKIE['pLoginToken'];
            } elseif (isset($_COOKIE['ploginToken'])) {
                $token = $_COOKIE['ploginToken'];
            } else {
                return false;
            }
            $puid = $_COOKIE['puid'];
        } else {
            return false;
        }
        if (32 !== strlen($puid) && 32 !== strlen($token)) {
            return false;
        }
        $cache = CommonHelper::getPublicCache();
        $cache_key = self::cacheKey($puid, $token);
        $cache_result = $cache->get($cache_key);
        $cache_ttl = 1000;
        //未找到这个token对应的puid
        if (!$cache_result) {
            $api_req = new ApiCheckTokenByPuid();
            $api_req->plogin_token = $token;
            $api_req->puid = $puid;
            $result = $api_req->request();
            if (200 !== $result->status) {
                $cache->set($cache_key, 'INVALID', $cache_ttl);
                return false;
            }
            $cache->set($cache_key, $token, $cache_ttl);
        } elseif ($token !== $cache_result) {
            return false;
        }
        self::$puid = $puid;
        return true;
    }

    /**
     * puid 和 token 检查
     * @param string $puid
     * @param string $token
     * @return string
     */
    public static function cacheKey($puid, $token) {
        return 'tk_'. $puid .'_'. $token;
    }

    /**
     * 获取puid(不验证登录)
     * @return string|null
     */
    public static function getPuid()
    {
        if (!empty(self::$puid)) {
            return self::$puid;
        }
        //如果检查过一次了, 那就不用再检查了
        if (!self::$is_check) {
            $re = self::loginTokenCheck();
            self::$is_check = true;
        } else {
            $re = null;
        }
        if (!$re) {
            return null;
        } else {
            return self::$puid;
        }
    }
}
