<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroupUser extends Model
{
    protected $table = 'T_RBAC_USERGROUPUSER';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = ['UID','UGID'];
}
