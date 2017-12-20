<?php

use UiStd\Common\Config;
use UiStd\Common\Env;
use UiStd\Logger\FileLogger;
use UiStd\Logger\LogHelper;
use UiStd\Logger\LogLevel;

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
    LogHelper::getLogRouter();
    $log_level = 0xffff;
    if (Env::isProduct()) {
        $log_level ^= LogLevel::DEBUG;
    }
    new FileLogger('logs/' . $GLOBALS['APP_NAME'] . '/crontab/', $file_name, $log_level, FileLogger::OPT_SPLIT_BY_DAY);
}

Config::init($config);
