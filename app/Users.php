<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
	public function getPermissions() {
        return $this->hasMany('App\Permissons', 'role_Id');
    }
}
