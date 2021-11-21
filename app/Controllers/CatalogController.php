<?php

namespace App\Controllers;

use App\Models\Product;

class CatalogController
{
    public function index()
    {
        render('store.php');
    }

    public function showProduct()
    {
        $id = $_GET['id'];
        $allProducts = Product::selectAll();
        $product = Product::findById($id);
        render('product.php', [
            'product' => $product,
            'productsList' => $allProducts
        ]);
    }

    public function showForm()
    {
        render('addProductForm.php');
    }

    public function saveProduct()
    {
        $total = count($_FILES['img']['name']);
        for ($i = 0; $i < $total; $i++) {
            $maxFileSize = 1048576;
            $fileName = $_FILES['img']['name'][$i];
            $path = $_SERVER['DOCUMENT_ROOT'] . '/download/' . $fileName;
            $type = explode('/', $_FILES['img']['type'][$i]);
            


            if ($_FILES['fileUpload']['size'][$i] > $maxFileSize) {
                print_r('File' . $fileName . 'size is greater than allowed size<br>');
            } else {
                if ($type[0] !== 'image') {
                    print_r('File' . $fileName . ' type is not invalid, download stopped <br>');
                } else {
                    while (file_exists($path)) {
                        $path = $_SERVER['DOCUMENT_ROOT'] . '/download/' . self::newNameFile($fileName);
                    }
                    move_uploaded_file($_FILES['img']['tmp_name'][$i], $path);
                }
            }
        }
    }

    public function newNameFile($path, $extension = '')
    {
        $extension = $extension ? '.' . $extension : '';//проверка существования файла
        $path = $path ? $path . '/' : '';

        do {
            $fileName = md5(microtime() . rand(0, 9999));//генерирует новое имя
            $file = $path . $fileName . $extension;
        } while (file_exists($file));

        return $fileName;
    }
}


