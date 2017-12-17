<?php

namespace Sdk\UserPlatform;

use FFan\Std\Http\HttpClient;

/**
 *  验证用户登录
 * @package Sdk\UserPlatform
 */
class ApiCheckTokenByPuid extends HttpClient
{

    /**
     * @var string
     */
    public $plogin_token;
    /**
     * @var string
     */
    public $appid = "feifan";
    /**
     * @var string
     */
    public $puid;
    
    /**
     * 转成数组
     * @param bool $empty_convert 如果结果为空，是否转成stdClass
     * @return array|object
     */
    public function arrayPack($empty_convert = false)
    {
        $result = array();
        if (null !== $this->plogin_token) {
            $result['ploginToken'] = (string)$this->plogin_token;
        }
        if (null !== $this->appid) {
            $result['appid'] = (string)$this->appid;
        }
        if (null !== $this->puid) {
            $result['puid'] = (string)$this->puid;
        }
        if ($empty_convert && empty($result)) {
            return new \stdClass();
        }
        return $result;
    }
    
    /**
     * 对象初始化
     * @param array $data
     */
    public function arrayUnpack(array $data)
    {
        if (isset($data['ploginToken'])) {
            $this->plogin_token = (string)$data['ploginToken'];
        }
        if (isset($data['appid'])) {
            $this->appid = (string)$data['appid'];
        }
        if (isset($data['puid'])) {
            $this->puid = (string)$data['puid'];
        }
    }
    
    /**
     * @param string $uri
     * @param string $method
     */
    public function __construct($uri = 'userplatform/v1/users/{puid}/checkTokenByPuid', $method = 'get')
    {
        parent::__construct($uri, $method);
    }
    
    /**
     * 数据修正，保证不会有null
     */
    public function fixNullData() {
        if (null == $this->plogin_token) {
            $this->plogin_token = '';
        }
        if (null == $this->appid) {
            $this->appid = '';
        }
        if (null == $this->puid) {
            $this->puid = '';
        }
    }
}