<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    protected $table = 'T_RBAC_ELEMENT';
    protected $primaryKey = 'EID';
    public $timestamps = false;
    protected $fillable = ['ELEMENTCODE'];

}
