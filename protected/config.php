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
        ],
        'fileupload' => [

        ],
        'ckeditor' => [
            'location' => 'local',
        ],

    ],
];