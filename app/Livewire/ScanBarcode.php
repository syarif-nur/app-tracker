<?php

namespace App\Livewire;

use Livewire\Component;

class ScanBarcode extends Component
{
    use \App\Traits\HasMenus;
    public $scannedCode = '';
    public $error = '';
    public $order = null;
    public $menus = [];

    public function mount()
    {
        $this->scannedCode = '';
        $this->error = '';
        $this->order = null;
        $this->menus = $this->getMenus();
    }

    public function updatedScannedCode($value)
    {
        // Validasi kode barcode sederhana
        if (empty($value)) {
            $this->error = 'Barcode tidak boleh kosong';
            $this->order = null;
            return;
        }
        $this->error = '';
        // Cari delivery order berdasarkan unique_code
        $order = \App\Models\DeliveryOrder::where('unique_code', $value)->first();
        if ($order) {
            $this->order = $order;
        } else {
            $this->order = null;
            $this->error = 'Data tidak ditemukan.';
        }
    }

    public function render()
    {
        return view('livewire.scan-barcode', [
            'order' => $this->order,
        ])->layout('layouts.app', [
            'menus' => $this->menus,
        ]);
    }
}
