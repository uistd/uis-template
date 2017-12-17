<?php

use FFan\Dop\Manager;
use FFan\Std\Common\Config as FFanConfig;
use FFan\Std\Tpl\Tpl;

define('ROOT_PATH', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
chdir(__DIR__);

require_once ROOT_PATH . 'vendor/autoload.php';
require_once ROOT_PATH . 'vendor/ffan/dop/tool/GitHelper.php';

$build_name = isset($argv[1]) ? $argv[1] : 'main';

FFanConfig::addArray(array(
        'env' => 'dev',
        'runtime_path' => dirname(dirname(__DIR__)) . '/runtime',
        'ffan-tpl' => array('tpl_dir' => 'tool/protocol')
    )
);

$build_ini_content = Tpl::get('make.tpl');
$build_conf = parse_ini_string($build_ini_content, true);
$protocol_dir = 'tool/protocol/xml';
$git_tool = new GitHelper();
$git_tool->init($build_conf, $build_name);
$manager = new Manager($protocol_dir, $build_ini_content);
if ('objc' === $build_name) {
    $manager->registerPacker('objc_uri', __DIR__ .'/packer/ObjcUriPack.php');
    $manager->registerPacker('head_objc_uri', __DIR__ .'/packer/HeadObjcUriPack.php');
}
$build_result = $manager->build($build_name);
echo $manager->getBuildLog(), PHP_EOL;
if (true !== $build_result) {
    echo '编译失败', PHP_EOL;
} else {
    echo $git_tool->pushCode(), PHP_EOL;
}
