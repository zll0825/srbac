<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionElement extends Model
{
    protected $table = 'T_RBAC_PERMISSIONELEMENT';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = ['PID','EID'];
}
