<?php
//活动时间段配置，框架会自动检测时间，不会触发过期的活动
return array(
    'CONFIG_SIT' => array(
        'Demo' => '2017-1-1 00:00:00, 2117-12-1 23:59:59',
    ),

    'CONFIG_UAT' => array(
        'Demo' => '2017-1-1 00:00:00, 2117-12-1 23:59:59',
    ),

    'CONFIG_PROD' => array(
        'Demo' => '1970-1-1 00:00:00, 1970-1-1 23:59:59',
    ),
);