<?php
//php xml.php http://feed.intra.sit.ffan.com/v2/api-docs feed

define('ROOT_PATH', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
chdir(__DIR__);
require_once ROOT_PATH . 'vendor/autoload.php';
require_once ROOT_PATH . 'vendor/ffan/dop/tool/SwaggerToXml.php';

if (!isset($argv[1])) {
    exit("请输入swagger api file\n");
}
$doc_file = $argv[1];
$file = isset($argv[2]) ? $argv[2] : 'protocol';
$file_name = ROOT_PATH . 'tool/sdk/' . $file . '.xml';

new SwaggerToXml($doc_file, $file_name);