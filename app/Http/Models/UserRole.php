<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'T_RBAC_USERROLE';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = ['UID','ROLEID'];
}
