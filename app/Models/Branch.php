<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'm_branches';
    protected $primaryKey = 'id_branch';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];
}