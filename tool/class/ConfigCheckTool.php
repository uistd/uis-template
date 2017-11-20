<?php

namespace Uis\Tool;

use FFan\Dop\Uis\Tool;

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
        $root_path = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR;
        $all_config = require($root_path . 'config/config.php');
        $result = array('开始检查 ');
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
        $result[] = 'APC => ' . (extension_loaded('apc') ? 'loaded' : 'not found');
        $result[] = '检查完成';
        die('<pre>' . join(PHP_EOL, $result) . '</pre>');
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
        $link_obj = new \mysqli($host, $user, $password, $database, $port);
        if ($link_obj->connect_errno) {
            return $link_obj->connect_error;
        }
        return 'success';
    }

    /**
     * 检查 Redis配置
     * @param array $conf_arr
     * @return string
     */
    private function checkRedis($conf_arr)
    {
        if (!isset($conf_arr['host'], $conf_arr['port'])) {
            return '缺少必要配置项';
        }
        $redis = new \Redis();
        $ret = $redis->connect($conf_arr['host'], $conf_arr['port'], 3);
        if ($ret) {
            return 'success';
        } else {
            return 'FAILED';
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
        return join(PHP_EOL, $result);
    }
}
