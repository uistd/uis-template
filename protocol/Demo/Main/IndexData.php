<?php

namespace Protocol\Demo\Main;

use FFan\Dop\DopEncode;

/**
 *  
 * @package Protocol\Demo\Main
 */
class IndexData
{

    /**
     * @var int 加
     */
    public $plus;
    /**
     * @var int 减
     */
    public $minus;
    /**
     * @var int 乘
     */
    public $multiply;
    /**
     * @var float 除
     */
    public $divide;
    
    /**
     * 转成数组
     * @param bool $empty_convert 如果结果为空，是否转成stdClass
     * @return array|object
     */
    public function arrayPack($empty_convert = false)
    {
        $result = array();
        if (null !== $this->plus) {
            $result['plus'] = (int)$this->plus;
        }
        if (null !== $this->minus) {
            $result['minus'] = (int)$this->minus;
        }
        if (null !== $this->multiply) {
            $result['multiply'] = (int)$this->multiply;
        }
        if (null !== $this->divide) {
            $result['divide'] = (float)$this->divide;
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
        if (isset($data['plus'])) {
            $this->plus = (int)$data['plus'];
        }
        if (isset($data['minus'])) {
            $this->minus = (int)$data['minus'];
        }
        if (isset($data['multiply'])) {
            $this->multiply = (int)$data['multiply'];
        }
        if (isset($data['divide'])) {
            $this->divide = (float)$data['divide'];
        }
    }
    
    /**
     * 二进制打包
     * @param DopEncode $result
     */
    public function binaryPack($result)
    {
        $result->writeInt($this->plus);
        $result->writeInt($this->minus);
        $result->writeInt($this->multiply);
        $result->writeFloat($this->divide);
    }
    
    /**
     * 生成二进制协议头
     * @return String
     */
    public static function binaryStruct()
    {
        $byte_array = new DopEncode();
        $byte_array->writeString('plus');
        //int32
        $byte_array->writeChar(0x42);
        $byte_array->writeString('minus');
        //int32
        $byte_array->writeChar(0x42);
        $byte_array->writeString('multiply');
        //int32
        $byte_array->writeChar(0x42);
        $byte_array->writeString('divide');
        //float
        $byte_array->writeChar(0x3);
        return $byte_array->dump();
    }
}