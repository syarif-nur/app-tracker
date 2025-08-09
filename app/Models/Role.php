<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'role_menu')
            ->withPivot('can_view', 'can_edit', 'can_delete', 'can_create')
            ->withTimestamps();
    }
    use HasFactory;

    protected $table = 'roles';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'is_super_user',
        'can_view',
        'can_edit',
        'can_delete',
        'can_create',
    ];
}
