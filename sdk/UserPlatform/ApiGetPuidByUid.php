<?php

namespace Sdk\UserPlatform;

use UiStd\Uis\Base\ActionException;
use UiStd\Http\HttpClient;

/**
 *  根据uid查puid
 * @package Sdk\UserPlatform
 */
class ApiGetPuidByUid extends HttpClient
{

    /**
     * @var string uid
     */
    public $uid;
    /**
     * @var string 企业ID
     */
    public $biz_id = "10001";
    /**
     * @var string appid
     */
    public $appid = "crm";
    
    /**
     * 转成数组
     * @param bool $empty_convert 如果结果为空，是否转成stdClass
     * @return array|object
     */
    public function arrayPack($empty_convert = false)
    {
        $result = array();
        if (null !== $this->uid) {
            $result['uid'] = (string)$this->uid;
        }
        if (null !== $this->biz_id) {
            $result['bizId'] = (string)$this->biz_id;
        }
        if (null !== $this->appid) {
            $result['appid'] = (string)$this->appid;
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
        if (isset($data['uid'])) {
            $this->uid = (string)$data['uid'];
        }
        if (isset($data['bizId'])) {
            $this->biz_id = (string)$data['bizId'];
        }
        if (isset($data['appid'])) {
            $this->appid = (string)$data['appid'];
        }
    }
    
    /**
     * @param string $uri
     * @param string $method
     */
    public function __construct($uri = 'userplatform/v1/users/puid', $method = 'get')
    {
        parent::__construct($uri, $method);
    }
    
    /**
     * 获取返回的结果
     * @param int $result_mode 模式：默认，严格，兼容 三种模式
     * @param int $success_status 成功的status
     * @return UserBasic
     * @throws ActionException
     */
    public function getResult($result_mode = HttpClient::COMPATIBLE_MODE, $success_status = 200)
    {
        $api_result = $this->getResponse();
        if (HttpClient::STRICT_MODE === $result_mode && $success_status !== $api_result->status) {
            self::fixErrorMessage($api_result);
            throw new ActionException($api_result->message, $api_result->status);
        }
        $result = new GetPuidByUidResult();
        if ($success_status === $api_result->status) {
            $data = $this->getResponseData();
            $result->arrayUnpack($data);
        }
        if (HttpClient::COMPATIBLE_MODE === $result_mode) {
            $result->fixNullData();
        }
        return $result->data;
    }
    
    /**
     * 数据修正，保证不会有null
     */
    public function fixNullData() {
        if (null == $this->uid) {
            $this->uid = '';
        }
        if (null == $this->biz_id) {
            $this->biz_id = '';
        }
        if (null == $this->appid) {
            $this->appid = '';
        }
    }
}