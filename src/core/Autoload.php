<?php

namespace core;

class Autoload
{
    public static function registrate(string $rootPath)
    {
        $autoloadController = function (string $controllerName) use ($rootPath)
        {
            $path = $rootPath . str_replace('\\' , '/' , $controllerName) . '.php';

            if(file_exists($path))
            {
                require_once $path;
                return true;
            }
            return false;
        };

        spl_autoload_register($autoloadController);
    }
}