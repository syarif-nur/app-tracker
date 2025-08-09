<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryOrderReceipt;
use App\Models\DeliveryOrder;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReceiptController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('viewAny', DeliveryOrderReceipt::class);
        $receipts = DeliveryOrderReceipt::with('deliveryOrder')->latest()->paginate(15);
        return view('receipts.index', compact('receipts'));
    }

    public function create()
    {
        $this->authorize('create', DeliveryOrderReceipt::class);
        $orders = DeliveryOrder::doesntHave('receipt')->get();
        return view('receipts.create', compact('orders'));
    }


    public function store(Request $request)
    {
        $this->authorize('create', \App\Models\DeliveryOrderReceipt::class);
        $request->validate([
            'delivery_order_id' => 'required|exists:delivery_orders,id|unique:delivery_order_receipts,delivery_order_id',
            'receiver_name' => 'required',
            'received_at' => 'required|date',
            'photo' => 'required|image|max:2048',
        ]);
        $path = $request->file('photo')->store('receipts', 'public');
        \App\Models\DeliveryOrderReceipt::create([
            'delivery_order_id' => $request->delivery_order_id,
            'receiver_name' => $request->receiver_name,
            'received_at' => $request->received_at,
            'photo_path' => $path,
        ]);
        return redirect()->route('upload-proof.index')->with('success', 'Bukti berhasil ditambahkan');
    }


    public function edit($id)
    {
        $receipt = \App\Models\DeliveryOrderReceipt::with('deliveryOrder')->findOrFail($id);
        $this->authorize('update', $receipt);
        return view('receipts.edit', compact('receipt'));
    }


    public function update(Request $request, $id)
    {
        $receipt = \App\Models\DeliveryOrderReceipt::findOrFail($id);
        $this->authorize('update', $receipt);
        $request->validate([
            'receiver_name' => 'required',
            'received_at' => 'required|date',
            'photo' => 'nullable|image|max:2048',
        ]);
        $data = [
            'receiver_name' => $request->receiver_name,
            'received_at' => $request->received_at,
        ];
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('receipts', 'public');
        }
        $receipt->update($data);
        return redirect()->route('upload-proof.index')->with('success', 'Bukti berhasil diupdate');
    }


    public function destroy($id)
    {
        $receipt = \App\Models\DeliveryOrderReceipt::findOrFail($id);
        $this->authorize('delete', $receipt);
        $receipt->delete();
        return redirect()->route('upload-proof.index')->with('success', 'Bukti berhasil dihapus');
    }
}
