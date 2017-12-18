<?php

return array(
    //接口超时时间
    'default_curl_timeout' => 3000,
    //临时目录
    'runtime_path' => '/var/wd/log/ui_service/',
    //环境【重要】
    'env' => 'sit',
    //日志配置
    'logger' => array(
        'host' => '127.0.0.1',
    ),
    //接口配置
    'uis-http' => array(
        'debug_mode' => true,
        'gateway_host' => 'http://api.sit.ffan.com'
    ),
    //公共redis集群
    'uis-cache:public' => array(
        'type' => 'clusterRedis',
        'server' => array(
            '10.213.33.156:10401',
            '10.213.33.156:10616',
            '10.213.33.156:10596',
            '10.213.33.156:10652',
        )
    )
);
