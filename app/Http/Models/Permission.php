<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'T_RBAC_PERMISSION';
    protected $primaryKey = 'PID';
    public $timestamps = false;
    protected $fillable = ['PERMISSIONTYPE','APPLICATION'];

    /**
     * 权限角色
     */
    public function roles()
    {
        return $this->belongsToMany('App\Http\Models\Role','T_RBAC_ROLEPERMISSION','PID','ROLEID');
    }
}
