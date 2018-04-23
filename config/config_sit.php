<?php

return array(
    //接口超时时间
    'default_curl_timeout' => 3000,
    //临时目录
    'runtime_path' => '/var/wd/ui_service/',
    //环境【重要】
    'env' => 'sit',
    //日志配置
    'uis-logger' => array(
        'host' => '127.0.0.1',
        'log_post_size' => 0xffff
    ),
    //接口配置
    'uis-http' => array(
        'debug_mode' => true,
        'gateway_host' => 'http://api.sit.uistd.com'
    ),

    //crontab配置
    'uis-work' => array(
        '* * * * * Demo/DemoWork.php'
    ),
);
