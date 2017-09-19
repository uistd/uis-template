<?php
define('ROOT_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);

$config = require(ROOT_PATH . 'config/config.php');
require(ROOT_PATH . 'vendor/autoload.php');
\FFan\Std\Common\Config::init($config);
$g_server = \FFan\Uis\Base\ServerHandler::getInstance();
//获取应用名称
$g_app_name = $g_server->getAppName();

if (isset($config['app-root-path'])) {
    define('APP_PATH', $config['app-root-path'] . $g_app_name . '/');
} else {
    define('APP_PATH', ROOT_PATH . 'apps/' . $g_app_name . '/');
}
$g_app = new \FFan\Uis\Base\Application();
$g_app->run();