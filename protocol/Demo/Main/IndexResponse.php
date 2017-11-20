<?php

namespace Protocol\Demo\Main;

use FFan\Dop\DopEncode;
use FFan\Dop\DopDecode;
use FFan\Dop\Uis\Result;

/**
 *  简单的测试
 * @package Protocol\Demo\Main
 */
class IndexResponse implements Result
{

    /**
     * @var IndexData
     */
    public $data;
    
    /**
     * 转成数组
     * @param bool $empty_convert 如果结果为空，是否转成stdClass
     * @return array|object
     */
    public function arrayPack($empty_convert = false)
    {
        $result = array();
        if (isset($this->data) && $this->data instanceof IndexData) {
            $result['data'] = $this->data->arrayPack($empty_convert);
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
        if (isset($data['data']) && is_array($data['data'])) {
            $struct_data = new IndexData();
            $struct_data->arrayUnpack($data['data']);
            $this->data = $struct_data;
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
            $result->writePid('/demo/MainIndexResponse');
        }
        if ($sign) {
            $result->sign();
        }
        if (null !== $mask_key && is_string($mask_key)) {
            $result->mask($mask_key);
        }
        $result->writeString(self::binaryStruct());
        if (!$this->data instanceof IndexData ) {
            $result->writeChar(0);
        } else {
            $result->writeChar(0xff);
            $this->data->binaryPack($result);
        }
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
        $byte_array->writeString('data');
        //struct
        $byte_array->writeChar(0x6);
        $byte_array->writeString(IndexData::binaryStruct());
        return $byte_array->dump();
    }
}