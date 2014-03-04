<?php

namespace App\Modules\Admin\Controllers;

use App\Models\Block;
use T4\Mvc\Controller;

class Blocks
    extends Controller
{

    public function actionDefault()
    {
        $this->data->sections = $this->app->config->sections;
        $this->data->blocksAvailable = $this->app->config->blocks;
        $this->data->blocksInstalled = Block::findAll();
    }

    public function actionSetupBlock($sectionId, $blockPath)
    {
        $block = new Block();
        $block->section = $sectionId;
        $block->path = $blockPath;

        $params = [];
        foreach ($this->app->config->blocks->{$blockPath}->options as $optionName => $options) {
            $params[$optionName] = $options->default;
        }
        $block->params = json_encode($params);
        $block->order = 0;

        if (false !== $block->save()) {
            $this->data->id = $block->getPK();
            $this->data->result = true;
        } else {
            $this->data->result = false;
        }
    }

}