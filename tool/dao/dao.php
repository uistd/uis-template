<?php

use UiStd\Common\Config;
use UiStd\Common\ConfigBase;
use UiStd\Common\Str;
use UiStd\Common\Utils;
use UiStd\Dop\Build\CodeBuf;

define('ROOT_PATH', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);
chdir(__DIR__);
require_once ROOT_PATH . 'vendor/autoload.php';
$config = require(ROOT_PATH . 'config/config.php');
Config::init($config);

class DaoHelper extends ConfigBase
{
    /**
     * @var string
     */
    private $file_name;

    /**
     * @var Mysqli
     */
    private $mysal_obj;

    /**
     * @var string 数据库名称
     */
    private $db_name;

    /**
     * @var string 配置名
     */
    private $config_name;

    /**
     * @var array 表信息
     */
    private $table_list;

    /**
     * @var array 索引信息
     */
    private $index_list;

    /**
     * SwaggerToXml constructor.
     * @param string $file_name
     * @param array $mysql_conf
     * @throws Exception
     */
    public function __construct($file_name, $mysql_conf)
    {
        $this->file_name = $file_name;
        $this->initConfig($mysql_conf);
        $this->config_name = $this->getConfigString('config_name', 'main');
        $config_key = 'uis-mysql:' . $this->config_name;
        $db_config = Config::get($config_key);
        //如果存在数据库配置
        if (is_array($db_config)) {
            $host = $db_config['host'];
            $port = isset($db_config['port']) ? $db_config['port'] : 3306;
            $user = $db_config['user'];
            $password = $db_config['password'];
            $database = $db_config['database'];
        } else {
            $host = $this->getConfig('host', '127.0.0.1');
            $user = $this->getConfig('user');
            $password = $this->getConfig('password', '');
            $database = $this->getConfig('database');
            $port = 3306;
            if (false !== strpos($host, ':')) {
                $tmp = Str::split($host, ':');
                $host = $tmp[0];
                $port = (int)$tmp[1];
            }
        }
        if (empty($user) || empty($database)) {
            throw new Exception($this->file_name . ' 缺少mysql配置');
        }
        $link_obj = new mysqli($host, $user, $password, 'information_schema', $port);
        if ($link_obj->connect_errno) {
            throw new Exception($link_obj->connect_error);
        }
        $this->mysal_obj = $link_obj;
        $this->db_name = $database;
        $this->initTable();
        $this->initIndex();
        $this->build();
    }

    /**
     * @param string $sql
     * @return array
     */
    private function queryMany($sql)
    {
        $res = $this->mysal_obj->query($sql);
        $rows = array();
        if (!$res) {
            return $rows;
        }
        while ($row = $res->fetch_array()) {
            $rows[] = $row;
        }
        $res->free();
        return $rows;
    }

    /**
     * 生成
     */
    private function build()
    {
        foreach ($this->table_list as $table_name => $value) {
            $this->makeTable($table_name);
        }
    }

    /**
     * 按表生成类
     * @param string $table_name
     */
    private function makeTable($table_name)
    {
        $code_buf = new CodeBuf();
        $u_db_name = Str::camelName($this->file_name);
        $code_buf->pushStr('<?php')->emptyLine();
        $code_buf->pushStr('namespace Dao\\' . $u_db_name . '\\Tpl;')->emptyLine();
        $u_table_name = Str::camelName($table_name);
        $model_class = $u_table_name . 'Model';
        $full_model_class = 'Dao\\' . $u_db_name . '\Model\\' . $model_class;
        $code_buf->pushStr('use ' . $full_model_class . ';');
        $code_buf->pushStr('use UiStd\Mysql\TplBase;')->emptyLine();
        $class_name = $u_table_name . 'Tpl';
        $code_buf->pushStr('/**');
        $code_buf->pushStr(' * Class ' . $class_name);
        $code_buf->pushStr(' */');
        $code_buf->pushStr('abstract class ' . $class_name . ' extends TplBase');
        $code_buf->pushStr('{')->indent()->emptyLine();
        $code_buf->pushStr('const TABLE_NAME = "' . $table_name . '";')->emptyLine();
        $code_buf->pushStr('const MODEL_CLASS = "' . $full_model_class . '";')->emptyLine();
        if (!empty($this->config_name)) {
            $code_buf->pushStr('/**');
            $code_buf->pushStr(' * @var string 数据库配置');
            $code_buf->pushStr(' */');
            $code_buf->pushStr("protected \$mysql_config_name = '".$this->config_name."';")->emptyLine();
        }
        $code_buf->pushStr('/**');
        $code_buf->pushStr(' * 插入一条记录');
        $code_buf->pushStr(' * @param ' . $model_class . '$model');
        $code_buf->pushStr(' */');
        $code_buf->pushStr('public function insert(' . $model_class . ' $model)');
        $code_buf->pushStr('{')->indent();
        $code_buf->pushStr('$data = $model->arrayPack();');
        $code_buf->pushStr('$this->getDb()->insert(\'' . $table_name . '\', $data);');
        $code_buf->backIndent()->pushStr('}');
        $this->buildPrimaryMethod($code_buf, $table_name, $model_class);
        $this->buildIndexMethod($code_buf, $table_name, $model_class);
        $code_buf->backIndent()->pushStr('}')->emptyLine();
        $path = Utils::fixWithRootPath('dao/' . $u_db_name . '/Tpl');
        Utils::pathWriteCheck($path);
        $file_name = $path . '/' . $class_name . '.php';
        echo 'Build ' . $file_name;
        $re = file_put_contents($file_name, $code_buf->dump());
        if ($re) {
            echo ' success';
        } else {
            echo ' failed';
        }
        echo PHP_EOL;
    }

