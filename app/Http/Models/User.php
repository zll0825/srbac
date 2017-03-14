<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'T_RBAC_USER';
    protected $primaryKey = 'UID';
    public $timestamps = false;
    protected $fillable = ['AVATAR','NICKNAME','REGTIME','LOGINIP'];

    /**
     * 用户角色
     */
    public function roles()
    {
        return $this->belongsToMany('App\Http\Models\Role','T_RBAC_USERROLE','UID','ROLEID');
    }

    /**
     * 用户用户组
     */
    public function userGroups()
    {
        return $this->belongsToMany('App\Http\Models\UserGroup','T_RBAC_USERGROUPUSER','UID','UGID');
    }
}
