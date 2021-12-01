<?php

namespace App\Controllers;

use App\Models\BaseModel;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;


class SiteController
{
    public function index(){
        $product = new Product();
        $product->id = 3;
        $product->name = 'laptop';
        $product->description = '156';
        $product->save();

        Product::findById('1');
        render('main.php');
    }
    public function notFound(){
        render('404f.php');
    }
}