<?php

namespace Protocol\PluginMock\Demo;

use Protocol\Demo\Index\MainRequest;
use Protocol\Demo\Index\MainData;
use Protocol\Demo\Index\MainResponse;
use Protocol\Demo\Index\UserRequest;
use Protocol\Demo\Index\UserData;
use Protocol\Demo\Index\UserResponse;
use Protocol\Demo\Index\UserCompRequest;
use Protocol\Demo\Index\UserCompData;
use Protocol\Demo\Index\UserCompResponse;

class MockDemoIndex extends \FFan\Dop\DopMock
{
    
    /**
     * 生成 MainRequest mock数据
     * @return MainRequest
     */
    public static function mockMainRequest()
    {
        $data = new MainRequest();
        $data->a = mt_rand(0, 100);
        $data->b = mt_rand(0, 100);
        return $data;
    }
    
    /**
     * 生成 MainData mock数据
     * @return MainData
     */
    public static function mockMainData()
    {
        $data = new MainData();
        $data->plus = mt_rand(1, 100);
        $data->minus = mt_rand(1, 10);
        $data->multiply = mt_rand(100, 1000);
        $data->divide = self::floatRangeMock(0, 10);
        return $data;
    }
    
    /**
     * 生成 MainResponse mock数据
     * @return MainResponse
     */
    public static function mockMainResponse()
    {
        $data = new MainResponse();
        $data->data = self::mockMainData();
        return $data;
    }
    
    /**
     * 生成 UserRequest mock数据
     * @return UserRequest
     */
    public static function mockUserRequest()
    {
        $data = new UserRequest();
        $data->puid = self::strRangeMock(5, 20);
        return $data;
    }
    
    /**
     * 生成 UserData mock数据
     * @return UserData
     */
    public static function mockUserData()
    {
        $data = new UserData();
        $data->nick_name = self::strRangeMock(5, 20);
        $data->gender = mt_rand(0, 100);
        $data->avatar = self::strRangeMock(5, 20);
        $data->mobile = self::strRangeMock(5, 20);
        return $data;
    }
    
    /**
     * 生成 UserResponse mock数据
     * @return UserResponse
     */
    public static function mockUserResponse()
    {
        $data = new UserResponse();
        $data->data = self::mockUserData();
        return $data;
    }
    
    /**
     * 生成 UserCompRequest mock数据
     * @return UserCompRequest
     */
    public static function mockUserCompRequest()
    {
        $data = new UserCompRequest();
        $data->puid = self::strRangeMock(5, 20);
        $data->a = mt_rand(0, 100);
        return $data;
    }
    
    /**
     * 生成 UserCompData mock数据
     * @return UserCompData
     */
    public static function mockUserCompData()
    {
        $data = new UserCompData();
        $data->nick_name = self::strRangeMock(5, 20);
        $data->gender = mt_rand(0, 100);
        $data->avatar = self::strRangeMock(5, 20);
        $data->mobile = self::strRangeMock(5, 20);
        return $data;
    }
    
    /**
     * 生成 UserCompResponse mock数据
     * @return UserCompResponse
     */
    public static function mockUserCompResponse()
    {
        $data = new UserCompResponse();
        $data->data = self::mockUserCompData();
        return $data;
    }
}
