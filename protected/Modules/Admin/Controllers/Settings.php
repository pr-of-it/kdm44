<?php

namespace App\Modules\Admin\Controllers;

use T4\Core\Config;
use T4\Core\Std;
use T4\Mvc\Controller;
use T4\Http\Uploader;
use T4\Core\Collection;

class Settings
    extends Controller
{

    public function actionDefault()
    {
        if (!empty($this->app->config->settings)) {
            $this->data->items = $this->app->config->settings;
        } else {
            $this->data->items = new Config();
        }
    }

    public function actionSave()
    {
        if (!empty($this->app->config->settings)) {
            $config = $this->app->config->settings;
        }
        else {
            $config = new Config();
        }

        $config->setPath(ROOT_PATH_PROTECTED . '/settings.php');
        $config->merge($this->app->request->post->settings);
        if (isset($this->app->request->post->slider)) {
            $config->slider = new Config($this->app->request->post->slider->toArray());
        }
        else {
            $config->slider = new Config();
        }
        if ($this->app->request->existsFilesData() || $this->app->request->isUploadedArray('files')) {
            $uploader = new Uploader('files');
            $uploader->setPath('/public/settings/slider');
            foreach ($uploader() as $uploadedFilePath) {
                if (false !== $uploadedFilePath)
                    $config->slider[] = new Config(['src' => $uploadedFilePath, 'link' => '']);
            }
        }
        $reindexingSlides = array_values($config->slider->toArray());
        $config->fromArray(['slider' =>$reindexingSlides]);
        $config->save();
        $this->redirect('/admin/settings');
    }

}