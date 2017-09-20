<?php

use ffan\dop\Manager;
use FFan\Std\Common\Config as FFanConfig;

require_once '../vendor/autoload.php';
$app_name = isset($argv[1]) ? $argv[1] : 'demo';
$build_name = isset($argv[2]) ? $argv[2] : 'main';


FFanConfig::addArray(
    array(
        'env' => 'dev',
        'runtime_path' => __DIR__ . '/runtime',
    )
);

$manager = new Manager('tool/protocol/'. $app_name);
$section_name = isset($argv[1]) ? $argv[1] : 'main';
$build_result = $manager->build($section_name);
echo $manager->getBuildLog(), PHP_EOL;
if (true !== $build_result) {
    echo '编译失败', PHP_EOL;
    exit();
}
