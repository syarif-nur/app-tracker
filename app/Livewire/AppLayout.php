<?php

namespace App\Livewire;

use App\Traits\HasMenus;
use Livewire\Component;

class AppLayout extends Component
{
    public $menus = [];
    use HasMenus;


    public function mount()
    {
        $this->menus = $this->getMenus();
    }

    public function render()
    {
        return view('livewire.dashboard-layout', [
            'menus' => $this->menus,
        ])->layout('layouts.app', ['menus' => $this->menus]);
    }
}
