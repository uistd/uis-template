<?php
/**
 * 执行命令
 * php main.php demo
 */
use UiStd\Uis\Work\Manager;

require_once 'common.php';
init_logger('main');
$manager = new Manager($GLOBALS['APP_NAME']);
$manager->loop();
echo PHP_EOL, 'Bye!', PHP_EOL;

