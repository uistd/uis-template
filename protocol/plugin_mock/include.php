<?php
$mock_file_dir = __DIR__ . DIRECTORY_SEPARATOR;
FFan\Dop\AutoLoader::add(array(
    '\Protocol\Plugin\Mock\Demo' => $mock_file_dir . '/demo',
));