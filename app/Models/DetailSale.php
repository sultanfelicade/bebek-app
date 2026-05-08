<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailSale extends Model
{
    protected $table = 't_sales_details';
    protected $primaryKey = 'id_detail';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];
}