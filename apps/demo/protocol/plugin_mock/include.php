<?php
$mock_file_dir = __DIR__ . DIRECTORY_SEPARATOR;
FFan\Dop\AutoLoader::add(array(
    '\Uis\Demo\Plugin\Mock\Main' => $mock_file_dir,
));