    /**
     * 主键方法生成
     * @param CodeBuf $code_buf
     * @param string $table_name
     * @param string $model_class
     */
    private function buildPrimaryMethod($code_buf, $table_name, $model_class)
    {
        $pk = $this->getPrimaryKey($table_name);
        if (null === $pk) {
            return;
        }
        $pk_type = $this->getColumnType($table_name, $pk);
        $code_buf->emptyLine()->pushStr('/**');
        $code_buf->pushStr(' * 主键 查找');
        $code_buf->pushStr(' * @param ' . $pk_type . ' $' . $pk);
        $code_buf->pushStr(' * @return null|' . $model_class);
        $code_buf->pushStr(' */');
        $code_buf->pushStr('public function get($' . $pk . ')');
        $code_buf->pushStr('{')->indent();
        $code_buf->pushStr('$db = $this->getDb();');
        $code_buf->pushStr("\$sql = 'SELECT * FROM `$table_name` WHERE `$pk`=\"' . \$$pk . '\"';");
        $code_buf->pushStr('/** @var ' . $model_class . ' $result */');
        $code_buf->pushStr('$result = $db->getRow($sql, self::MODEL_CLASS);');
        $code_buf->pushStr('return $result;');
        $code_buf->backIndent()->pushStr('}');

        $code_buf->emptyLine()->pushStr('/**');
        $code_buf->pushStr(' * 主键 查找多条记录');
        $code_buf->pushStr(' * @param ' . $pk_type . '[] $' . $pk .'_list');
        $code_buf->pushStr(' * @return ' . $model_class .'[]');
        $code_buf->pushStr(' */');
        $code_buf->pushStr('public function getIn(array $' . $pk . '_list)');
        $code_buf->pushStr('{')->indent();
        $code_buf->pushStr('$db = $this->getDb();');
        $code_buf->pushStr("\$sql = 'SELECT * FROM `$table_name` WHERE `{$pk}` in (\"' . join('\",\"', \${$pk}_list) . '\")';");
        $code_buf->pushStr('$result = $db->getMultiRow($sql, self::MODEL_CLASS);');
        $code_buf->pushStr('return $result;');
        $code_buf->backIndent()->pushStr('}');

        $code_buf->emptyLine()->pushStr('/**');
        $code_buf->pushStr(' * 主键 更新');
        $code_buf->pushStr(' * @param ' . $model_class . ' $model');
        $code_buf->pushStr(' * @param array $append_where 附加的条件');
        $code_buf->pushStr(' * @return int 影响条数');
        $code_buf->pushStr(' * @throws \Exception');
        $code_buf->pushStr(' */');
        $code_buf->pushStr('public function update(' . $model_class . ' $model, $append_where = null)');
        $code_buf->pushStr('{')->indent();
        $code_buf->pushStr('$db = $this->getDb();');
        $code_buf->pushStr('$data = $model->arrayPack();');
        $code_buf->pushStr('if (!isset($data["' . $pk . '"])) {');
        $code_buf->pushIndent('throw new \\Exception("Primary key ' . $pk . ' required.");');
        $code_buf->pushStr('}');
        $code_buf->pushStr('unset($data["' . $pk . '"]);');
        $code_buf->pushStr('$this->whereInit()->whereSet("' . $pk . '", $data["' . $pk . '"]);');
        $code_buf->pushStr('if (is_array($append_where)) {');
        $code_buf->pushIndent('$this->whereAppend($append_where);');
        $code_buf->pushStr('}');
        $code_buf->pushStr('return $db->update(self::TABLE_NAME, $data, $this->whereDump());');
        $code_buf->backIndent()->pushStr('}');

        $code_buf->emptyLine()->pushStr('/**');
        $code_buf->pushStr(' * 主键 删除');
        $code_buf->pushStr(' * @param ' . $pk_type . ' $' . $pk);
        $code_buf->pushStr(' * @param array $append_where 附加的条件');
        $code_buf->pushStr(' * @return int 影响条数');
        $code_buf->pushStr(' */');
        $code_buf->pushStr('public function delete($' . $pk . ', $append_where = null)');
        $code_buf->pushStr('{')->indent();
        $code_buf->pushStr('$db = $this->getDb();');
        $code_buf->pushStr('$this->whereInit()->whereSet("' . $pk . '", $' . $pk . ');');
        $code_buf->pushStr('if (is_array($append_where)) {');
        $code_buf->pushIndent('$this->whereAppend($append_where);');
        $code_buf->pushStr('}');
        $code_buf->pushStr('return $db->delete(self::TABLE_NAME, $this->whereDump());');
        $code_buf->backIndent()->pushStr('}');
    }

