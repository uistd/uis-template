<?php

namespace Uis\Demo\Page;

use FFan\Dop\Uis\Page;
use Protocol\Demo\Main\IndexData;
use Protocol\Demo\Main\IndexRequest;

class MainPage extends Page
{
    /**
     * index
     * @param IndexRequest $request
     */
    public function actionIndex(IndexRequest $request)
    {
        $data = new IndexData();
        $data->plus = $request->a + $request->b;
        $data->minus = $request->b - $request->a;
        $data->divide = $request->b / $request->a;
        $data->multiply = $request->a * $request->b;
        $this->response->setData($data);
    }
}
