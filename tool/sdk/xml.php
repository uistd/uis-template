<?php
//php xml.php http://feed.intra.sit.ffan.com/v2/api-docs feed

define('ROOT_PATH', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
chdir(__DIR__);
require_once ROOT_PATH . 'vendor/autoload.php';
require_once ROOT_PATH . 'vendor/ffan/dop/tool/SwaggerToXml.php';

SwaggerToXml::folderDetect(__DIR__ .'/xml');