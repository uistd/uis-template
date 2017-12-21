<?php

use UiStd\Dop\Manager;
use UiStd\Common\Config;
use UiStd\Common\Str;
use UiStd\Common\Utils;
use UiStd\Dop\Tool\MysqlToXml;

define('ROOT_PATH', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
chdir(__DIR__);
require_once ROOT_PATH . 'vendor/autoload.php';
$config = require(ROOT_PATH . 'config/config.php');
Config::init($config);

function build_config($name_space)
{
    $result = array('[build]');
    $result[] = 'namespace = "Uis\\' . $name_space . '"';
    $result[] = 'coder = "php"';
    $result[] = 'protocol_type = "data"';
    $result[] = 'build_path = "dao/build"';
    $result[] = 'no_autoload_file = true';
    $result[] = 'keep_original_name = true';
    $result[] = 'packer = "array"';
    $result[] = 'code_side = "client"';
    $result[] = 'file_mark = "以下代码由工具自动生成。 数据库发生改变时，在项目主目录运行 php tool/dao/build.php 重新生成"';
    return join(PHP_EOL, $result);
}

function build($folder)
{
    $dir_fd = opendir($folder);
    if (!$dir_fd) {
        return;
    }
    while ($file = readdir($dir_fd)) {
        $file = strtolower($file);
        if ('.' === $file{0}) {
            continue;
        }
        if ('.xml' !== substr($file, -4)) {
            continue;
        }
        $folder = str_replace('.xml', '', $file);
        $build_folder = Utils::fixWithRuntimePath('dao/' . $folder);
        $full_file = Utils::joinFilePath(__DIR__ . '/xml', $file);
        Utils::pathWriteCheck($build_folder);
        Utils::pathWriteCheck(Utils::fixWithRuntimePath('dao/build/'));
        $des_file = Utils::joinFilePath($build_folder, 'model.xml');
        copy($full_file, $des_file);
        MysqlToXml::folderDetect($build_folder);
        $camel_folder = Str::camelName($folder);
        $name_space = 'Dao\\' . $camel_folder;
        $build_config = build_config($name_space);
        $manager = new Manager($build_folder, $build_config);
        $build_re = $manager->build();
        if (true !== $build_re) {
            echo $full_file . ' 编译失败', PHP_EOL;
            continue;
        }
        echo $manager->getBuildLog(), PHP_EOL;
        $build_path = Utils::fixWithRootPath('dao/' . $camel_folder .'/Model');
        Utils::pathWriteCheck($build_path);
        Utils::delDir($build_path);
        $build_result_path = Utils::fixWithRuntimePath('dao/build/Model');
        echo $build_path, PHP_EOL;
        echo $build_result_path, PHP_EOL;
        rename($build_result_path, $build_path);
    }
}

//先更新当前目录下的所有xml文件
$path = __DIR__ .'/xml';
build($path);
