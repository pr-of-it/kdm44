<?php

namespace App\Modules\Pages\Controllers;

use App\Modules\Pages\Models\Page;
use T4\Mvc\Controller;

class Admin
    extends Controller
{

    public function actionDefault()
    {
        $this->data->pages = Page::findAllTree();
    }

} 