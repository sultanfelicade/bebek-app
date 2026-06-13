<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesSmartKey;

class Category extends Model
{
    use UsesSmartKey;

    public $keyPrefix = 'CAT';
    protected $table = 'm_categories';
    protected $primaryKey = 'id_category';
    public $timestamps = false;
    protected $guarded = [];
}
