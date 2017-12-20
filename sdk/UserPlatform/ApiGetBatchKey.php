<?php

namespace Uis\Sdk\UserPlatform;

use UiStd\Uis\Base\ActionException;
use UiStd\Http\HttpClient;

/**
 *  批量查询用户信息
 * @package Uis\Sdk\UserPlatform
 */
class ApiGetBatchKey extends HttpClient
{

    /**
     * @var string 需要返回的字段 多个用,隔开
     */
    public $result_str;
    /**
     * @var string 关键字 多个用,隔开
     */
    public $key;
    /**
     * @var string key 的类型
     */
    public $type = "2";
    /**
     * @var string
     */
    public $__uni_source = "5.01";
    
    /**
     * 转成数组
     * @param bool $empty_convert 如果结果为空，是否转成stdClass
     * @return array|object
     */
    public function arrayPack($empty_convert = false)
    {
        $result = array();
        if (null !== $this->result_str) {
            $result['resultStr'] = (string)$this->result_str;
        }
        if (null !== $this->key) {
            $result['key'] = (string)$this->key;
        }
        if (null !== $this->type) {
            $result['type'] = (string)$this->type;
        }
        if (null !== $this->__uni_source) {
            $result['__uni_source'] = (string)$this->__uni_source;
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
        if (isset($data['resultStr'])) {
            $this->result_str = (string)$data['resultStr'];
        }
        if (isset($data['key'])) {
            $this->key = (string)$data['key'];
        }
        if (isset($data['type'])) {
            $this->type = (string)$data['type'];
        }
        if (isset($data['__uni_source'])) {
            $this->__uni_source = (string)$data['__uni_source'];
        }
    }
    
    /**
     * @param string $uri
     * @param string $method
     */
    public function __construct($uri = 'userplatform/v1/uplatemember/batchKey', $method = 'get')
    {
        parent::__construct($uri, $method);
    }
    
    /**
     * 获取返回的结果
     * @param int $result_mode 模式：默认，严格，兼容 三种模式
     * @param int $success_status 成功的status
     * @return UserDetail[]
     * @throws ActionException
     */
    public function getResult($result_mode = HttpClient::COMPATIBLE_MODE, $success_status = 200)
    {
        $api_result = $this->getResponse();
        if (HttpClient::STRICT_MODE === $result_mode && $success_status !== $api_result->status) {
            self::fixErrorMessage($api_result);
            throw new ActionException($api_result->message, $api_result->status);
        }
        $result = new GetBatchKeyResult();
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
        if (null == $this->result_str) {
            $this->result_str = '';
        }
        if (null == $this->key) {
            $this->key = '';
        }
        if (null == $this->type) {
            $this->type = '';
        }
        if (null == $this->__uni_source) {
            $this->__uni_source = '';
        }
    }
}