<?php

namespace App\Modules\Admin\Controllers;

use App\Modules\Documents\Models\Category;
use T4\Mvc\Controller;

class Documents
    extends Controller
{

    protected $access = [
        'Default' => ['role.name'=>'admin'],
        'Edit' => ['role.name'=>'admin'],
        'Save' => ['role.name'=>'admin'],
        'Delete' => ['role.name'=>'admin'],

        'Categories' => ['role.name'=>'admin'],
    ];

    public function actionCategories()
    {
        $this->data->items = Category::findAllTree();
    }

    public function actionEditCategory($id=null)
    {
        if (null === $id || 'new' == $id) {
            $this->data->item = new Category();
        } else {
            $this->data->item = Category::findByPK($id);
        }
    }

    public function actionSaveCategory()
    {
        if (!empty($_POST[Category::PK])) {
            $item = Category::findByPK($_POST[Category::PK]);
        } else {
            $item = new Category();
        }
        $item->fill($_POST);
        $item->save();
        $this->redirect('/admin/documents/categories/');
    }

    public function actionDeleteCategory($id)
    {
        $item = Category::findByPK($id);
        if ($item) {
            $item->delete();
        }
        $this->redirect('/admin/documents/categories/');
    }


}