<?php

namespace App\Controllers;

class CatalogController
{
    public function index(){
        include __DIR__ . '/../../views/store.php';
    }
    public function showProduct(){
        include __DIR__.'/../../views/product.php';
    }

}