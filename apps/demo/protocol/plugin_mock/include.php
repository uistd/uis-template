<?php
$mock_file_dir = __DIR__ . DIRECTORY_SEPARATOR;
ffan\dop\AutoLoader::add(array(
    'ffan\dop\plugin\mock\main' => $mock_file_dir,
));