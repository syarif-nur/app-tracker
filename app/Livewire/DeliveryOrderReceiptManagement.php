<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\DeliveryOrderReceipt;
use App\Models\DeliveryOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Traits\HasMenus;

class DeliveryOrderReceiptManagement extends Component
{
    use WithPagination, WithFileUploads, HasMenus;

    public $search = '';
    public $menus = [];
    public $orders;
    public $delivery_order_id;
    public $receiver_name;
    public $received_at;
    public $photo;
    public $editId = null;
    public $editMode = false;
    public $photo_path = null;

    // Permission flags
    public $canView = false;
    public $canCreate = false;
    public $canEdit = false;
    public $canDelete = false;

    protected $rules = [
        'delivery_order_id' => 'required|exists:delivery_orders,id',
        'receiver_name' => 'required',
        'received_at' => 'required|date',
        'photo' => 'nullable|image|max:2048',
    ];

    public function updatingSearch() { $this->resetPage(); }

    public function mount()
    {
        $perms = $this->getMenuPermissionsByRoute('upload-proof');
        $this->canView = (bool)($perms['can_view'] ?? false);
        $this->canCreate = (bool)($perms['can_create'] ?? false);
        $this->canEdit = (bool)($perms['can_edit'] ?? false);
        $this->canDelete = (bool)($perms['can_delete'] ?? false);
        if (!$this->canView) abort(403);
        $this->menus = $this->getMenus();
    }

    public function render()
    {
        $query = DeliveryOrderReceipt::with('deliveryOrder');
        if ($this->search) {
            $query->whereHas('deliveryOrder', function($q) {
                $q->where('unique_code', 'like', '%'.$this->search.'%')
                  ->orWhere('destination', 'like', '%'.$this->search.'%');
            });
        }
        $receipts = $query->latest()->paginate(15);
        return view('livewire.delivery-order-receipt-management', [
            'receipts' => $receipts,
            'menus' => $this->menus,
            'canCreate' => $this->canCreate,
            'canEdit' => $this->canEdit,
            'canDelete' => $this->canDelete,
        ])->layout('layouts.app', ['menus' => $this->menus]);
    }

    public function startAdd()
    {
        if (!$this->canCreate) abort(403);
        $this->reset(['delivery_order_id', 'receiver_name', 'received_at', 'photo', 'editId', 'editMode', 'photo_path']);
        $this->orders = DeliveryOrder::doesntHave('receipt')->get();
        $this->editMode = false;
        $this->dispatch('open-add-modal');
    }

    public function createReceipt()
    {
        if (!$this->canCreate) abort(403);
        $this->validate(['photo' => 'required|image|max:2048'] + $this->rules);
        $path = $this->photo->store('receipts', 'public');
        DeliveryOrderReceipt::create([
            'delivery_order_id' => $this->delivery_order_id,
            'receiver_name' => $this->receiver_name,
            'received_at' => $this->received_at,
            'photo_path' => $path,
        ]);
        $this->reset(['delivery_order_id', 'receiver_name', 'received_at', 'photo', 'editId', 'editMode', 'photo_path']);
        $this->dispatch('receipt-added');
    }

    public function startEdit($id)
    {
        if (!$this->canEdit) abort(403);
        $receipt = DeliveryOrderReceipt::findOrFail($id);
        $this->editId = $receipt->id;
        $this->delivery_order_id = $receipt->delivery_order_id;
        $this->receiver_name = $receipt->receiver_name;
        $this->received_at = $receipt->received_at;
        $this->photo_path = $receipt->photo_path;
        $this->orders = DeliveryOrder::all();
        $this->editMode = true;
        $this->dispatch('open-edit-modal');
    }

    public function updateReceipt()
    {
        if (!$this->canEdit) abort(403);
        $rules = $this->rules;
        $rules['photo'] = 'nullable|image|max:2048';
        $this->validate($rules);
        $receipt = DeliveryOrderReceipt::findOrFail($this->editId);
        $data = [
            'delivery_order_id' => $this->delivery_order_id,
            'receiver_name' => $this->receiver_name,
            'received_at' => $this->received_at,
        ];
        if ($this->photo) {
            $data['photo_path'] = $this->photo->store('receipts', 'public');
        }
        $receipt->update($data);
        $this->reset(['delivery_order_id', 'receiver_name', 'received_at', 'photo', 'editId', 'editMode', 'photo_path']);
        $this->dispatch('receipt-updated');
    }

    public function deleteReceipt($id)
    {
        if (!$this->canDelete) abort(403);
        $receipt = DeliveryOrderReceipt::findOrFail($id);
        $receipt->delete();
        $this->dispatch('receipt-deleted');
    }
}
