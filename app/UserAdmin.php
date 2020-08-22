<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAdmin extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'name', 'username', 'email', 'password', 'roles_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'roles_id', 'id');
    }
}
