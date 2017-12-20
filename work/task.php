<?php

use UiStd\Common\Str;
use UiStd\Logger\LogHelper;
use UiStd\Uis\Work\Crontab;

require_once 'common.php';
$class_name = str_replace('.php', '', $argv[2]);
$class_name = str_replace('/', '\\', $class_name);
$call_args = array();
if (count($argv) > 2) {
    $call_args = array_slice($argv, 3);
}
$class = '\Uis\Work\\'. $class_name;
if (!class_exists($class)) {
    init_logger('main');
    LogHelper::getLogRouter()->error('Class '. $class .' Not exist');
} else {
    $task_objct = new $class($GLOBALS['APP_NAME']);
    if (!($task_objct instanceof Crontab)) {
        init_logger('main');
        LogHelper::getLogRouter()->error('Class '. $class .' is not instance of \FFan\Uis\Wrok\Crontab');
    } else {
        init_logger($class_name);
        $arg_count = count($call_args);
        $init_func = array($task_objct, 'init');
        if (0 === $arg_count) {
            call_user_func($init_func);
        } elseif (1 === $arg_count) {
            call_user_func($init_func, $call_args[0]);
        } else {
            call_user_func_array($init_func, $call_args);
        }
    }
}
LogHelper::getLogRouter()->info('Bye!');