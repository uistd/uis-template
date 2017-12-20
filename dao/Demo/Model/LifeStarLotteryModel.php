<?php

namespace Uis\Dao\Demo\Model;

//以下代码由工具自动生成。 数据库发生改变时，在项目主目录运行 php tool/dao/build.php 重新生成

/**
 *  table of life_star_lottery
 * @package Uis\Dao\Demo\Model
 */
class LifeStarLotteryModel
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
     * @var string 标签
     */
    public $tag_id;
    /**
     * @var int 抽奖的次数
     */
    public $time_id;
    /**
     * @var string 结果
     */
    public $result;
    /**
     * @var int 创建时间
     */
    public $create_time;
    
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
            $result['tag_id'] = (string)$this->tag_id;
        }
        if (null !== $this->time_id) {
            $result['time_id'] = (int)$this->time_id;
        }
        if (null !== $this->result) {
            $result['result'] = (string)$this->result;
        }
        if (null !== $this->create_time) {
            $result['create_time'] = (int)$this->create_time;
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
            $this->tag_id = (string)$data['tag_id'];
        }
        if (isset($data['time_id'])) {
            $this->time_id = (int)$data['time_id'];
        }
        if (isset($data['result'])) {
            $this->result = (string)$data['result'];
        }
        if (isset($data['create_time'])) {
            $this->create_time = (int)$data['create_time'];
        }
    }
}