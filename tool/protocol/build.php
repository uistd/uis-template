<?php

use FFan\Dop\Manager;
use FFan\Std\Common\Config as FFanConfig;
use FFan\Std\Tpl\Tpl;

define('ROOT_PATH', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
chdir(__DIR__);

require_once ROOT_PATH . 'vendor/autoload.php';
$build_name = isset($argv[1]) ? $argv[1] : 'main';

FFanConfig::addArray(
    array(
        'env' => 'dev',
        'runtime_path' => dirname(__DIR__) . '/runtime',
        'ffan-tpl' => array(
            'tpl_dir' => 'tool/protocol'
        )
    )
);
$build_ini_content = Tpl::get('make.tpl');
$protocol_dir = 'tool/protocol';
$manager = new Manager($protocol_dir, $build_ini_content);
$build_result = $manager->build($build_name);
echo $manager->getBuildLog(), PHP_EOL;
if (true !== $build_result) {
    echo '编译失败', PHP_EOL;
}
