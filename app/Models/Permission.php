<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role','permissions_roles','role_id','permission_id');
    }
}
