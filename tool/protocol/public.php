<?php

use UiStd\Dop\Tool\PublicSchema;

define('ROOT_PATH', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
chdir(__DIR__);

require_once ROOT_PATH . 'vendor/autoload.php';
$type = isset($argv[1]) ? $argv[1] : 'pull';
$path = __DIR__ . '/xml';
if ('push' === $type) {
    PublicSchema::push($path);
} else {
    PublicSchema::pull($path);
}
