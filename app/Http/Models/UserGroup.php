<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $table = 'T_RBAC_USERGROUP';
    protected $primaryKey = 'UGID';
    public $timestamps = false;
    protected $fillable = ['GROUPNAME','PARENTUGID'];

    /**
     * 用户组用户
     */
    public function users()
    {
        return $this->belongsToMany('App\Http\Models\User','T_RBAC_USERGROUPUSER','UID','UGID');
    }

    /**
     * 用户组角色
     */
    public function roles()
    {
        return $this->belongsToMany('App\Http\Models\Role','T_RBAC_USERGROUPROLE','UGID','ROLEID');
    }

    public function parentUseGroups()
	{
	    return $this->belongsToMany($this, 'T_RBAC_USERGROUP', 'UGID', 'PARENTUGID');
	}

	public function childrenUseGroups()
	{
	    return $this->belongsToMany($this, 'T_RBAC_USERGROUP', 'PARENTUGID', 'UGID');
	}
}
