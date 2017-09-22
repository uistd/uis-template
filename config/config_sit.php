<?php

return array(
    'default_curl_timeout' => 3000,
    'runtime_path' => '/var/wd/log/ui_service/',
    'env' => 'sit',
    'log_path' => 'logs',
    //主redis集群
    'cluster-redis:main' => array(
        '10.213.33.156:10401',
        '10.213.33.156:10616',
        '10.213.33.156:10596',
        '10.213.33.156:10652',
    )
);
