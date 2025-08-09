<?php

namespace App\Livewire;

use App\Traits\HasMenus;
use Livewire\Component;
use App\Models\Role;
use Illuminate\Support\Str;

class RoleManagement extends Component
{

    use HasMenus;

    public $roles = [];
    public $menus = [];
    public $role_id;
    public $name;
    public $selectedMenus = [];
    public $permissions = [];
    public $editMode = false;
    // Permission flags for this component based on 'roles' route
    public $canView = false;
    public $canCreate = false;
    public $canEdit = false;
    public $canDelete = false;

    public $permissionTypes = ['can_view', 'can_create', 'can_edit', 'can_delete'];

    public function mount()
    {
        $this->roles = Role::with('menus')->get();
        $this->menus = \App\Models\Menu::orderBy('order')->get();
        // set permission flags from role menus for route 'roles'
        $perms = $this->getMenuPermissionsByRoute('roles');
        $this->canView = (bool)($perms['can_view'] ?? false);
        $this->canCreate = (bool)($perms['can_create'] ?? false);
        $this->canEdit = (bool)($perms['can_edit'] ?? false);
        $this->canDelete = (bool)($perms['can_delete'] ?? false);
        if (!$this->canView) {
            abort(403);
        }
    }

    public function startAdd()
    {
    if (!$this->canCreate) abort(403);
        // Reset semua field form dan mode edit
        $this->reset(['role_id', 'name', 'selectedMenus', 'permissions', 'editMode']);
        $this->editMode = false;
    }

    public function startEdit($id)
    {
    if (!$this->canEdit) abort(403);
        $role = Role::with('menus')->findOrFail($id);
        $this->role_id = $role->id;
        $this->name = $role->name;
        $this->selectedMenus = $role->menus->pluck('id')->toArray();
        $this->permissions = [];
        foreach ($role->menus as $menu) {
            foreach ($this->permissionTypes as $perm) {
                $this->permissions[$menu->id][$perm] = (bool)($menu->pivot->{$perm} ?? false);
            }
        }
        $this->editMode = true;
    }

    public function saveRole()
    {
        $this->validate([
            'name' => 'required',
        ]);
    // Gate by action
    if ($this->editMode && !$this->canEdit) abort(403);
    if (!$this->editMode && !$this->canCreate) abort(403);
        // Set is_super_user true only for Super User
        $isSuperUser = strtolower(trim($this->name)) === 'super user';
        $roleData = [
            'name' => $this->name,
            'is_super_user' => $isSuperUser,
        ];
        if ($this->editMode) {
            $role = Role::findOrFail($this->role_id);
            $role->update($roleData);
        } else {
            $role = Role::create(array_merge([
                'id' => Str::uuid(),
            ], $roleData));
        }
        // Sync menus and permissions
        $syncData = [];
        foreach ($this->selectedMenus as $menuId) {
            $syncData[$menuId] = [];
            foreach ($this->permissionTypes as $perm) {
                $syncData[$menuId][$perm] = !empty($this->permissions[$menuId][$perm]);
            }
        }
        $role->menus()->sync($syncData);
        $this->mount();
        $this->reset(['role_id', 'name', 'selectedMenus', 'permissions', 'editMode']);
    }

    public function deleteRole($id)
    {
    if (!$this->canDelete) abort(403);
        $role = Role::findOrFail($id);
        $role->delete();
        $this->mount();
    }

    public function render()
    {
        return view('livewire.role-management', [
            'roles' => $this->roles,
            'menus' => $this->menus,
            'permissionTypes' => $this->permissionTypes,
            'canView' => $this->canView,
            'canCreate' => $this->canCreate,
            'canEdit' => $this->canEdit,
            'canDelete' => $this->canDelete,
        ])->layout('layouts.app', [
            'menus' => $this->menus,
        ]);
    }
}
