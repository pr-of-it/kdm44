<?php

spl_autoload_register(function ($className) {

    if ('App' == substr($className, 0, 3)) {
        $className = preg_replace('~^App~', '', $className);
        $fileName = ROOT_PATH_PROTECTED . str_replace('\\', DS, $className) . '.php';
    } else {
        return false;
    }

    if (is_readable($fileName)) {
        require $fileName;
        return true;
    } else {
        return false;
    }

});