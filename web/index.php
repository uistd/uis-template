<?php
//根目录
define('ROOT_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);

$config = require(ROOT_PATH . 'config/config.php');
require(ROOT_PATH . 'vendor/autoload.php');
(new \FFan\Dop\Uis\Application($config))->run();
debugTotalTime();
