<?php

return [

    '///Login' => [
        'title' => 'Блок входа на сайт',
        'desc' => 'Форма входа пользователя',
        'options' => [],
    ],

    '///BlockHtml' => [
        'title' => 'Блок с произвольным текстом',
        'desc' => 'Выводит произвольный HTML',
        'options' => [
            'html' => [
                'title' => 'Текст',
                'type' => 'text',
                'default' => '',
            ]
        ]
    ],

    '///LastAlbums' => [
        'title' => 'Блок последних фотоальбомов',
        'desc' => 'Вывод последних фотоальбомов',
        'options' => [],
    ],

    '///Menu' => [
        'title' => 'Блок главного меню',
        'desc' => 'Вывод дерева главного меню',
        'options' => [],
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

    '/News//' => [
        'title' => 'Лента новостей',
        'desc' => 'Выводит последние новости',
        'options' => [
            'count' => [
                'title' => 'Число выводимых новостей',
                'type' => 'int',
                'default' => 10,
            ],
        ],
        'cache' => false,
    ],

    '/News//NewsByTopic' => [
        'title' => 'Лента раздела новостей',
        'desc' => 'Выводит последние новости определенного раздела',
        'options' => [
            'id' => [
                'title' => 'Раздел',
                'type' => 'select:tree',
                'model' => 'App\Modules\News\Models\Topic',
                'default' => 1,
            ],
            'count' => [
                'title' => 'Число выводимых новостей',
                'type' => 'int',
                'default' => 5,
            ],
            'color' => [
                'title' => 'Класс цвета блока',
                'type' => 'select',
                'values' => [
                    'default' => 'default',
                    'primary' => 'primary',
                    'success' => 'success',
                    'warning' => 'warning',
                    'danger' => 'danger',
                    'info' => 'info',
                ],
                'default' => 'default',
            ],
        ],
        'cache' => ['time' => 60],
    ],

];