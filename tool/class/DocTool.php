<?php

namespace Uis\Tool;

use FFan\Dop\Manager;
use FFan\Dop\Plugin\Valid\ValidRule;
use FFan\Dop\Protocol\Item;
use FFan\Dop\Protocol\ItemType;
use FFan\Dop\Protocol\ListItem;
use FFan\Dop\Protocol\MapItem;
use FFan\Dop\Protocol\Struct;
use FFan\Dop\Protocol\StructItem;
use FFan\Dop\Uis\Application;
use FFan\Dop\Uis\IRequest;
use FFan\Dop\Uis\Tool;
use FFan\Std\Common\Config;
use FFan\Std\Common\Str;
use FFan\Std\Tpl\Tpl;

/**
 * Class DocTool
 * @package Uis\Tool
 */
class DocTool extends Tool
{
    /**
     * @var Struct[]
     */
    private $all_struct;

    /**
     * @var Struct[] 依赖的model
     */
    private $require_model = array();

    /**
     * @var array 模型备注
     */
    private $model_note = array();

    /**
     * @var string 协议目录
     */
    private $protocol_dir;

    /**
     * DocTool constructor.
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->protocol_dir = ROOT_PATH . 'tool/protocol/xml';
    }

    /**
     * @param string $str
     * @return string
     */
    private function formatPath($str)
    {
        $tmp = explode('/', $str);
        foreach ($tmp as &$item) {
            $item = Str::camelName($item);
        }
        return join('/', $tmp);
    }

    /**
     * 主执行函数
     */
    public function action()
    {
        $server = $this->app->getServerInfo();
        if (isset($_GET['api_list']) && 1 === (int)$_GET['api_list']) {
            $this->apiList();
        }
        if (isset($_GET['api_name'])) {
            $api_info = Str::split($_GET['api_name'], '/');
            $app = isset($api_info[0]) ? $api_info[0] : '';
            $page = isset($api_info[1]) ? $api_info[1] : '';
            $action_name = isset($api_info[2]) ? $api_info[2] : '';
        }
        if (empty($app) || empty($page) || empty($action_name)) {
            $app = $server->getAppName();
            $page = Str::underlineName($server->getPageName());
            $action_name = $server->getActionName();
        }
        /** @var string $page */
        $xml = $app . '/' . $page . '.xml';
        $option_str = '[build]' . PHP_EOL . 'include_file = "common.xml,extra.xml,' . $xml . '"';
        $dop_manager = new Manager($this->protocol_dir, $option_str);
        $re = $dop_manager->initProtocol();
        if (!$re) {
            dd($dop_manager->getBuildLog());
        }
        $tmp_all_struct = $dop_manager->getAllStruct();
        foreach ($tmp_all_struct as $key => $value) {
            $new_key = $this->formatPath($key);
            $this->all_struct[$new_key] = $value;
        }
        unset($tmp_all_struct);
        $u_app_name = Str::camelName($app);
        $u_page_name = Str::camelName($page);
        /** @var string $action_name */
        $action_name = Str::camelName($action_name);
        $request_class = '/' . $u_app_name . '/' . $u_page_name . '/' . $action_name . 'Request';
        $response_class = '/' . $u_app_name . '/' . $u_page_name . '/' . $action_name . 'Response';
        $this->requireModel($request_class);
        $request = $this->formatSchema();
        $this->require_model = array();
        $this->requireModel($response_class);
        $response = $this->formatSchema();
        if (!empty($request)) {
            $api_name = isset($this->model_note[$response_class]) ? $this->model_note[$response_class] : '';
            $request[0]['note'] = $api_name . ' 请求参数';
        }
        $api_result = array(
            'class_name' => 'api/result',
            'model' => array(
                'status' => array(
                    'type' => 'int',
                    'note' => '状态码（0：成功）'
                ),
                'message' => array(
                    'type' => 'string',
                    'note' => '返回消息'
                )
            ),
            'note' => ' 接口返回结果',
            'href_name' => 'api/result'
        );
        if (empty($response)) {
            $response[] = $api_result;
        } else {
            $first_response = array_shift($response);
            //如果 first_response中带 data，和api_result合并
            if (isset($first_response['model']['data'])) {
                $api_result['model'] += $first_response['model'];
                array_unshift($response, $api_result);
            } else {
                $api_result['model']['data'] = array(
                    'type' => '#' . substr($response_class, 1),
                    'note' => '数据'
                );
                array_unshift($response, $first_response);
                array_unshift($response, $api_result);
            }
        }
        $more_url = $this->makeUrl();
        $tpl_data = array(
            'request' => $request,
            'response' => $response,
            'title' => '接口文档',
            'more_url' => $more_url
        );
        if (isset($this->all_struct[$request_class])) {
            $request_model = $this->all_struct[$request_class];
            $mock_class = '\\Protocol\\PluginMock\\' . $u_app_name . '\\Mock' . $u_app_name . $u_page_name;
            $method = 'mock' . $action_name . 'Request';
            $data = array();
            if (class_exists($mock_class) && is_callable([$mock_class, $method])) {
                $data = call_user_func(array($mock_class, $method));
            }
            if (method_exists($data, 'arrayPack')) {
                $data = $data->arrayPack();
            }
            $uri = $app . '/' . $page . '/' . $action_name;
            $example = $this->curlSample($uri, $data, $request_model->getMethod());
            $tpl_data['curl_example'] = $example;
        }
        Tpl::run('doc', $tpl_data);
        exit(0);
    }

