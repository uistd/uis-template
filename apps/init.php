<?php
$app = \UiStd\Uis\Base\Application::getInstance();
if ('Demo' == $app->getAppCamelName()) {
    //初始化过滤器
    new \Uis\Filter\DemoFilter();
}
//默认加载 飞凡通用的用户认证
new \Uis\Filter\FFanAuthFilter();

//加载其它文件