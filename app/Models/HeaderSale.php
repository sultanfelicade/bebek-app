<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeaderSale extends Model
{
    protected $table = 't_sales';
    protected $primaryKey = 'id_sales';
    protected $keyType = 'string'; 
    public $incrementing = false; 
    public $timestamps = false;
    protected $guarded = [];
}