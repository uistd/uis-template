<?php

use UiStd\Dop\Tool\SwaggerToXml;

define('ROOT_PATH', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
chdir(__DIR__);
require_once ROOT_PATH . 'vendor/autoload.php';

SwaggerToXml::folderDetect(__DIR__ . '/xml');