<?php


use core\app;

//$autholoadController = function (string $controllerName)
//{
//    $path =  "./../Controller/$controllerName.php";
//    if(file_exists($path))
//    {
//        require_once $path;
//        return true;
//    }
//    return false;
//};
//
//$autholoadModel = function (string $modelName)
//{
//    $path = "./../Model/$modelName.php";
//    if(file_exists($path))
//    {
//        require_once $path;
//        return true;
//    }
//    return false;
//};

//spl_autoload_register($autholoadController);
//spl_autoload_register($autholoadModel);

$autholoadController = function (string $controllerName)
{
   $path = './../' . str_replace('\\' , '/' , $controllerName) . '.php';

   if(file_exists($path))
   {
       require_once $path;
       return true;
   }
   return false;
};

spl_autoload_register($autholoadController);
$app = new App();
$app->run();