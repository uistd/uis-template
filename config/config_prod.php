<?php

return array(
    'default_curl_timeout' => 1000,
    'runtime_path' => '/var/wd/ui_service/',
    'env' => 'prod',
    'log_path' => 'logs',
    //主redis集群
    'cluster-redis:main' => array(
        '10.209.230.61:11005',
        '10.209.230.63:11006',
        '10.209.230.64:11007',
        '10.209.230.65:11008',
        '10.209.230.66:11009',
        '10.209.230.67:11010',
        '10.209.230.68:11011',
    )
);
