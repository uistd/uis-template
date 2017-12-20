<?php

namespace Uis\Tool;

use UiStd\Common\Str;
use UiStd\Uis\Base\Response;
use UiStd\Uis\Base\Result;
use UiStd\Uis\Base\ServerHandler;
use UiStd\Uis\Base\Tool;

/**
 * Class MockTool Mock数据
 * @package Uis\Tool
 */
class MockTool extends Tool
{

    /**
     * 主执行函数
     */
    public function action()
    {
        $server = ServerHandler::getInstance();
        $page_name = $server->getPageName();
        $u_page_name = Str::camelName($page_name);
        $action_name = $server->getActionName();
        $app_name = $this->app->getAppCamelName();
        $ns = '\Uis\Protocol\PluginMock\\' . $app_name;
        $mock_class = $ns . '\Mock' . $app_name . $u_page_name;
        $response = $this->app->getResponse();
        if (!class_exists($mock_class)) {
            $response->setStatus(Response::STATUS_PAGE_NOT_FOUND, 'Mock class ' . $mock_class . ' not found');
            return;
        }
        $method = 'mock' . $action_name . 'Response';
        $ref = new \ReflectionClass($mock_class);
        if (!$ref->hasMethod($method)) {
            $response->setStatus(Response::STATUS_PAGE_NOT_FOUND, 'Mock action ' . $mock_class . '::' . $method . ' not found');
            return;
        }
        /** @var Result $data */
        $data = call_user_func(array($mock_class, $method));
        $data->status = 0;
        $data->message = 'MOCK DATA';
        $response->setResult($data);

        //如果 存在mock方法，将mock出来的对象 调用 mock 方法 二次加工
        $class_name = 'Uis\Mock\\' . $app_name . 'Mock';
        if (class_exists($class_name)) {
            $mock_obj = new $class_name();
            $call_func = 'mock' . $u_page_name . $action_name;
            if (method_exists($mock_obj, $call_func)) {
                call_user_func([$mock_obj, $call_func], $data);
            }
        }
    }
}