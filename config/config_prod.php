<?php

return array(
    //接口超时时间
    'default_curl_timeout' => 1000,
    //临时目录
    'runtime_path' => '/var/wd/ui_service/',
    //环境【重要】
    'env' => 'prod',
    //日志配置
    'uis-logger' => array(
        'host' => '10.213.72.138',
        'log_post_size' => 4096
    ),
    //接口配置
    'uis-http' => array(
        'debug_mode' => false,
        'gateway_host' => 'http://api.uistd.com'
    ),
    //公共redis集群
    'uis-cache:public' => array(
        'type' => 'clusterRedis',
        'server' => array(
            '10.209.230.63:11006',
            '10.209.230.64:11007',
            '10.209.230.65:11008',
            '10.209.230.66:11009',
            '10.209.230.67:11010',
            '10.209.230.68:11011',
        )
    ),
);
