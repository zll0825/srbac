<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class RFunction extends Model
{
    protected $table = 'T_RBAC_FUNCTION';
    protected $primaryKey = 'FID';
    public $timestamps = false;
    protected $fillable = ['FUNCTIONNAME','FUNCTIONCODE','FILTERURL','PARENTIDFID'];
}
