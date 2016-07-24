<?php

namespace App\Modules\News\Controllers;

use App\Modules\News\Models\Story;
use T4\Mvc\Controller;

class Archive
    extends Controller
{
    public function actionDefault()
    {
        $this->data->items = Story::getYears();
    }
    
}