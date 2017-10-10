<?php

namespace Uis\Demo\Page;

use FFan\Dop\Uis\Page;
use Protocol\Demo\Main\IndexRequest;
use Protocol\Demo\Main\IndexResponse;

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
