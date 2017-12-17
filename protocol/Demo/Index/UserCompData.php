<?php

namespace Protocol\Demo\Index;

use FFan\Dop\DopEncode;

/**
 *  
 * @package Protocol\Demo\Index
 */
class UserCompData
{

    /**
     * @var string 昵称
     */
    public $nick_name;
    /**
     * @var int 男女
     */
    public $gender;
    /**
     * @var string 头像
     */
    public $avatar;
    /**
     * @var string 手机号
     */
    public $mobile;
    
    /**
     * 转成数组
     * @param bool $empty_convert 如果结果为空，是否转成stdClass
     * @return array|object
     */
    public function arrayPack($empty_convert = false)
    {
        $result = array();
        if (null !== $this->nick_name) {
            $result['nickName'] = (string)$this->nick_name;
        }
        if (null !== $this->gender) {
            $result['gender'] = (int)$this->gender;
        }
        if (null !== $this->avatar) {
            $result['avatar'] = (string)$this->avatar;
        }
        if (null !== $this->mobile) {
            $result['mobile'] = (string)$this->mobile;
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
        if (isset($data['nickName'])) {
            $this->nick_name = (string)$data['nickName'];
        }
        if (isset($data['gender'])) {
            $this->gender = (int)$data['gender'];
        }
        if (isset($data['avatar'])) {
            $this->avatar = (string)$data['avatar'];
        }
        if (isset($data['mobile'])) {
            $this->mobile = (string)$data['mobile'];
        }
    }
    
    /**
     * 二进制打包
     * @param DopEncode $result
     */
    public function binaryPack($result)
    {
        $result->writeString($this->nick_name);
        $result->writeInt($this->gender);
        $result->writeString($this->avatar);
        $result->writeString($this->mobile);
    }
    
    /**
     * 生成二进制协议头
     * @return String
     */
    public static function binaryStruct()
    {
        $byte_array = new DopEncode();
        $byte_array->writeString('nickName');
        //string
        $byte_array->writeChar(0x1);
        $byte_array->writeString('gender');
        //unsigned int32
        $byte_array->writeChar(0xc2);
        $byte_array->writeString('avatar');
        //string
        $byte_array->writeChar(0x1);
        $byte_array->writeString('mobile');
        //string
        $byte_array->writeChar(0x1);
        return $byte_array->dump();
    }
}