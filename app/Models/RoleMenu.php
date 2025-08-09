<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleMenu extends Model
{
    use HasFactory;

    protected $table = 'role_menu';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'role_id', 'menu_id', 'can_view', 'can_edit', 'can_delete', 'can_create'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
