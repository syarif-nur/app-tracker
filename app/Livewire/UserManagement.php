<?php

namespace App\Livewire;

use Livewire\Component;
use App\Traits\HasMenus;

class UserManagement extends Component{
    use HasMenus;
    public $users = [];
    public $name;
    public $email;
    public $password;
    public $role_id;
    public $departemen_id;
    public $roles = [];
    public $departemens = [];
    public $menus = [];

    // For edit modal
    public $editId = null;
    public $editMode = false;

    public function mount()
    {
        $this->users = \App\Models\User::with(['role', 'departemen'])->get();
        $this->roles = \App\Models\Role::all();
        $this->departemens = \DB::table('departemen')->get();
        $this->menus = $this->getMenus();
    }

    public function createUser()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:roles,id',
            'departemen_id' => 'nullable|exists:departemen,id',
        ]);

        \App\Models\User::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'role_id' => $this->role_id,
            'departemen_id' => $this->departemen_id,
        ]);

        $this->reset(['name', 'email', 'password', 'role_id', 'departemen_id']);
        $this->users = \App\Models\User::with(['role', 'departemen'])->get();
        $this->dispatch('user-added');
    }

    public function startEdit($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $this->editId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role_id = $user->role_id;
        $this->departemen_id = $user->departemen_id;
        $this->editMode = true;
    }

    public function updateUser()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->editId,
            'role_id' => 'required|exists:roles,id',
            'departemen_id' => 'nullable|exists:departemen,id',
        ];
        // Only require password if set
        if ($this->password) {
            $rules['password'] = 'min:6';
        }
        $this->validate($rules);

        $user = \App\Models\User::findOrFail($this->editId);
        $updateData = [
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id,
            'departemen_id' => $this->departemen_id,
        ];
        if ($this->password) {
            $updateData['password'] = bcrypt($this->password);
        }
        $user->update($updateData);

        $this->reset(['name', 'email', 'password', 'role_id', 'departemen_id', 'editId', 'editMode']);
        $this->users = \App\Models\User::with(['role', 'departemen'])->get();
        $this->dispatch('user-edited');
    }

    public function deleteUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        $this->users = \App\Models\User::with(['role', 'departemen'])->get();
        $this->dispatch('user-deleted');
    }

    public function render()
    {
        return view('livewire.user-management', [
            'users' => $this->users,
            'roles' => $this->roles,
            'departemens' => $this->departemens,
            'menus' => $this->menus,
        ])->layout('layouts.app', [
            'menus' => $this->menus,
        ]);
    }
}
