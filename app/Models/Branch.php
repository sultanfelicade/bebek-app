<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UsesSmartKey;

class Branch extends Model
{
    use UsesSmartKey;

    public $keyPrefix = 'BRC';
    protected $table = 'm_branches';
    protected $primaryKey = 'id_branch';
    public $timestamps = false;
    protected $guarded = [];
}