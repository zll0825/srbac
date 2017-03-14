<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'T_RBAC_MENU';
    protected $primaryKey = 'MID';
    public $timestamps = false;
    protected $fillable = ['MENUNAME','MENUCODE','MENUURL','PARENTMID'];
}
