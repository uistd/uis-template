<?php

namespace Uis\Dao\Demo\Model;

//以下代码由工具自动生成。 数据库发生改变时，在项目主目录运行 php tool/dao/build.php 重新生成

/**
 *  table of life_star_record
 * @package Uis\Dao\Demo\Model
 */
class LifeStarRecordModel
{

    /**
     * @var int
     */
    public $id;
    /**
     * @var string 用户puid
     */
    public $puid;
    /**
     * @var int 文章
     */
    public $blog_id;
    /**
     * @var string 文章标题
     */
    public $title;
    /**
     * @var int 被打上的标签
     */
    public $tag_id;
    /**
     * @var int 图片数
     */
    public $pic;
    /**
     * @var int 文字数
     */
    public $words;
    /**
     * @var int 是否分享
     */
    public $share_flag;
    /**
     * @var string 发文章时的devInfo
     */
    public $devInfo;
    /**
     * @var string 设备设备
     */
    public $wdId;
    /**
     * @var string 设备ID
     */
    public $ddId;
    /**
     * @var string 设备号
     */
    public $siedc;
    
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
        if (null !== $this->blog_id) {
            $result['blog_id'] = (int)$this->blog_id;
        }
        if (null !== $this->title) {
            $result['title'] = (string)$this->title;
        }
        if (null !== $this->tag_id) {
            $result['tag_id'] = (int)$this->tag_id;
        }
        if (null !== $this->pic) {
            $result['pic'] = (int)$this->pic;
        }
        if (null !== $this->words) {
            $result['words'] = (int)$this->words;
        }
        if (null !== $this->share_flag) {
            $result['share_flag'] = (int)$this->share_flag;
        }
        if (null !== $this->devInfo) {
            $result['devInfo'] = (string)$this->devInfo;
        }
        if (null !== $this->wdId) {
            $result['wdId'] = (string)$this->wdId;
        }
        if (null !== $this->ddId) {
            $result['ddId'] = (string)$this->ddId;
        }
        if (null !== $this->siedc) {
            $result['siedc'] = (string)$this->siedc;
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
        if (isset($data['blog_id'])) {
            $this->blog_id = (int)$data['blog_id'];
        }
        if (isset($data['title'])) {
            $this->title = (string)$data['title'];
        }
        if (isset($data['tag_id'])) {
            $this->tag_id = (int)$data['tag_id'];
        }
        if (isset($data['pic'])) {
            $this->pic = (int)$data['pic'];
        }
        if (isset($data['words'])) {
            $this->words = (int)$data['words'];
        }
        if (isset($data['share_flag'])) {
            $this->share_flag = (int)$data['share_flag'];
        }
        if (isset($data['devInfo'])) {
            $this->devInfo = (string)$data['devInfo'];
        }
        if (isset($data['wdId'])) {
            $this->wdId = (string)$data['wdId'];
        }
        if (isset($data['ddId'])) {
            $this->ddId = (string)$data['ddId'];
        }
        if (isset($data['siedc'])) {
            $this->siedc = (string)$data['siedc'];
        }
    }
}