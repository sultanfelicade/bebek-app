<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;


    protected $table = 'm_users';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    // Memperbolehkan semua kolom di tabel m_users diisi (id_branch, username, role)
    protected $guarded = [];
}