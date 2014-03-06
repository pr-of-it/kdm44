<?php

return [
    '//Pages/pageText' => [
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
    '//Pages/page' => [
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
];