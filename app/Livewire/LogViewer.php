<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogViewer extends Component
{
    public $logs = [];
    public $menus = [];

    public function mount()
    {
        $user = Auth::user();
        // Hanya super admin yang boleh akses
        if (!$user || !$user->role || !$user->role->is_super_user) {
            abort(403);
        }
        $this->logs = Log::with('user')->latest()->limit(200)->get();
        $this->menus = $this->getMenus();
    }

    use \App\Traits\HasMenus;

    public function render()
    {
        return view('livewire.log-viewer', [
            'logs' => $this->logs,
        ])->layout('layouts.app', [
            'menus' => $this->menus,
        ]);
    }
}
