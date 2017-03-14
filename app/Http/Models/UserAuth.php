<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class UserAuth extends Model
{
    protected $table = 'T_RBAC_USERAUTH';
    protected $primaryKey = 'ID';
}
