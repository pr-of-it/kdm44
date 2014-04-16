<?php

return [

    '///Login' => [
        'title' => 'Блок входа на сайт',
        'desc' => 'Форма входа пользователя'
    ],

    /*
     * Pages
     */

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

    /*
     * News
     */

    '/News//NewsByTopic' => [
        'title' => 'Лента раздела новостей',
        'desc' => 'Выводит последние новости определенного раздела',
        'options' => [
            'id' => [
                'title' => 'Раздел',
                'type' => 'select:tree',
                'model' => 'App\Modules\News\Models\NewsTopic',
                'default' => 1,
            ],
            'count' => [
                'title' => 'Число выводимых новостей',
                'type' => 'int',
                'default' => 5,
            ],
        ]
    ]

];