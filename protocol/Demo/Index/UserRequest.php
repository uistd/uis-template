<?php

namespace Protocol\Demo\Index;

use UiStd\Uis\Base\IRequest;
use UiStd\Dop\DopValidator;

/**
 *  根据puid获取用户信息的demo【严格模式】
 * @package Protocol\Demo\Index
 */
class UserRequest implements IRequest
{

    /**
     * @var string
     */
    public $puid;
    
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
    }
    
    /**
     * 验证数据有效性
     * @return bool
     */
    public function validateCheck()
    {
        if (!is_string($this->puid) || 0 === strlen($this->puid)) {
            $this->validate_error_msg = "puid必须填写";
            return false;
        }
        if (!DopValidator::isMd5($this->puid)) {
            $this->validate_error_msg = "puid格式错误";
            return false;
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