<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'T_RBAC_ROLE';
    protected $primaryKey = 'ROLEID';
    public $timestamps = false;
    protected $fillable = ['ROLENAME'];

    /**
     * 角色用户
     */
    public function users()
    {
        return $this->belongsToMany('App\Http\Models\User','T_RBAC_USERROLE','UID','ROLEID');
    }

    /**
     * 角色用户组
     */
    public function usergroups()
    {
        return $this->belongsToMany('App\Http\Models\UserGroup','T_RBAC_USERGROUPROLE','UGID','ROLEID');
    }

    /**
     * 角色权限
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Http\Models\Permission','T_RBAC_ROLEPERMISSION','ROLEID','PID');
    }
}