    /**
     * 生成curl请求串
     * @param string $uri
     * @param array $data
     * @param string $method
     * @return string
     */
    private function curlSample($uri, $data, $method)
    {
        $host = $_SERVER['HTTP_HOST'];
        $url = 'http://' . $host;
        if (80 != $_SERVER['SERVER_PORT']) {
            $url .= ':' . $_SERVER['SERVER_PORT'];
        }
        $url .= '/' . $uri;
        if ('GET' === $method) {
            return $url . '?' . http_build_query($data);
        } else {
            return 'curl -H "Content-Type: application/json" -X ' . $method . '  --data \'' . json_encode($data, JSON_UNESCAPED_UNICODE) . '\' ' . $url;
        }
    }

    /**
     * 生成url
     * @param bool $api_list
     * @param string $api_name
     * @return string
     */
    private function makeUrl($api_list = true, $api_name = '')
    {
        $result = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $this->app->getAppName() . '?TOOL_REQUEST=doc';
        if ($api_list) {
            $result .= '&api_list=1';
        }
        if (!empty($api_name)) {
            $result .= '&api_name=' . $api_name;
        }
        return $result;
    }

    /**
     * 接口列表
     */
    private function apiList()
    {
        $dop_manager = new Manager($this->protocol_dir, '[build]');
        $re = $dop_manager->initProtocol();
        if (!$re) {
            dd($dop_manager->getBuildLog());
        }
        $this->all_struct = $dop_manager->getAllStruct();
        $action_list = array();
        foreach ($this->all_struct as $name => $struct) {
            if (Struct::TYPE_REQUEST !== $struct->getType()) {
                continue;
            }
            $name = substr($name, 1, -7);
            $uri = $struct->getUri();
            if (empty($uri)) {
                $uri = $name;
            }
            $action_list[] = array(
                'method' => $struct->getMethod(),
                'uri' => $uri,
                'href' => $this->makeUrl(false, $name),
                'note' => $struct->getNote()
            );
        }
        $tpl_data = array(
            'action_list' => $action_list,
            'title' => '接口列表',
        );
        Tpl::run('api_list', $tpl_data);
        exit(0);
    }

    /**
     * 获取所有依赖的模型
     * @param string $class_name
     */
    private function requireModel($class_name)
    {
        $class_name = $this->formatPath($class_name);
        if (!isset($this->all_struct[$class_name])) {
            return;
        }
        $struct = $this->all_struct[$class_name];
        $items = $struct->getAllExtendItem();
        $this->require_model[$class_name] = 1;
        if (!isset($this->model_note[$class_name])) {
            $this->model_note[$class_name] = $struct->getNote();
        }
        foreach ($items as $name => $item) {
            $this->requireItem($item);
        }
    }

    /**
     * @param Item $item
     */
    private function requireItem($item)
    {
        $type = $item->getType();
        if (ItemType::STRUCT === $type) {
            /** @var StructItem $item */
            $sub_struct = $item->getStruct();
            $require_class = $sub_struct->getNamespace() . '/' . $sub_struct->getClassName();
            $this->requireModel($require_class);
        } elseif (ItemType::ARR === $type) {
            /** @var ListItem $item */
            $this->requireItem($item->getItem());
        } elseif (ItemType::MAP === $type) {
            /** @var MapItem $item */
            $this->requireItem($item->getValueItem());
        }
    }

