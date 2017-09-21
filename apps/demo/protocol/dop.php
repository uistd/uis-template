<?php
$dop_file_dir = __DIR__ . DIRECTORY_SEPARATOR;
FFan\Dop\AutoLoader::add(array(
    '\Uis\Demo\Main' => $dop_file_dir . 'main',
));