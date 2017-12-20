<?php

namespace Uis\Sdk\UserPlatform;

/**
 *  
 * @package Uis\Sdk\UserPlatform
 */
class UidModel
{

    /**
     * @var string
     */
    public $biz_id;
    /**
     * @var int
     */
    public $biz_type;
    /**
     * @var int
     */
    public $create_time;
    /**
     * @var string
     */
    public $mobile;
    /**
     * @var string
     */
    public $puid;
    /**
     * @var int
     */
    public $relation;
    /**
     * @var int
     */
    public $status;
    /**
     * @var string
     */
    public $uid;
    /**
     * @var int
     */
    public $update_time;
    /**
     * @var int
     */
    public $version;
    
    /**
     * 转成数组
     * @param bool $empty_convert 如果结果为空，是否转成stdClass
     * @return array|object
     */
    public function arrayPack($empty_convert = false)
    {
        $result = array();
        if (null !== $this->biz_id) {
            $result['bizId'] = (string)$this->biz_id;
        }
        if (null !== $this->biz_type) {
            $result['bizType'] = (int)$this->biz_type;
        }
        if (null !== $this->create_time) {
            $result['createTime'] = (int)$this->create_time;
        }
        if (null !== $this->mobile) {
            $result['mobile'] = (string)$this->mobile;
        }
        if (null !== $this->puid) {
            $result['puid'] = (string)$this->puid;
        }
        if (null !== $this->relation) {
            $result['relation'] = (int)$this->relation;
        }
        if (null !== $this->status) {
            $result['status'] = (int)$this->status;
        }
        if (null !== $this->uid) {
            $result['uid'] = (string)$this->uid;
        }
        if (null !== $this->update_time) {
            $result['updateTime'] = (int)$this->update_time;
        }
        if (null !== $this->version) {
            $result['version'] = (int)$this->version;
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
        if (isset($data['bizId'])) {
            $this->biz_id = (string)$data['bizId'];
        }
        if (isset($data['bizType'])) {
            $this->biz_type = (int)$data['bizType'];
        }
        if (isset($data['createTime'])) {
            $this->create_time = (int)$data['createTime'];
        }
        if (isset($data['mobile'])) {
            $this->mobile = (string)$data['mobile'];
        }
        if (isset($data['puid'])) {
            $this->puid = (string)$data['puid'];
        }
        if (isset($data['relation'])) {
            $this->relation = (int)$data['relation'];
        }
        if (isset($data['status'])) {
            $this->status = (int)$data['status'];
        }
        if (isset($data['uid'])) {
            $this->uid = (string)$data['uid'];
        }
        if (isset($data['updateTime'])) {
            $this->update_time = (int)$data['updateTime'];
        }
        if (isset($data['version'])) {
            $this->version = (int)$data['version'];
        }
    }
    
    /**
     * 数据修正，保证不会有null
     */
    public function fixNullData() {
        if (null == $this->biz_id) {
            $this->biz_id = '';
        }
        if (null == $this->biz_type) {
            $this->biz_type = 0;
        }
        if (null == $this->create_time) {
            $this->create_time = 0;
        }
        if (null == $this->mobile) {
            $this->mobile = '';
        }
        if (null == $this->puid) {
            $this->puid = '';
        }
        if (null == $this->relation) {
            $this->relation = 0;
        }
        if (null == $this->status) {
            $this->status = 0;
        }
        if (null == $this->uid) {
            $this->uid = '';
        }
        if (null == $this->update_time) {
            $this->update_time = 0;
        }
        if (null == $this->version) {
            $this->version = 0;
        }
    }
}