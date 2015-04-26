<?php

return [

    '/index' => '///',

    '/news/archive/topic/<1>/<2>/<3>' => '/News/Index/ArchiveMonthByTopic(year=<1>,month=<2>,id=<3>)',
    '/news/archive/<1>/<2>' => '/News/Index/ArchiveByMonth(year=<1>,month=<2>)',
    '/news/topics/<1>' => '/News/Index/NewsByTopic(id=<1>)',
    '/news/archive/<1>' => '/News/Index/Archive(year=<1>)',
    '/news/archives/<1>' => '/News/Index/Archives(id=<1>)',
//    '/news/topics/<1>' => '/News/Index/NewsByTopic(id=<1>)',
    '/news/<1>' => '/News/Index/Story(id=<1>)',

    '/pages/<3>/<2>/<1>' => '/Pages/Index/PageByUrl(url=<1>)',
    '/pages/<2>/<1>' => '/Pages/Index/PageByUrl(url=<1>)',
    '/pages/<1>' => '/Pages/Index/PageByUrl(url=<1>)',

    '/gallery/albums/<1>' => '/Gallery/Index/AlbumByUrl(url=<1>)',

];