<?php
namespace Uis\Activity\Demo;

use Uis\Sdk\UserPlatform\UserDetail;
use UiStd\Console\Debug;
use UiStd\Uis\Base\Activity;
use UiStd\Uis\Base\ActivityManager;
use UiStd\Uis\Base\Uis;

/**
 * Class DemoActivity 活动Demo
 * @package Uis\Activity\Demo
 */
class DemoActivity extends Activity
{
    /**
     * 活动事件名
     */
    const DEMO_EVENT = 'demo-activity';

    /**
     * DemoActivity constructor.
     * @param string $name
     * @param array $conf
     */
    public function __construct($name, array $conf)
    {
        parent::__construct($name, $conf);
        Uis::debug('Config of Demo Activity');
        Uis::debug(Debug::varFormat($conf));
    }

    /**
     * 设置事件监听
     */
    public function attach()
    {
        //监听事件
        ActivityManager::getInstance()->attach(self::DEMO_EVENT, [$this, 'demoAction']);
    }

    /**
     * 活动相关代码
     * @param UserDetail $user
     */
    public function demoAction($user)
    {
        Uis::debug('Demo Activity');
        Uis::debug(Debug::varFormat($user));
    }
}
