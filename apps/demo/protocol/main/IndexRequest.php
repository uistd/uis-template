<?php

namespace ffan\dop\main;

/**
 *  
 * @package ffan\dop\main
 */
class IndexRequest
{
    /**
     * @var int
     */
    public $a = 10;
    
    /**
     * @var int
     */
    public $b = 100;
    
    /**
     * @var string 数据有效性检查出错消息
     */
    private $validate_error_msg;
    
    /**
     * 对象初始化
     * @param array $data
     */
    public function arrayUnpack(array $data)
    {
        if (isset($data['a'])) {
            $this->a = (int)$data['a'];
        }
        if (isset($data['b'])) {
            $this->b = (int)$data['b'];
        }
    }
    
    /**
     * 验证数据有效性
     * @return bool
     */
    public function validateCheck()
    {
        return true;
    }
    
    /**
     * 获取出错的消息
     * @return string|null
     */
    public function getValidateErrorMsg()
    {
        return $this->validate_error_msg;
    }
}