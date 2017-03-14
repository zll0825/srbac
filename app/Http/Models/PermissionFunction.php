<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionFunction extends Model
{
    protected $table = 'T_RBAC_PERMISSIONFUNCTION';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = ['PID','FID'];
}
