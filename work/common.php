<?php

use UiStd\Common\Config;
use UiStd\Uis\Base\ServerHandler;
use UiStd\Uis\Base\Uis;

define('ROOT_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
chdir(__DIR__);
//检查 是否加载  pcntl 扩展，用于信号监听
if (!function_exists('pcntl_signal')) {
    die("extension pcntl.so not loaded!!\n");
}
require_once '../vendor/autoload.php';
$GLOBALS['APP_NAME'] = isset($argv[1]) ? strtolower(trim($argv[1])) : '';
if (empty($GLOBALS['APP_NAME'])) {
    die("please input app name!\n");
}
$config = require(ROOT_PATH . 'config/config.php');

/**
 * 初始化日志
 * @param string $file_name
 */
function init_logger($file_name)
{
    $server = new ServerHandler();
    $file_name = strtr($file_name, '/\\', '__');
    $path = $GLOBALS['APP_NAME'].'/crontab/'. $file_name;
    $server->setPathInfo($path);
    $server->parse();
    Uis::getLogger();
}

Config::init($config);
