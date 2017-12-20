<?php

namespace Uis\Sdk\UserPlatform;

use UiStd\Uis\Base\ActionException;
use UiStd\Http\HttpClient;

/**
 *  获取用户信息
 * @package Uis\Sdk\UserPlatform
 */
class ApiGetUser extends HttpClient
{

    /**
     * @var string
     */
    public $keyword;
    /**
     * @var int
     */
    public $keyword_type = 0;
    /**
     * @var string
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
        if (null !== $this->keyword) {
            $result['keyword'] = (string)$this->keyword;
        }
        if (null !== $this->keyword_type) {
            $result['keywordType'] = (int)$this->keyword_type;
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
        if (isset($data['keyword'])) {
            $this->keyword = (string)$data['keyword'];
        }
        if (isset($data['keywordType'])) {
            $this->keyword_type = (int)$data['keywordType'];
        }
        if (isset($data['appid'])) {
            $this->appid = (string)$data['appid'];
        }
    }
    
    /**
     * @param string $uri
     * @param string $method
     */
    public function __construct($uri = 'userplatform/v1/users', $method = 'get')
    {
        parent::__construct($uri, $method);
    }
    
    /**
     * 获取返回的结果
     * @param int $result_mode 模式：默认，严格，兼容 三种模式
     * @param int $success_status 成功的status
     * @return UserDetail
     * @throws ActionException
     */
    public function getResult($result_mode = HttpClient::COMPATIBLE_MODE, $success_status = 200)
    {
        $api_result = $this->getResponse();
        if (HttpClient::STRICT_MODE === $result_mode && $success_status !== $api_result->status) {
            self::fixErrorMessage($api_result);
            throw new ActionException($api_result->message, $api_result->status);
        }
        $result = new GetUserResult();
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
        if (null == $this->keyword) {
            $this->keyword = '';
        }
        if (null == $this->keyword_type) {
            $this->keyword_type = 0;
        }
        if (null == $this->appid) {
            $this->appid = '';
        }
    }
}