<?php

namespace Uis\Sdk\UserPlatform;

/**
 *  
 * @package Uis\Sdk\UserPlatform
 */
class UserBasic
{

    /**
     * @var string
     */
    public $mobile;
    /**
     * @var string
     */
    public $puid;
    /**
     * @var string
     */
    public $uid;
    
    /**
     * 转成数组
     * @param bool $empty_convert 如果结果为空，是否转成stdClass
     * @return array|object
     */
    public function arrayPack($empty_convert = false)
    {
        $result = array();
        if (null !== $this->mobile) {
            $result['mobile'] = (string)$this->mobile;
        }
        if (null !== $this->puid) {
            $result['puid'] = (string)$this->puid;
        }
        if (null !== $this->uid) {
            $result['uid'] = (string)$this->uid;
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
        if (isset($data['mobile'])) {
            $this->mobile = (string)$data['mobile'];
        }
        if (isset($data['puid'])) {
            $this->puid = (string)$data['puid'];
        }
        if (isset($data['uid'])) {
            $this->uid = (string)$data['uid'];
        }
    }
    
    /**
     * 数据修正，保证不会有null
     */
    public function fixNullData() {
        if (null == $this->mobile) {
            $this->mobile = '';
        }
        if (null == $this->puid) {
            $this->puid = '';
        }
        if (null == $this->uid) {
            $this->uid = '';
        }
    }
}