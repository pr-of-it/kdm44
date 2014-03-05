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
        $installed = Block::findAll(['order'=>'`order`']);
        $this->data->blocksInstalled = [];
        foreach ($installed as &$block) {
            $block->title = $this->app->config->blocks->{$block->path}->title;
            $block->desc = $this->app->config->blocks->{$block->path}->desc;
            $this->data->blocksInstalled[$block->section][] = $block;
        }
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
        $block->options = json_encode($params);
        $block->order = 0;

        if (false !== $block->save()) {
            $this->data->id = $block->getPK();
            $this->data->result = true;
        } else {
            $this->data->result = false;
        }
    }

    public function actionSortBlocks($ids)
    {
        $order = 1;
        foreach ($ids as $id) {
            $block = Block::findByPK($id);
            $block->order = $order*10;
            if (!$block->save()) {
                $this->data->result = false;
                return;
            };
            $order++;
        }
        $this->data->result = true;
    }

}