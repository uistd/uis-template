<?php

use UiStd\Common\Config;
use UiStd\Dop\Manager;
use UiStd\Dop\Tool\GitHelper;

define('ROOT_PATH', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
chdir(__DIR__);

require_once ROOT_PATH . 'vendor/autoload.php';
$config = require(ROOT_PATH . 'config/config.php');
Config::init($config);

$build_name = isset($argv[1]) ? $argv[1] : 'main';


$build_ini_content = file_get_contents(__DIR__ . '/xml/build.ini');
$build_conf = parse_ini_string($build_ini_content, true);
$protocol_dir = 'tool/protocol/xml';
$git_tool = new GitHelper();
$git_tool->init($build_conf, $build_name);
$manager = new Manager($protocol_dir);
if ('objc' === $build_name) {
    $manager->registerPacker('objc_uri', __DIR__ . '/packer/ObjcUriPack.php');
    $manager->registerPacker('head_objc_uri', __DIR__ . '/packer/HeadObjcUriPack.php');
}
$build_result = $manager->build($build_name);
echo $manager->getBuildLog(), PHP_EOL;
if (true !== $build_result) {
    echo '编译失败', PHP_EOL;
} else {
    echo $git_tool->pushCode(), PHP_EOL;
}