    /**
     * 整理输出数据
     */
    private function formatSchema()
    {
        $result = array();
        foreach ($this->require_model as $class_name => $v) {
            $struct = $this->all_struct[$class_name];
            $all_item = $struct->getAllExtendItem();
            $tmp_model = array();
            /**
             * @var string $name
             * @var Item $item
             */
            foreach ($all_item as $name => $item) {
                $type_name = $this->typeName($item);
                $tmp_model[$name] = array(
                    'type' => $type_name,
                    'note' => $item->getNote(),
                );
                $default_value = $item->getDefault();
                if (null !== $default_value) {
                    $tmp_model[$name]['default'] = $default_value;
                }
                $valid_rule = $item->getPluginData('Valid');
                if (null !== $valid_rule) {
                    /** @var ValidRule $valid_rule */
                    $tmp_model[$name]['valid'] = $this->validDesc($valid_rule, $item);
                }
            }
            $result[] = array(
                'class_name' => $class_name,
                'model' => $tmp_model,
                'note' => $this->model_note[$class_name],
                'href_name' => str_replace('/', '_', $class_name)
            );
        }
        return $result;
    }

    /**
     * @param Item $item
     * @return mixed|string
     */
    private function typeName($item)
    {
        $type = $item->getType();
        switch ($type) {
            case ItemType::INT:
                return 'int';
            case ItemType::STRING:
                return 'string';
            case ItemType::ARR:
                /** @var ListItem $item */
                return 'Array[ ' . $this->typeName($item->getItem()) . ' ]';
            case ItemType::DOUBLE:
                return 'double';
            case ItemType::FLOAT:
                return 'float';
            case ItemType::BOOL:
                return 'bool';
            case ItemType::BINARY:
                return 'binary';
            case ItemType::STRUCT:
                /** @var StructItem $item */
                $struct = $item->getStruct();
                $class_name = $this->formatPath($struct->getFullName());
                $href_name = str_replace('/', '_', $class_name);
                return '<a href="#' . $href_name . '">#' . substr($class_name, 1) . '</a>';
            case ItemType::MAP:
                /** @var MapItem $item */
                $key = $item->getKeyItem();
                $value = $item->getValueItem();
                return '&lt;'. $this->typeName($key) .', '. $this->typeName($value) .'&gt;';
        }
        return 'UNKNOWN';
    }

    /**
     * validRule描述
     * @param ValidRule $rule
     * @param Item $item
     * @return string
     */
    private function validDesc($rule, $item)
    {
        $item_type = $item->getType();
        $desc = array();
        if ($rule->is_require) {
            $desc[] = '<span style="color:red">*[必填]</span>';
        }
        if ($rule->format_set) {
            if ('/' === $rule->format_set[0]) {
                $desc[] = '正则：' . $rule->format_set;
            } elseif (is_callable(['\FFan\Dop\DopValidator', 'is' . Str::camelName($rule->format_set)])) {
                $desc[] = '内置类型：' . $rule->format_set;
            }
        }
        if ($rule->is_add_slashes) {
            $desc[] = '自动转义';
        }
        if ($rule->is_trim) {
            $desc[] = '自动去除首尾空格';
        }
        if ($rule->is_strip_tags) {
            $desc[] = '自动去除html标签';
        } elseif ($rule->is_html_special_chars) {
            $desc[] = 'html标签自动转义';
        }
        if (!empty($rule->sets)) {
            $desc[] = '<span class="red">只允许['.join(', ', $rule->sets).']</span>';
        }
        if (!empty($rule->min_str_len) || !empty($rule->max_str_len)) {
            $len_type = array(1 => 'UTF-8长度计算方式', 2 => '中文占2长度', 3 => '中英文字符均占1长度');
            if (!empty($rule->min_str_len) && !empty($rule->max_str_len)) {
                $desc[] = '长度' . $rule->min_str_len . ' 至 ' . $rule->max_str_len . ' 之间';
            } elseif (!empty($rule->min_str_len)) {
                $desc[] = '最小长度 ' . $rule->min_str_len;
            } else {
                $desc[] = '最大长度 ' . $rule->max_str_len;
            }
            $desc[] = $len_type[$rule->str_len_type];
        }
        if (isset($rule->min_value) || isset($rule->max_value)) {
            $value_str = 'value';
            if (ItemType::ARR === $item_type) {
                $value_str = '数组长度';
            }
            if (isset($rule->min_value, $rule->max_value)) {
                $desc[] = $rule->min_value . ' ≤ ' . $value_str . ' ≤ ' . $rule->max_value;
            } elseif ($rule->min_value) {
                $desc[] = $value_str . ' ≥ ' . $rule->min_value;
            } else {
                $desc[] = $value_str . ' ≤ ' . $rule->max_value;
            }
        }
        return join('; ', $desc);
    }
}
