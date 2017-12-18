<?php

namespace Protocol\Demo\Index;

use UiStd\Uis\Base\IRequest;

/**
 *  简单的测试
 * @package Protocol\Demo\Index
 */
class MainRequest implements IRequest
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
     * 转成数组
     * @param bool $empty_convert 如果结果为空，是否转成stdClass
     * @return array|object
     */
    public function arrayPack($empty_convert = false)
    {
        $result = array();
        if (null !== $this->a) {
            $result['a'] = (int)$this->a;
        }
        if (null !== $this->b) {
            $result['b'] = (int)$this->b;
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
        if (null !== $this->a) {
            if ($this->a < -0x80000000 || $this->a > 0x7fffffff) {
                $this->validate_error_msg = "最小值1";
                return false;
            }
        }
        if (null !== $this->b) {
            if ($this->b < -0x80000000 || $this->b > 0x7fffffff) {
                $this->validate_error_msg = "最小值1";
                return false;
            }
        }
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