<?php

return array(
    //默认的curl超时时间
    'default_curl_timeout' => 3000,
    //环境 dev, sit, uat, prod
    'env' => 'dev',
    //日志目录，默认在runtime目录的logs
    'log_path' => 'logs',
    //接口配置
    'uis-http' => array(
        'debug_mode' => true,
        'gateway_host' => 'http://api.sit.ffan.com'
    ),
    'uis-work' => array(
        '* * * * * Demo/DemoWork.php'
    )
);
