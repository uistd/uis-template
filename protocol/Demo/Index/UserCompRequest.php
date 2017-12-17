<?php

namespace Protocol\Demo\Index;

use FFan\Dop\Uis\IRequest;

/**
 *  根据puid获取用户信息的demo【兼容模式】
 * @package Protocol\Demo\Index
 */
class UserCompRequest implements IRequest
{

    /**
     * @var string
     */
    public $puid;
    /**
     * @var int
     */
    public $a;
    
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
        if (null !== $this->puid) {
            $result['puid'] = (string)$this->puid;
        }
        if (null !== $this->a) {
            $result['a'] = (int)$this->a;
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
        if (isset($data['puid'])) {
            $this->puid = (string)$data['puid'];
        }
        if (isset($data['a'])) {
            $this->a = (int)$data['a'];
        }
    }
    
    /**
     * 验证数据有效性
     * @return bool
     */
    public function validateCheck()
    {
        if (!is_string($this->puid) || 0 === strlen($this->puid)) {
            $this->validate_error_msg = "Invalid `puid`";
            return false;
        }
        if (null !== $this->a) {
            if ($this->a < -0x80000000 || $this->a > 0x7fffffff) {
                $this->validate_error_msg = "Invalid integer range of `a`.";
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