<?php

use UiStd\Dop\Tool\PublicSchema;

define('ROOT_PATH', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
chdir(__DIR__);

require_once ROOT_PATH . 'vendor/autoload.php';
$type = isset($argv[1]) ? $argv[1] : '';
if (!isset($path)) {
    $path = __DIR__ . '/xml';
}
if ('push' === $type || 'pull' === $type) {
    run_action($type);
} else {
    echo '请选择公共协议文件更新方式。' . PHP_EOL;
    echo '1 将本地变更push到公共仓库', PHP_EOL;
    echo '2 将公共仓库的文件同步到本地', PHP_EOL;
    echo '请输入: 1 或者 2', PHP_EOL;
    $fp = fopen('php://stdin', 'r');
    $input = fgets($fp, 255);
    fclose($fp);
    $input = trim($input);
    if ('1' === $input) {
        run_action('push');
    } elseif ('2' === $input) {
        run_action('pull');
    } else {
        echo '输入出错', PHP_EOL;
    }
}

function run_action($type)
{
    global $path;
    if ('pull' === $type) {
        PublicSchema::pull($path);
    } else {
        PublicSchema::push($path);
    }
}
