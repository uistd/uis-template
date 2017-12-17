<?php

namespace Sdk\UserPlatform;

use Sdk\Api\Result;

/**
 *  获取子系统用户信息
 * @package Sdk\UserPlatform
 */
class GetUserSubInfoResult extends Result
{

    /**
     * @var SubUserDetail[]
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
        if (is_array($this->data)) {
            $tmp_arr_0 = array();
            foreach ($this->data as $item_0) {
                if (!$item_0 instanceof SubUserDetail) {
                    continue;
                }
                $tmp_arr_0[] = $item_0->arrayPack($empty_convert);
            }
            $result['data'] = $tmp_arr_0;
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
            $result_0 = array();
            foreach ($data['data'] as $item_0) {
                if (!is_array($item_0)) {
                    continue;
                }
                $struct_item_0 = new SubUserDetail();
                $struct_item_0->arrayUnpack($item_0);
                $item_0 = $struct_item_0;
                $result_0[] = $item_0;
            }
            $this->data = $result_0;
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
        if (null == $this->data) {
            $this->data = array();
        }
        if (null == $this->status) {
            $this->status = 0;
        }
        if (null == $this->message) {
            $this->message = '';
        }
    }
}