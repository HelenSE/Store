<?php
    include '../vendor/autoload.php';//подключена автозагрузка

//    print_r($_SERVER['REQUEST_URI']);

    $routes = [
    '/'=>'App\\Controllers\\SiteController@index',
    '/catalog'=>'App\\Controllers\\CatalogController@index',
    '/catalog/12'=>'App\\Controllers\\CatalogController@showProduct'
    ];
    $runAction = 'App\\Controllers\\SiteController@notFound';
    foreach ($routes as $route => $action){
    if ($_SERVER ['REQUEST_URI'] == $route){
        $runAction = $action;
        break;
       }

    }

    $runAction = explode('@', $runAction);
//    print_r($runAction);//0- класс 1- метод
    $controller = new $runAction [0];
    $controller->{$runAction [1]}();//{} имя переменной




