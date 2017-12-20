<?php

return array(
    //接口超时时间
    'default_curl_timeout' => 2000,
    //临时目录
    'runtime_path' => '/var/wd/ui_service/',
    //环境【重要】
    'env' => 'uat',
    //日志配置
    'uis-logger' => array(
        'host' => '127.0.0.1',
        'log_post_size' => 0xffff
    ),
    //接口配置
    'uis-http' => array(
        'debug_mode' => true,
        'gateway_host' => 'http://api.uat.ffan.com'
    ),
    //公共redis集群
    'uis-cache:public' => array(
        'type' => 'clusterRedis',
        'server' => array(
            '10.213.33.170:10401',
            'w10716.uat.wdds.redis.com:10716',
            '10.213.33.170:10596',
            'w10652.uat.wdds.redis.com:10652',
        )
    ),
    //crontab配置
    'uis-work' => array(
        '* * * * * Demo/DemoWork.php'
    ),
);
