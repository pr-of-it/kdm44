<?php

return [

    '/index' => '///',

    '/reception/recourse/processing' => '//App\Controllers\Reception\Recourse\Processing/Default',
    '/reception/recourse/processing/edit/<1>' => '//App\Controllers\Reception\Recourse\Processing/Edit(id=<1>)',
    '/reception/recourse/<1>' => '//App\Controllers\Reception\Recourse\Send/Default(url=<1>)',

    '/news/archive' => '/News/Archive/Default',
    '/news/archive/<1>/<2>/<3>' => '/News/Archive/NewsByDay(year=<1>,month=<2>,topic=<3>)',
    '/news/archive/<1>/<2>' => '/News/Archive/NewsByTopic(year=<1>,month=<2>)',
    '/news/archive/<1>' => '/News/Archive/NewsByMonth(year=<1>)',

    '/news/topics/<1>' => '/News/Index/NewsByTopic(id=<1>)',
    '/news/<1>' => '/News/Index/Story(id=<1>)',

    '/pages/<3>/<2>/<1>' => '/Pages/Index/PageByUrl(url=<1>)',
    '/pages/<2>/<1>' => '/Pages/Index/PageByUrl(url=<1>)',
    '/pages/<1>' => '/Pages/Index/PageByUrl(url=<1>)',

    '/gallery/albums/<1>' => '/Gallery/Index/AlbumByUrl(url=<1>)',

];
