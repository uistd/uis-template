<?php
define('ROOT_PATH', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
chdir(__DIR__);
require_once ROOT_PATH . 'vendor/autoload.php';

$build_config = <<<EOT
[build]
namespace = 'Sdk'
coder = 'php'
packer = 'array, uis_sdk'
code_side = 'client,server'
protocol_type = 'action'
path_type = 'root'
build_path = "sdk"
shader = '*'
;继承的类
property_name = 'underline'
request_class_extends = "FFan\Std\Http\HttpClient"
keep_action_name = true
request_class_prefix = 'Api'
response_class_suffix = 'Result'
EOT;
$manager = new \FFan\Dop\Manager(ROOT_PATH . 'tool/sdk/xml', $build_config);
$manager->registerPacker('uis_sdk', __DIR__ .'/packer/UisSdkPack.php');
$build_re = $manager->build();
echo $manager->getBuildLog(), PHP_EOL;
if (true !== $build_re) {
    echo '编译失败', PHP_EOL;
}
