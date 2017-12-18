<?php

namespace Uis\Demo\Page;

use UiStd\Uis\Base\Page;
use UiStd\Http\HttpClient;
use Protocol\Demo\Index\MainData;
use Protocol\Demo\Index\MainRequest;
use Protocol\Demo\Index\UserCompData;
use Protocol\Demo\Index\UserCompRequest;
use Protocol\Demo\Index\UserData;
use Protocol\Demo\Index\UserRequest;
use Sdk\UserPlatform\ApiGetUser;

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
        $api_re = $api->request();
        if (200 !== $api_re->status) {
            HttpClient::fixErrorMessage($api_re);
            $this->errorResult($api_re);
        }
        $result = $api->getResult();
        $response = new UserData();
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
        $result = $api->getResult();
        $response = new UserCompData();
        $response->nick_name = $result->nick_name;
        $response->gender = $result->gender;
        $response->avatar = $result->head_portrait;
        $response->mobile = $result->mobile;
        $this->response->setData($response);
    }
}
