<?php

namespace App\Models;

use Laratrust\Models\Role as RoleModel;

class Role extends RoleModel
{
    public $guarded = [];

    protected $hidden = ['created_at','updated_at'];

    public function users()
    {
      return $this->belongsToMany('App\User');
    }
    
}
