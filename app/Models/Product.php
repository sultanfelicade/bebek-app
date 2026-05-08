<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'm_products';
    protected $primaryKey = 'id_product';
    public $timestamps = false;
    protected $guarded = [];
}