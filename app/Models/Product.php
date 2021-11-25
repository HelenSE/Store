<?php

namespace App\Models;

    class Product extends BaseModel
{
    protected static $tableName = 'product';
    protected static $fillable = ['name', 'description', 'img'];
}