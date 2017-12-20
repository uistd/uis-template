<?php
$app = \UiStd\Uis\Base\Application::getInstance();
if ('Demo' == $app->getAppCamelName()) {
    //初始化过滤器
    new \Uis\Filter\DemoFilter();
}

//加载其它文件