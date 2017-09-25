<?php
$mock_file_dir = __DIR__ . DIRECTORY_SEPARATOR;
FFan\Dop\AutoLoader::add(array(
    '\Uis\Demo\Protocol\Plugin\Mock' => $mock_file_dir,
));