    /**
     * 其它索引方法
     * @param CodeBuf $code_buf
     * @param string $table_name
     * @param string $model_class
     */
    private function buildIndexMethod($code_buf, $table_name, $model_class)
    {
        if (!isset($this->index_list[$table_name])) {
            return;
        }
        $index_list = $this->index_list[$table_name];
        unset($index_list['PRIMARY']);
        if (empty($index_list)) {
            return;
        }
        $key_map = array();
        foreach ($index_list as $index_name => $index_items) {
            $tmp_arr = array();
            //联合索引, 依次生成
            foreach($index_items as $name) {
                $tmp_arr[] = $name;
                //避免多个联合索引 生成同一个字段 的方法
                $tmp_key = join(',', $tmp_arr);
                if (isset($key_map[$tmp_key])) {
                    continue;
                }
                $key_map[$tmp_key] = true;
                $this->buildIndexMethodCode($code_buf, $table_name, $model_class, $index_name, $tmp_arr);
            }
        }
    }

    /**
     * 生成一个索引的方法
     * @param CodeBuf $code_buf
     * @param string $table_name
     * @param string $model_class
     * @param string $index_name
     * @param array $items
     */
    private function buildIndexMethodCode($code_buf, $table_name, $model_class, $index_name, $items)
    {
        $code_buf->emptyLine()->pushStr('/**');
        $code_buf->pushStr(' * 索引 '.$index_name.' 查找多条记录');
        $column_arr = array();
        $func_name = '';
        $params = array();
        foreach ($items as $column_name) {
            $params[] = '$'. $column_name;
            $func_name .= Str::camelName($column_name);
            $column_arr[$column_name] = $this->getColumnType($table_name, $column_name);
        }
        foreach ($column_arr as $column_name => $type) {
            $code_buf->pushStr(' * @param '. $type .' $'. $column_name);
        }
        $code_buf->pushStr(' * @param array|null $append_where 附加的条件');
        $code_buf->pushStr(' * @return ' . $model_class .'[]');
        $code_buf->pushStr(' */');
        $code_buf->pushStr('public function batchBy'.$func_name.'('.join(', ', $params).', $append_where = null)');
        $code_buf->pushStr('{')->indent();
        $code_buf->pushStr('$db = $this->getDb();');
        $code_buf->pushStr('$this->whereInit();');
        foreach ($items as $name) {
            $code_buf->pushStr('$this->whereSet("'.$name.'", $'.$name.');');
        }
        $code_buf->pushStr('if (is_array($append_where)) {');
        $code_buf->pushIndent('$this->whereAppend($append_where);');
        $code_buf->pushStr('}');
        $code_buf->pushStr("\$sql = 'SELECT * FROM `$table_name` WHERE '.\$this->whereDump();");
        $code_buf->pushStr('return $db->getMultiRow($sql, self::MODEL_CLASS);');
        $code_buf->backIndent()->pushStr('}');

        $code_buf->emptyLine()->pushStr('/**');
        $code_buf->pushStr(' * 索引 '.$index_name.' 单条更新');
        $column_arr = array();
        $func_name = '';
        $params = array();
        foreach ($items as $column_name) {
            $params[] = '$'. $column_name;
            $func_name .= Str::camelName($column_name);
            $column_arr[$column_name] = $this->getColumnType($table_name, $column_name);
        }
        foreach ($column_arr as $column_name => $type) {
            $code_buf->pushStr(' * @param '. $type .' $'. $column_name);
        }
        $code_buf->pushStr(' * @param array|null $append_where 附加的条件');
        $code_buf->pushStr(' * @return ' . $model_class);
        $code_buf->pushStr(' */');
        $code_buf->pushStr('public function getBy'.$func_name.'('.join(', ', $params).', $append_where = null)');
        $code_buf->pushStr('{')->indent();
        $code_buf->pushStr('$db = $this->getDb();');
        $code_buf->pushStr('$this->whereInit();');
        foreach ($items as $name) {
            $code_buf->pushStr('$this->whereSet("'.$name.'", $'.$name.');');
        }
        $code_buf->pushStr('if (is_array($append_where)) {');
        $code_buf->pushIndent('$this->whereAppend($append_where);');
        $code_buf->pushStr('}');
        $code_buf->pushStr("\$sql = 'SELECT * FROM `$table_name` WHERE '.\$this->whereDump() .' LIMIT 1';");
        $code_buf->pushStr('return $db->getRow($sql, self::MODEL_CLASS);');
        $code_buf->backIndent()->pushStr('}');
    }

