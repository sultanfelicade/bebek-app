<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'm_categories';
    protected $primaryKey = 'id_category';
    public $timestamps = false;
    protected $guarded = [];
}
