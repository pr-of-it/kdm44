<?php


namespace App\Modules\Admin\Controllers;

use T4\Mvc\Controller;
use App\Models\Block;

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
        $this->data->blocksInstalled = Block::findAll();
    }

}