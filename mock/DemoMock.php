<?php
namespace Uis\Mock;

use Uis\Protocol\Demo\Index\UserResponse;

/**
 * Class DemoMock 定制化的mock
 * @package Uis\Mock
 */
class DemoMock
{
    /**
     * @param UserResponse $response
     */
    public function mockIndexUser(UserResponse $response)
    {
        $response->data->nick_name = '定制的mock昵称';
    }
}
