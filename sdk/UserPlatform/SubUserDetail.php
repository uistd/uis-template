<?php

namespace Sdk\UserPlatform;

/**
 *  
 * @package Sdk\UserPlatform
 */
class SubUserDetail
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
     * @var string
     */
    public $card_no;
    /**
     * @var string
     */
    public $create_time;
    /**
     * @var int
     */
    public $growth_value;
    /**
     * @var int
     */
    public $member_grade;
    /**
     * @var string
     */
    public $plaza_id;
    /**
     * @var int
     */
    public $status;
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
        if (null !== $this->biz_id) {
            $result['bizId'] = (string)$this->biz_id;
        }
        if (null !== $this->biz_type) {
            $result['bizType'] = (int)$this->biz_type;
        }
        if (null !== $this->card_no) {
            $result['cardNo'] = (string)$this->card_no;
        }
        if (null !== $this->create_time) {
            $result['createTime'] = (string)$this->create_time;
        }
        if (null !== $this->growth_value) {
            $result['growthValue'] = (int)$this->growth_value;
        }
        if (null !== $this->member_grade) {
            $result['memberGrade'] = (int)$this->member_grade;
        }
        if (null !== $this->plaza_id) {
            $result['plazaId'] = (string)$this->plaza_id;
        }
        if (null !== $this->status) {
            $result['status'] = (int)$this->status;
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
        if (isset($data['bizId'])) {
            $this->biz_id = (string)$data['bizId'];
        }
        if (isset($data['bizType'])) {
            $this->biz_type = (int)$data['bizType'];
        }
        if (isset($data['cardNo'])) {
            $this->card_no = (string)$data['cardNo'];
        }
        if (isset($data['createTime'])) {
            $this->create_time = (string)$data['createTime'];
        }
        if (isset($data['growthValue'])) {
            $this->growth_value = (int)$data['growthValue'];
        }
        if (isset($data['memberGrade'])) {
            $this->member_grade = (int)$data['memberGrade'];
        }
        if (isset($data['plazaId'])) {
            $this->plaza_id = (string)$data['plazaId'];
        }
        if (isset($data['status'])) {
            $this->status = (int)$data['status'];
        }
        if (isset($data['uid'])) {
            $this->uid = (string)$data['uid'];
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
        if (null == $this->card_no) {
            $this->card_no = '';
        }
        if (null == $this->create_time) {
            $this->create_time = '';
        }
        if (null == $this->growth_value) {
            $this->growth_value = 0;
        }
        if (null == $this->member_grade) {
            $this->member_grade = 0;
        }
        if (null == $this->plaza_id) {
            $this->plaza_id = '';
        }
        if (null == $this->status) {
            $this->status = 0;
        }
        if (null == $this->uid) {
            $this->uid = '';
        }
    }
}