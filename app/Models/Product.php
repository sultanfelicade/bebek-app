<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesSmartKey;

class Product extends Model
{
    use UsesSmartKey;

    public $keyPrefix = 'PRD';
    protected $table = 'm_products';
    protected $primaryKey = 'id_product';
    public $timestamps = false;
    protected $guarded = [];
}