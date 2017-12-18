<?php
//根目录
define('ROOT_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
ob_start();
$config = require(ROOT_PATH . 'config/config.php');
require(ROOT_PATH . 'vendor/autoload.php');
(new \UiStd\Uis\Base\Application($config))->run();
debugTotalTime();
