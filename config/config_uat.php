<?php

return array(
    'default_curl_timeout' => 2000,
    'runtime_path' => '/var/wd/log/ui_service/',
    'env' => 'uat',
    'log_path' => 'logs',
    //主redis集群
    'cluster-redis:main' => array(
        '10.213.33.170:10401',
        '10.213.33.170:10616',
        '10.213.33.170:10596',
        '10.213.33.170:10652',
    )
);
