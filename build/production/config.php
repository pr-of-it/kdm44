<?php

return [

    'settings' => include(__DIR__ . '/settings.php'),

    'db' => [
        'default' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'dbname' => 'kdm',
            'user' => 'kdm',
            'password' => '123456',
        ]
    ],
    'auth' => [
        'expire' => 31536000 // 1 year
    ],
    'mail' => [
        'method' => 'php',
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
    ],
    'errors' => [
        404 => '//Index/404',
    ],
];