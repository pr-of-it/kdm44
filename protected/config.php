<?php

return [
    'db' => [
        'default' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'dbname' => 'kdm',
            'user' => 'root',
            'password' => '',
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
        'bootstrap' => [
            'location' => 'local',
            'theme' => [
                'css' => '/Layouts/Main/assets/css/cosmo/bootstrap.min.css',
            ],
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
];