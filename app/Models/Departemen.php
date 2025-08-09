<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    protected $table = 'departemen';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id', 'name',
    ];
}
