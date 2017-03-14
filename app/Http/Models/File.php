<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'T_RBAC_FILE';
    protected $primaryKey = 'FID';
    public $timestamps = false;
    protected $fillable = ['FILENAME','FILEPATH'];
}
