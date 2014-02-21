<?php

return [
    '//Pages/pageText' => [
        'title' => 'Блок с текстом выбранной страницы',
        'desc' => 'Выводит текст выбранной страницы',
        'options' => [
            'id' => [
                'title' => 'Страница',
                'type' => 'select:tree',
                'model' => 'Page',
                'default' => 1,
            ]
        ]
    ]
];