<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'name', 'route', 'icon', 'order'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_menu')
            ->withPivot('can_view', 'can_edit', 'can_delete', 'can_create')
            ->withTimestamps();
    }
}
