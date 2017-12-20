<?php

namespace Uis\Page\Demo;

use Uis\Activity\Demo\DemoActivity;
use UiStd\Uis\Base\ActivityManager;
use UiStd\Uis\Base\Page;
use UiStd\Http\HttpClient;
use Uis\Protocol\Demo\Index\MainData;
use Uis\Protocol\Demo\Index\MainRequest;
use Uis\Protocol\Demo\Index\UserCompData;
use Uis\Protocol\Demo\Index\UserCompRequest;
use Uis\Protocol\Demo\Index\UserData;
use Uis\Protocol\Demo\Index\UserRequest;
use Uis\Sdk\UserPlatform\ApiGetUser;

class IndexPage extends Page
{
    /**
     * Response  setData 示例
     * @param MainRequest $request
     */
    public function actionMain(MainRequest $request)
    {
        $data = new MainData();
        $data->plus = $request->a + $request->b;
        $data->minus = $request->b - $request->a;
        $data->divide = $request->b / $request->a;
        $data->multiply = $request->a * $request->b;
        $this->response->setData($data);
    }

    /**
     * 查看用户信息的示例【严格模式】
     * @param UserRequest $request
     */
    public function actionUser(UserRequest $request)
    {
        $api = new ApiGetUser();
        $api->keyword = $request->puid;
        //使用严格模式获取数据, 一旦服务端报错，下面的代码就不会执行了
        $result = $api->getResult(HttpClient::STRICT_MODE);
        $response = new UserData();
        //抛出一个活动事件
        ActivityManager::getInstance()->trigger(DemoActivity::DEMO_EVENT, $result);
        $response->nick_name = $result->nick_name;
        $response->gender = $result->gender;
        $response->avatar = $result->head_portrait;
        $response->mobile = $result->mobile;
        $this->response->setData($response);
    }

    /**
     * 查看用户信息的示例【兼容模式】
     * @param UserCompRequest $request
     */
    public function actionUserComp(UserCompRequest $request)
    {
        $api = new ApiGetUser();
        $api->keyword = $request->puid;
        //使用兼容模式获取代码,就算服务端报错, 也会返回空对象
        $result = $api->getResult();
        $response = new UserCompData();
        $response->nick_name = $result->nick_name;
        $response->gender = $result->gender;
        $response->avatar = $result->head_portrait;
        $response->mobile = $result->mobile;
        $this->response->setData($response);
    }
}