    /**
     * 获取主键索引
     * @param string $table_name
     * @return null|string
     */
    private function getPrimaryKey($table_name)
    {
        if (!isset($this->index_list[$table_name]['PRIMARY'])) {
            return null;
        }
        return $this->index_list[$table_name]['PRIMARY'][0];
    }

    /**
     * 初始化索引信息
     */
    private function initIndex()
    {
        $table_index = array();
        $all_index = $this->queryMany('select * from `KEY_COLUMN_USAGE` where `TABLE_SCHEMA` = "' . $this->db_name . '"');
        foreach ($all_index as $row) {
            $table_name = $row['TABLE_NAME'];
            $column_name = $row['COLUMN_NAME'];
            $table_index[$table_name][$row['CONSTRAINT_NAME']][] = $column_name;
        }
        $this->index_list = $table_index;
    }

    /**
     * 获取字段 类型
     * @param string $table_name
     * @param string $column_name
     * @return string
     */
    private function getColumnType($table_name, $column_name)
    {
        return $this->table_list[$table_name][$column_name];
    }

    /**
     * 初始化表信息
     */
    private function initTable()
    {
        $table_list = array();
        $all_tables = $this->queryMany('SELECT * FROM tables where table_schema="' . $this->db_name . '" order by TABLE_NAME');
        foreach ($all_tables as $table) {
            $table_name = $table['TABLE_NAME'];
            $table_list[$table_name] = array();
            $columns = $this->queryMany('SELECT * FROM columns where `table_name`="' . $table_name . '"');
            foreach ($columns as $column) {
                $name = $column['COLUMN_NAME'];
                $type = $column['DATA_TYPE'];
                $table_list[$table_name][$name] = $this->varType($type);
            }
        }
        $this->table_list = $table_list;
    }

    /**
     * mysql类型转php类型
     * @param $data_type
     * @return string
     */
    private function varType($data_type)
    {
        static $type_map = array(
            'INTEGER' => 'int',
            'INT' => 'int',
            'TINYINT' => 'int',
            'SMALLINT' => 'int',
            'MEDIUMINT' => 'int',
            'BIGINT' => 'int',
            'FLOAT' => 'float',
            'DOUBLE' => 'float',
        );
        $type = strtoupper($data_type);
        if (isset($type_map[$type])) {
            return $type_map[$type];
        } else {
            return 'string';
        }
    }

    /**
     * 检测整个目录
     * @param string $folder
     */
    public static function folderDetect($folder)
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
            $full_file = Utils::joinFilePath($folder, $file);
            if (is_dir($full_file)) {
                self::folderDetect($full_file);
            }
            if ('.xml' === substr($file, -4)) {
                self::xmlInstance($full_file);
            }
        }
    }

    /**
     * @param \DOMElement $node
     * @return null|array
     */
    private static function getAllAttribute($node)
    {
        $attributes = $node->attributes;
        $count = $attributes->length;
        $result = null;
        for ($i = 0; $i < $count; ++$i) {
            $tmp = $attributes->item($i);
            $name = $tmp->nodeName;
            $value = $tmp->nodeValue;
            $result[$name] = $value;
        }
        return $result;
    }

    /**
     * 获取实例
     * @param string $file_name
     */
    private static function xmlInstance($file_name)
    {
        $xml_doc = new DOMDocument();
        $xml_doc->load($file_name);
        $xml_path = new DOMXPath($xml_doc);
        $protocol = $xml_path->query('/protocol');
        $main_node = $protocol->item(0);
        if ('mysql' !== $main_node->getAttribute('type')) {
            return;
        }
        $mysql_conf = self::getAllAttribute($main_node);
        new self(basename($file_name, '.xml'), $mysql_conf);
    }
}

DaoHelper::folderDetect(__DIR__ .'/xml');
