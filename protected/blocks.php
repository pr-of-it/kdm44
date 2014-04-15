<?php

return [

    '///Login' => [
        'name' => 'Блок входа на сайт'
    ],

    '/Pages//PageText' => [
        'title' => 'Блок с текстом выбранной страницы',
        'desc' => 'Выводит текст выбранной страницы',
        'options' => [
            'id' => [
                'title' => 'Страница',
                'type' => 'select:tree',
                'model' => 'App\Modules\Pages\Models\Page',
                'default' => 1,
            ]
        ]
    ],
    '/Pages//Page' => [
        'title' => 'Блок выбранной страницы',
        'desc' => 'Выводит выбранную страницу в заданном шаблоне',
        'options' => [
            'id' => [
                'title' => 'Страница',
                'type' => 'select:tree',
                'model' => 'App\Modules\Pages\Models\Page',
                'default' => 1,
            ]
        ]
    ],
    '/Pages//Tree' => [
        'title' => 'Блок дерева страницы',
        'desc' => 'Выводит полное дерево страниц',
        'options' => [
        ]
    ],
    '/Pages//SubTree' => [
        'title' => 'Блок поддерева страницы',
        'desc' => 'Выводит поддерево страниц, начиная с заданной страницы',
        'options' => [
            'id' => [
                'title' => 'Страница',
                'type' => 'select:tree',
                'model' => 'App\Modules\Pages\Models\Page',
                'default' => 1,
            ]
        ]
    ],
];