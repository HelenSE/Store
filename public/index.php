<?php
    include '../vendor/autoload.php';//подключена автозагрузка
    include '../app/core.php';//подключение name space

//    print_r($_SERVER['REQUEST_URI']);

    $routes = [
    '/'=>'App\\Controllers\\SiteController@index',
    '/catalog'=>'App\\Controllers\\CatalogController@index',
    '/product'=>'App\\Controllers\\CatalogController@showProduct', //передаем id как get параметр
    '/add_product_form' => 'App\\Controllers\\CatalogController@showForm',
    '/save_product' => 'App\\Controllers\\CatalogController@saveProduct'
    ];
    $runAction = 'App\\Controllers\\SiteController@notFound';
    $uri = explode('?',$_SERVER['REQUEST_URI'] );
    $uri = $uri[0];
    foreach ($routes as $route => $action){
    if ($uri == $route){
        $runAction = $action;
        break;
       }

    }

    $runAction = explode('@', $runAction);
//    print_r($runAction);0- класс 1- метод
    $controller = new $runAction [0];
    $controller->{$runAction [1]}();//{} имя переменной




