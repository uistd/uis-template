<?php

namespace Uis\Sdk\UserPlatform;

/**
 *  
 * @package Uis\Sdk\UserPlatform
 */
class UserDetail
{

    /**
     * @var int
     */
    public $verify;
    /**
     * @var string
     */
    public $live_city;
    /**
     * @var string
     */
    public $education;
    /**
     * @var int
     */
    public $credit_status;
    /**
     * @var string
     */
    public $card_no;
    /**
     * @var UidModel[]
     */
    public $uids;
    /**
     * @var string
     */
    public $nick_name;
    /**
     * @var int
     */
    public $gender;
    /**
     * @var string
     */
    public $merchant_id;
    /**
     * @var string
     */
    public $biz_id;
    /**
     * @var string
     */
    public $puid;
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
    public $promotion_from;
    /**
     * @var int
     */
    public $pwd_type;
    /**
     * @var string
     */
    public $promoter_type;
    /**
     * @var string
     */
    public $real_name;
    /**
     * @var string
     */
    public $head_portrait;
    /**
     * @var string
     */
    public $channel;
    /**
     * @var string
     */
    public $store_id;
    /**
     * @var string
     */
    public $mobile;
    
    /**
     * 转成数组
     * @param bool $empty_convert 如果结果为空，是否转成stdClass
     * @return array|object
     */
    public function arrayPack($empty_convert = false)
    {
        $result = array();
        if (null !== $this->verify) {
            $result['verify'] = (int)$this->verify;
        }
        if (null !== $this->live_city) {
            $result['liveCity'] = (string)$this->live_city;
        }
        if (null !== $this->education) {
            $result['education'] = (string)$this->education;
        }
        if (null !== $this->credit_status) {
            $result['creditStatus'] = (int)$this->credit_status;
        }
        if (null !== $this->card_no) {
            $result['cardNo'] = (string)$this->card_no;
        }
        if (is_array($this->uids)) {
            $tmp_arr_0 = array();
            foreach ($this->uids as $item_0) {
                if (!$item_0 instanceof UidModel) {
                    continue;
                }
                $tmp_arr_0[] = $item_0->arrayPack($empty_convert);
            }
            $result['uids'] = $tmp_arr_0;
        }
        if (null !== $this->nick_name) {
            $result['nickName'] = (string)$this->nick_name;
        }
        if (null !== $this->gender) {
            $result['gender'] = (int)$this->gender;
        }
        if (null !== $this->merchant_id) {
            $result['merchantId'] = (string)$this->merchant_id;
        }
        if (null !== $this->biz_id) {
            $result['bizId'] = (string)$this->biz_id;
        }
        if (null !== $this->puid) {
            $result['puid'] = (string)$this->puid;
        }
        if (null !== $this->plaza_id) {
            $result['plazaId'] = (string)$this->plaza_id;
        }
        if (null !== $this->status) {
            $result['status'] = (int)$this->status;
        }
        if (null !== $this->promotion_from) {
            $result['promotionFrom'] = (string)$this->promotion_from;
        }
        if (null !== $this->pwd_type) {
            $result['pwdType'] = (int)$this->pwd_type;
        }
        if (null !== $this->promoter_type) {
            $result['promoterType'] = (string)$this->promoter_type;
        }
        if (null !== $this->real_name) {
            $result['realName'] = (string)$this->real_name;
        }
        if (null !== $this->head_portrait) {
            $result['headPortrait'] = (string)$this->head_portrait;
        }
        if (null !== $this->channel) {
            $result['channel'] = (string)$this->channel;
        }
        if (null !== $this->store_id) {
            $result['storeId'] = (string)$this->store_id;
        }
        if (null !== $this->mobile) {
            $result['mobile'] = (string)$this->mobile;
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
        if (isset($data['verify'])) {
            $this->verify = (int)$data['verify'];
        }
        if (isset($data['liveCity'])) {
            $this->live_city = (string)$data['liveCity'];
        }
        if (isset($data['education'])) {
            $this->education = (string)$data['education'];
        }
        if (isset($data['creditStatus'])) {
            $this->credit_status = (int)$data['creditStatus'];
        }
        if (isset($data['cardNo'])) {
            $this->card_no = (string)$data['cardNo'];
        }
        if (isset($data['uids']) && is_array($data['uids'])) {
            $result_0 = array();
            foreach ($data['uids'] as $item_0) {
                if (!is_array($item_0)) {
                    continue;
                }
                $struct_item_0 = new UidModel();
                $struct_item_0->arrayUnpack($item_0);
                $item_0 = $struct_item_0;
                $result_0[] = $item_0;
            }
            $this->uids = $result_0;
        }
        if (isset($data['nickName'])) {
            $this->nick_name = (string)$data['nickName'];
        }
        if (isset($data['gender'])) {
            $this->gender = (int)$data['gender'];
        }
        if (isset($data['merchantId'])) {
            $this->merchant_id = (string)$data['merchantId'];
        }
        if (isset($data['bizId'])) {
            $this->biz_id = (string)$data['bizId'];
        }
        if (isset($data['puid'])) {
            $this->puid = (string)$data['puid'];
        }
        if (isset($data['plazaId'])) {
            $this->plaza_id = (string)$data['plazaId'];
        }
        if (isset($data['status'])) {
            $this->status = (int)$data['status'];
        }
        if (isset($data['promotionFrom'])) {
            $this->promotion_from = (string)$data['promotionFrom'];
        }
        if (isset($data['pwdType'])) {
            $this->pwd_type = (int)$data['pwdType'];
        }
        if (isset($data['promoterType'])) {
            $this->promoter_type = (string)$data['promoterType'];
        }
        if (isset($data['realName'])) {
            $this->real_name = (string)$data['realName'];
        }
        if (isset($data['headPortrait'])) {
            $this->head_portrait = (string)$data['headPortrait'];
        }
        if (isset($data['channel'])) {
            $this->channel = (string)$data['channel'];
        }
        if (isset($data['storeId'])) {
            $this->store_id = (string)$data['storeId'];
        }
        if (isset($data['mobile'])) {
            $this->mobile = (string)$data['mobile'];
        }
    }
    
    /**
     * 数据修正，保证不会有null
     */
    public function fixNullData() {
        if (null == $this->verify) {
            $this->verify = 0;
        }
        if (null == $this->live_city) {
            $this->live_city = '';
        }
        if (null == $this->education) {
            $this->education = '';
        }
        if (null == $this->credit_status) {
            $this->credit_status = 0;
        }
        if (null == $this->card_no) {
            $this->card_no = '';
        }
        if (null == $this->uids) {
            $this->uids = array();
        }
        if (null == $this->nick_name) {
            $this->nick_name = '';
        }
        if (null == $this->gender) {
            $this->gender = 0;
        }
        if (null == $this->merchant_id) {
            $this->merchant_id = '';
        }
        if (null == $this->biz_id) {
            $this->biz_id = '';
        }
        if (null == $this->puid) {
            $this->puid = '';
        }
        if (null == $this->plaza_id) {
            $this->plaza_id = '';
        }
        if (null == $this->status) {
            $this->status = 0;
        }
        if (null == $this->promotion_from) {
            $this->promotion_from = '';
        }
        if (null == $this->pwd_type) {
            $this->pwd_type = 0;
        }
        if (null == $this->promoter_type) {
            $this->promoter_type = '';
        }
        if (null == $this->real_name) {
            $this->real_name = '';
        }
        if (null == $this->head_portrait) {
            $this->head_portrait = '';
        }
        if (null == $this->channel) {
            $this->channel = '';
        }
        if (null == $this->store_id) {
            $this->store_id = '';
        }
        if (null == $this->mobile) {
            $this->mobile = '';
        }
    }
}