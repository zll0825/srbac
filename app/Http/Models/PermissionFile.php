<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionFile extends Model
{
    protected $table = 'T_RBAC_PERMISSIONFILE';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = ['PID','FID'];
}
