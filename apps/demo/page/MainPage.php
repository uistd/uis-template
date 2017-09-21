<?php

namespace Uis\Demo\Main;

use FFan\Dop\Uis\Page;

class MainPage extends Page
{
    /**
     * index
     * @param IndexRequest $request
     */
    public function actionIndex(IndexRequest $request)
    {
        $response = new IndexResponse();
        $response->plus = $request->a + $request->b;
        $response->minus = $request->b - $request->a;
        $response->divide = $request->b / $request->a;
        $response->multiply = $request->a * $request->b;
        $this->response->setResponse($response);
        $this->response->appendData('data', time());
    }
}
