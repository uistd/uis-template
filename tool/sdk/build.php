<?php
use UiStd\Dop\Manager;

define('ROOT_PATH', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
chdir(__DIR__);
require_once ROOT_PATH . 'vendor/autoload.php';

$manager = new Manager(ROOT_PATH . 'tool/sdk/xml');
$manager->registerPacker('uis_sdk', __DIR__ .'/packer/UisSdkPack.php');
$build_re = $manager->build();
echo $manager->getBuildLog(), PHP_EOL;
if (true !== $build_re) {
    echo '编译失败', PHP_EOL;
}
