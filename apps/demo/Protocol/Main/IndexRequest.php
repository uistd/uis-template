<?php

namespace Uis\Demo\Protocol\Main;

use FFan\Dop\DopEncode;
use FFan\Dop\DopDecode;
use FFan\Dop\Uis\IResponse;

/**
 *  简单的测试
 * @package Uis\Demo\Protocol\Main
 */
class IndexRequest implements IResponse
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
     * 二进制打包
     * @param bool $pid 是否打包协议ID
     * @param bool $sign 是否签名
     * @param null|string $mask_key 加密字符
     * @return string
     */
    public function binaryEncode($pid = false, $sign = false, $mask_key = null)
    {
        $result = new DopEncode;
        if ($pid) {
            $result->writePid('/MainIndexRequest');
        }
        if ($sign) {
            $result->sign();
        }
        if (null !== $mask_key && is_string($mask_key)) {
            $result->mask($mask_key);
        }
        $result->writeString(self::binaryStruct());
        $result->writeInt($this->a);
        $result->writeInt($this->b);
        return $result->pack();
    }
    
    /**
     * 二进制解包
     * @param DopDecode|string $data
     * @param string|null $mask_key
     * @return bool
     */
    public function binaryDecode($data, $mask_key = null)
    {
        $decoder = $data instanceof DopDecode ? $data : new DopDecode($data);
        $data_arr = $decoder->unpack($mask_key);
        if ($decoder->getErrorCode()) {
            return false;
        }
        $this->arrayUnpack($data_arr);
        return true;
    }
    
    /**
     * 生成二进制协议头
     * @return String
     */
    public static function binaryStruct()
    {
        $byte_array = new DopEncode();
        $byte_array->writeString('a');
        //int32
        $byte_array->writeChar(0x42);
        $byte_array->writeString('b');
        //int32
        $byte_array->writeChar(0x42);
        return $byte_array->dump();
    }
    
    /**
     * 验证数据有效性
     * @return bool
     */
    public function validateCheck()
    {
        if (null !== $this->a) {
            if ($this->a < 1) {
                $this->validate_error_msg = "最小值1";
                return false;
            }
        }
        if (null !== $this->b) {
            if ($this->b < 1) {
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