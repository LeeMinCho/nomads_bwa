<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAdmin extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'name', 'username', 'email', 'password', 'roles_id', 'email_verified_at'
    ];

    protected $hidden = [
        'password', 'remember_token', 'username'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'roles_id', 'id');
    }
}
