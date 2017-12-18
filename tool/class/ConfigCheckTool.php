<?php

namespace Uis\Tool;

use UiStd\Uis\Base\Tool;

/**
 * Class ConfigCheckTool 检查配置
 * @package Uis\Tool
 */
class ConfigCheckTool extends Tool
{
    /**
     * 主执行函数
     */
    public function action()
    {
        if (isset($_GET['action']) && 'check' === $_GET['action']) {
            $this->doCheck();
        } else {
            $this->tpl('config_check');
        }
    }

    /**
     * 检查
     */
    private function doCheck()
    {
        $root_path = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR;
        $all_config = require($root_path . 'config/config.php');
        $result = array('开始检查 ');
        $result[] = 'PHP version:' . phpversion();
        foreach ($all_config as $name => $value) {
            //如果 是mysql的配置
            if (0 === strpos($name, 'ffan-mysql:')) {
                $result[] = $name . ' => ' . $this->checkMysql($value);
            }
            //redis配置
            if (0 === strpos($name, 'cache-redis:')) {
                $result[] = $name . ' => ' . $this->checkRedis($value);
            }
            //redis集群
            if (0 === strpos($name, 'cluster-redis:')) {
                $result[] = $name . ' => ' . $this->checkClusterRedis($value);
            }
        }
        $result[] = $this->extensionCheck('apcu');
        $result[] = $this->extensionCheck('mysqli');
        $result[] = $this->extensionCheck('redis');
        $result[] = $this->extensionCheck('igbinary');
        $result[] = $this->extensionCheck('curl');
        $result[] = $this->extensionCheck('qconf');
        $result[] = $this->functionCheck('mb_strlen');
        $result[] = $this->functionCheck('fsockopen');
        $result[] = $this->functionCheck('stream_socket_client');
        $result[] = '检查完成';
        echo join('<br>', $result);
        die();
    }

    /**
     * 检查 mysql配置
     * @param array $conf
     * @return string
     */
    private function checkMysql($conf)
    {
        //如果 没有这几项配置
        if (!isset($conf['host'], $conf['user'], $conf['password'], $conf['database'])) {
            return '缺少必要配置项';
        }
        $host = $conf['host'];
        $user = $conf['user'];
        $password = $conf['password'];
        $database = $conf['database'];
        $port = isset($conf['port']) ? $conf['port'] : 3306;
        $msg = $user . '@' . $host . ':' . $port . '/' . $database . ' ';
        $link_obj = new \mysqli($host, $user, $password, $database, $port);
        if ($link_obj->connect_errno) {
            return $this->msg($msg . $link_obj->connect_error, true);
        }
        return $this->msg($msg . 'success');
    }

    /**
     * 检查 Redis配置
     * @param array $conf_arr
     * @return string
     */
    private function checkRedis($conf_arr)
    {
        if (!isset($conf_arr['host'], $conf_arr['port'])) {
            return $this->msg('缺少必要配置项', true);
        }
        $redis = new \Redis();
        $msg = $conf_arr['host'] . ':' . $conf_arr['port'];
        $ret = $redis->connect($conf_arr['host'], $conf_arr['port'], 3);
        if ($ret) {
            return $this->msg($msg . ' success');
        } else {
            return $this->msg($msg . ' failed', true);
        }
    }

    /**
     * 检查 redis 集群
     * @param array $conf_arr
     * @return string
     */
    private function checkClusterRedis($conf_arr)
    {
        $result = array();
        foreach ($conf_arr as $i => $value) {
            $tmp = explode(':', $value);
            $conf = array();
            if (isset($tmp[0])) {
                $conf['host'] = $tmp[0];
            }
            if (isset($tmp[1])) {
                $conf['port'] = $tmp[1];
            }
            $result[] = '节点[' . $i . '] => ' . $this->checkRedis($conf);
        }
        return join('<br>', $result);
    }

    /**
     * @param string $msg
     * @param bool $is_error
     * @return string
     */
    private function msg($msg, $is_error = false)
    {
        $css = $is_error ? 'red' : 'green';
        return '<span class="' . $css . '">' . $msg . '</span>';
    }

    /**
     * 函数检查
     * @param string $func_name
     * @return string
     */
    private function functionCheck($func_name)
    {
        $re_str = 'function ' . $func_name . ' ';
        if (function_exists($func_name)) {
            $re_str .= $this->msg('exist');
        } else {
            $re_str .= $this->msg('NOT exist', true);
        }
        return $re_str;
    }

    /**
     * 扩展检查
     * @param string $extension
     * @return string
     */
    private function extensionCheck($extension)
    {
        $re_str = 'Extension ' . $extension . ' ';
        if (extension_loaded($extension)) {
            $re_str .= $this->msg('loaded');
        } else {
            $re_str .= $this->msg('NOT loaded', true);
        }
        return $re_str;
    }

    /**
     * 类检查
     * @param string $class_name
     * @return string
     */
    private function classCheck($class_name)
    {
        $re_str = 'Class ' . $class_name . ' ';
        if (class_exists($class_name)) {
            $re_str .= $this->msg('loaded');
        } else {
            $re_str .= $this->msg('NOT loaded', true);
        }
        return $re_str;
    }
}
