<?php

namespace App\Modules\Admin\Controllers;

use T4\Core\Config;
use T4\Mvc\Controller;

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
        } else {
            $config = new Config();
        }
        $config->setPath(ROOT_PATH_PROTECTED . '/settings.php');
        $config->merge($this->app->request->post->settings);
        $config->save();
        $this->redirect('/admin/settings');
    }

}