<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $table = 'T_RBAC_ROLEPERMISSION';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = ['ROLEID','PID'];
}
