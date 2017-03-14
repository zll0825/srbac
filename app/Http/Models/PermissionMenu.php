<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionMenu extends Model
{
    protected $table = 'T_RBAC_PERMISSIONMENU';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = ['PID','MID'];
}
