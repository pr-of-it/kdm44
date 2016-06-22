<?php

namespace App\Modules\Admin\Controllers;

use App\Modules\Gallery\Models\Album;
use App\Modules\Gallery\Models\Photo;
use T4\Core\Exception;
use T4\Html\Form\Errors;
use T4\Http\Uploader;
use T4\Mvc\Controller;

class Gallery
    extends Controller
{

    const PAGE_SIZE = 20;

    protected function access($action,  $params = [])
    {
        return !empty($this->app->user) && $this->app->user->hasRole('admin');
    }

    /**
     * Albums
     */

    public function actionDefault()
    {
        $this->data->items = Album::findAllTree();
    }


    public function actionAlbumEdit($id = null, $parent = null)
    {
        if (isset($this->app->flash->item)) {
            $this->data->item = $this->app->flash->item;
        } elseif (null === $id || 'new' == $id) {
            $this->data->item = new Album();
            if (null !== $parent) {
                $this->data->item->parent = $parent;
            }
        } else {
            $this->data->item = Album::findByPK($id);
        }
        if (isset($this->app->flash->errors)) {
            $this->data->errors = $this->app->flash->errors;
        }
    }

    public function actionAlbumEditContent($id = null, $page = 1)
    {
        $album = Album::findByPK($id);

        if (isset($this->app->flash->item)) {
            $this->data->item = $this->app->flash->item;
        } elseif ($id == null) {
            $id = $this->app->request->post->parent;
        }
        $this->data->item = $album;
        $this->data->url = $this->app->request->getPath() . '/?page=%d&id=' . $id;
        $this->data->itemsCount = count(Album::findByPK($id)->photos->collect('__id'));
        $this->data->pageSize = self::PAGE_SIZE;
        $this->data->activePage = $page;
        $this->data->photos = Photo::findAllByColumn('__album_id', $id, [
            'order' => 'published DESC',
            'offset' => ($page - 1) * self::PAGE_SIZE,
            'limit' => self::PAGE_SIZE
        ]);
        if (isset($this->app->flash->errors)) {
            $this->data->errors = $this->app->flash->errors;
        }
    }

    public function actionAlbumSave($redirect = 0)
    {
        $id = $this->app->request->post->id;
        if (!empty($id)) {
            $item = Album::findByPK($id);
        } else {
            $item = new Album();
        }
        try {
            $item->fill($this->app->request->post);
            $item->save();
            if ($item->wasNew()) {
                $item->moveToFirstPosition();
            }

        } catch (Errors $errors) {
            $this->app->flash->item = $item;
            $this->app->flash->errors = $errors;
            if (!empty($id)) {
                $this->redirect('/admin/gallery/albumEditContent?id=' . $id);
            } else
                $this->redirect('/admin/gallery/albumEdit');
        }

        if ($redirect) {
            $this->redirect('/gallery/albums/' . $item->url . '.html');
        }
        $this->redirect('/admin/gallery/');
    }

    public function actionAlbumDelete($id)
    {
        $item = Album::findByPK($id);
        if ($item) {
            $item->delete();
        }
        $this->redirect('/admin/gallery/');
    }

    public function actionAlbumUp($id)
    {
        $item = Album::findByPK($id);
        if (empty($item))
            $this->redirect('/admin/gallery/');
        $sibling = $item->getPrevSibling();
        if (!empty($sibling)) {
            $item->insertBefore($sibling);
        }
        $this->redirect('/admin/gallery/');
    }

    public function actionAlbumDown($id)
    {
        $item = Album::findByPK($id);
        if (empty($item))
            $this->redirect('/admin/gallery/');
        $sibling = $item->getNextSibling();
        if (!empty($sibling)) {
            $item->insertAfter($sibling);
        }
        $this->redirect('/admin/gallery/');
    }

    public function actionAlbumMoveBefore($id, $to)
    {
        try {
            $item = Album::findByPK($id);
            if (empty($item)) {
                throw new Exception('Source element does not exist');
            }
            $destination = Album::findByPK($to);
            if (empty($destination)) {
                throw new Exception('Destination element does not exist');
            }
            $item->insertBefore($destination);
            $this->data->result = true;
        } catch (Exception $e) {
            $this->data->result = false;
            $this->data->error = $e->getMessage();
        }
    }

    public function actionAlbumMoveAfter($id, $to)
    {
        try {
            $item = Album::findByPK($id);
            if (empty($item)) {
                throw new Exception('Source element does not exist');
            }
            $destination = Album::findByPK($to);
            if (empty($destination)) {
                throw new Exception('Destination element does not exist');
            }
            $item->insertAfter($destination);
            $this->data->result = true;
        } catch (Exception $e) {
            $this->data->result = false;
            $this->data->error = $e->getMessage();
        }
    }

    /**
     * Photos
     */


    public function actionView($id)
    {
        $this->data->item = Photo::findByPK($id);
    }


    public function actionEdit($__album_id = null, $id = null)
    {
        $this->data->id = $id;
        if (!null == $id) {
            $this->data->item = Photo::findByPK($id);
        } else {
            $uploader = new Uploader('image');
            $uploader->setPath('/public/gallery/photos');
            $images = $uploader();
            $this->data->items = $images;
        }
        if (null == $__album_id) {
            $__album_id = $this->app->request->post->__album_id;
        }
        $album = $this->data->album = Album::findByColumn('__id', $__album_id);
        if ($album->__prt) {
            $this->data->albumParent = Album::findByColumn('__id', $album->__prt);
        }
    }

    public function actionSave()
    {
        $__album_id = $this->app->request->post->__album_id;
        if (!$this->app->request->post->id == null) {
            $item = Photo::findByPK($this->app->request->post->id);
            $item->fill($this->app->request->post);
            $item->save();
        } else {
            foreach ($this->app->request->post->image as $image) {
                static $num = 0;
                $item = new Photo;
                $item->title = $this->app->request->post->title[$num];
                $item->image = $image;
                $item->__album_id = $this->app->request->post->__album_id;
                $item->save();
                $num++;
            }
        }
        $this->redirect('/admin/gallery/albumEditContent?id=' . $__album_id);
    }


    public function actionDelete($__album_id = null, $id)
    {
        $item = Photo::findByPK($id);
        $item->delete();
        if (null == $__album_id) {
            $this->redirect('/admin/gallery/');
        }
        $this->redirect('/admin/gallery/albumEditContent?id=' . $__album_id);
    }


}