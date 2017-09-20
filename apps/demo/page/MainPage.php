<?php

class MainPage extends \FFan\Dop\Uis\Page
{
    public function actionIndex()
    {
        $this->response->appendData('data', time());
    }
}