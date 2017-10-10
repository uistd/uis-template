<?php

namespace Protocol\Plugin\Mock\Demo;

use Protocol\Demo\Main\IndexRequest;
use Protocol\Demo\Main\IndexResponse;

class MockDemoMain extends \FFan\Dop\DopMock
{
    
    /**
     * 生成 IndexRequest mock数据
     * @return IndexRequest
     */
    public static function mockIndexRequest()
    {
        $data = new IndexRequest();
        $data->a = mt_rand(0, 100);
        $data->b = mt_rand(0, 100);
        return $data;
    }
    
    /**
     * 生成 IndexResponse mock数据
     * @return IndexResponse
     */
    public static function mockIndexResponse()
    {
        $data = new IndexResponse();
        $data->plus = mt_rand(1, 100);
        $data->minus = mt_rand(1, 10);
        $data->multiply = mt_rand(100, 1000);
        $data->divide = self::floatRangeMock(0, 10);
        return $data;
    }
}
