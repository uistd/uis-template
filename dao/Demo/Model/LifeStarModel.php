<?php

namespace Uis\Dao\Demo\Model;

//以下代码由工具自动生成。 数据库发生改变时，在项目主目录运行 php tool/dao/build.php 重新生成

/**
 *  table of life_star
 * @package Uis\Dao\Demo\Model
 */
class LifeStarModel
{

    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $puid;
    /**
     * @var int 标签ID
     */
    public $tag_id;
    /**
     * @var int
     */
    public $is_meet;
    /**
     * @var int 满足条件的blogId
     */
    public $blog_id;
    /**
     * @var int 是否发放优惠券
     */
    public $is_coupon;
    /**
     * @var int 已经抽奖次数
     */
    public $lottery_time;
    /**
     * @var int 剩余的抽奖次数
     */
    public $lottery_left;
    
    /**
     * 转成数组
     * @param bool $empty_convert 如果结果为空，是否转成stdClass
     * @return array|object
     */
    public function arrayPack($empty_convert = false)
    {
        $result = array();
        if (null !== $this->id) {
            $result['id'] = (int)$this->id;
        }
        if (null !== $this->puid) {
            $result['puid'] = (string)$this->puid;
        }
        if (null !== $this->tag_id) {
            $result['tag_id'] = (int)$this->tag_id;
        }
        if (null !== $this->is_meet) {
            $result['is_meet'] = (int)$this->is_meet;
        }
        if (null !== $this->blog_id) {
            $result['blog_id'] = (int)$this->blog_id;
        }
        if (null !== $this->is_coupon) {
            $result['is_coupon'] = (int)$this->is_coupon;
        }
        if (null !== $this->lottery_time) {
            $result['lottery_time'] = (int)$this->lottery_time;
        }
        if (null !== $this->lottery_left) {
            $result['lottery_left'] = (int)$this->lottery_left;
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
        if (isset($data['id'])) {
            $this->id = (int)$data['id'];
        }
        if (isset($data['puid'])) {
            $this->puid = (string)$data['puid'];
        }
        if (isset($data['tag_id'])) {
            $this->tag_id = (int)$data['tag_id'];
        }
        if (isset($data['is_meet'])) {
            $this->is_meet = (int)$data['is_meet'];
        }
        if (isset($data['blog_id'])) {
            $this->blog_id = (int)$data['blog_id'];
        }
        if (isset($data['is_coupon'])) {
            $this->is_coupon = (int)$data['is_coupon'];
        }
        if (isset($data['lottery_time'])) {
            $this->lottery_time = (int)$data['lottery_time'];
        }
        if (isset($data['lottery_left'])) {
            $this->lottery_left = (int)$data['lottery_left'];
        }
    }
}