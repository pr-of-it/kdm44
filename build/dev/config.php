<?php

return [

    'settings' => include(__DIR__ . '/settings.php'),

    'db' => [
        'default' => [
            'driver' => 'mysql',
            'host' => 'mysql',
            'dbname' => 'kdm44',
            'user' => 'kdm44',
            'password' => 'kdm44',
        ]
    ],
    'auth' => [
        'expire' => 31536000 // 1 year
    ],
    'mail' => [
        'method' => 'smtp',
        'host' => 'smtp.yandex.ru',
        'port' => 465,
        'secure' => 'ssl',
        'auth' => [
            'username' => 'forms@kdm44.ru',
            'password' => 'JSK1ji4xFRz'
        ],
    ],
    'extensions' => [
        'jquery' => [
            'ui' => true,
        ],
        'jstree' => [
            'autoload' => false,
        ],
        'bootstrap' => [
            'location' => 'local',
            'theme' => 'cosmo',
        ],
        'fileupload' => [
            'autoload' => false,
        ],
        'ckeditor' => [
            'location' => 'local',
            'autoload' => false,
        ],
        'ckfinder' => [
            'autoload' => false,
        ],
        'fotorama'=>[
            'autoload' => true,
        ]
    ],
    'errors' => [
        404 => '//Index/404',
    ],
];
