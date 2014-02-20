<?php


namespace App\Modules\Admin\Controllers;

use T4\Mvc\Controller;

class Index
    extends Controller
{

    public function actionDefault()
    {
    }

    public function actionBlocks()
    {
        $this->data->sections = $this->app->config->sections;
        $this->data->blocksAvaliable = $this->app->config->blocks;
    }

}