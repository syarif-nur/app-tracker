<?php

namespace App\Livewire;

use App\Traits\HasMenus;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DeliveryOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DeliveryOrderManagement extends Component
{
    use WithPagination;

    public $search = '';
    use HasMenus;
    public $destination;
    public $latitude;
    public $longitude;
    public $description;
    public $editId = null;
    public $editMode = false;

    protected $rules = [
        'destination' => 'required',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'description' => 'nullable',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->menus = $this->getMenus();
    }

    public function createDeliveryOrder()
    {
        $this->validate();
        $user = Auth::user();
        $this->authorize('create', \App\Models\DeliveryOrder::class);
        DeliveryOrder::create([
            'creator_id' => $user->id,
            'destination' => $this->destination,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'description' => $this->description,
        ]);
        $this->reset(['destination', 'latitude', 'longitude', 'description']);
        $this->dispatch('delivery-order-added');
    }

    public function startEdit($id)
    {
        $order = DeliveryOrder::findOrFail($id);
        $this->editId = $order->id;
        $this->destination = $order->destination;
        $this->latitude = $order->latitude;
        $this->longitude = $order->longitude;
        $this->description = $order->description;
        $this->editMode = true;
    }

    public function updateDeliveryOrder()
    {
        $this->validate();
        $order = DeliveryOrder::findOrFail($this->editId);
        $this->authorize('update', $order);
        $order->update([
            'destination' => $this->destination,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'description' => $this->description,
        ]);
        $this->reset(['destination', 'latitude', 'longitude', 'description', 'editId', 'editMode']);
        $this->dispatch('delivery-order-updated');
    }

    public function deleteDeliveryOrder($id)
    {
        $order = DeliveryOrder::findOrFail($id);
        $this->authorize('delete', $order);
        $order->delete();
        $this->dispatch('delivery-order-deleted');
    }

    public function render()
    {
        $user = Auth::user();
        $query = DeliveryOrder::query();
        if (!$user->can('viewAny', \App\Models\DeliveryOrder::class)) {
            $query->where('creator_id', $user->id);
        }
        if ($this->search) {
            $query->where(function($q) {
                $q->where('unique_code', 'like', '%'.$this->search.'%')
                  ->orWhere('destination', 'like', '%'.$this->search.'%');
            });
        }
        $orders = $query->orderByDesc('created_at')->paginate(10);
        return view('livewire.delivery-order-management', [
            'orders' => $orders,
            'search' => $this->search,
        ])->layout('layouts.app', [
            'menus' => $this->menus,
        ]);
    }
}
