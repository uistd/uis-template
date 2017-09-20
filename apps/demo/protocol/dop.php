<?php
$dop_file_dir = __DIR__ . DIRECTORY_SEPARATOR;
ffan\dop\AutoLoader::add(array(
    'ffan\dop\main' => $dop_file_dir . 'main',
));