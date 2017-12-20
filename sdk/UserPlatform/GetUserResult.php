<?php

namespace Uis\Sdk\UserPlatform;

use Uis\Sdk\Api\Result;

/**
 *  获取用户信息
 * @package Uis\Sdk\UserPlatform
 */
class GetUserResult extends Result
{

    /**
     * @var UserDetail
     */
    public $data;
    
    /**
     * 转成数组
     * @param bool $empty_convert 如果结果为空，是否转成stdClass
     * @return array|object
     */
    public function arrayPack($empty_convert = false)
    {
        $result = array();
        if (isset($this->data) && $this->data instanceof UserDetail) {
            $result['data'] = $this->data->arrayPack($empty_convert);
        }
        if (null !== $this->status) {
            $result['status'] = (int)$this->status;
        }
        if (null !== $this->message) {
            $result['message'] = (string)$this->message;
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
        if (isset($data['data']) && is_array($data['data'])) {
            $struct_data = new UserDetail();
            $struct_data->arrayUnpack($data['data']);
            $this->data = $struct_data;
        }
        if (isset($data['status'])) {
            $this->status = (int)$data['status'];
        }
        if (isset($data['message'])) {
            $this->message = (string)$data['message'];
        }
    }
    
    /**
     * 数据修正，保证不会有null
     */
    public function fixNullData() {
        if (null === $this->data) {
            $this->data = new UserDetail();
        }
            $this->data->fixNullData();
        if (null == $this->status) {
            $this->status = 0;
        }
        if (null == $this->message) {
            $this->message = '';
        }
    }
}