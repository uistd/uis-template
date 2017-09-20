<?php

namespace ffan\dop\plugin\mock\main;

use ffan\dop\main\IndexRequest;
use ffan\dop\main\IndexResponse;

class MockMain extends \ffan\dop\DopMock
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
        $data->plus = mt_rand(0, 100);
        $data->minus = mt_rand(0, 100);
        $data->multiply = mt_rand(0, 100);
        $data->divide = mt_rand(0, 100);
        return $data;
    }
}
