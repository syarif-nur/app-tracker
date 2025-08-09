<div class="p-4" x-data="{ openAdd: false, openEdit: false, openDelete: false, deleteId: null }" @open-add-modal.window="openAdd = true" @open-edit-modal.window="openEdit = true" @receipt-added.window="openAdd = false" @receipt-updated.window="openEdit = false" @receipt-deleted.window="openDelete = false">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Manajemen Bukti Serah Terima</h2>
        @if($canCreate)
        <button @click="openAdd = true" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Tambah Bukti</button>
        @endif
    </div>
    <div class="mb-4">
        <input type="text" wire:model.debounce.500ms="search" placeholder="Cari kode/destinasi..." class="border rounded px-3 py-2 w-full max-w-xs" />
    </div>
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200 text-xs">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-2 py-2">Surat Jalan</th>
                    <th class="px-2 py-2">Penerima</th>
                    <th class="px-2 py-2">Foto</th>
                    <th class="px-2 py-2">Tanggal</th>
                    <th class="px-2 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($receipts as $receipt)
                    <tr>
                        <td class="px-2 py-1">{{ $receipt->deliveryOrder->unique_code ?? '-' }}</td>
                        <td class="px-2 py-1">{{ $receipt->receiver_name }}</td>
                        <td class="px-2 py-1">
                            @if($receipt->photo_path)
                                <img src="{{ asset('storage/'.$receipt->photo_path) }}" alt="Bukti" class="h-12">
                            @endif
                        </td>
                        <td class="px-2 py-1">{{ $receipt->received_at }}</td>
                        <td class="px-2 py-1">
                            @if($canEdit)
                            <button @click.prevent="openEdit = true; $wire.startEdit({{ $receipt->id }})" class="text-blue-600 hover:underline mr-2">Edit</button>
                            @endif
                            @if($canDelete)
                            <button @click.prevent="openDelete = true; deleteId = {{ $receipt->id }}" class="text-red-600 hover:underline">Hapus</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-2">{{ $receipts->links() }}</div>
    </div>
    <!-- Modal Tambah Bukti -->
    <div x-show="openAdd" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
        <div class="bg-white rounded shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Tambah Bukti Serah Terima</h3>
            <form wire:submit.prevent="createReceipt">
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Surat Jalan</label>
                    <select wire:model.defer="delivery_order_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">Pilih Surat Jalan</option>
                        @foreach($orders ?? [] as $order)
                            <option value="{{ $order->id }}">{{ $order->unique_code }} - {{ $order->destination }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Nama Penerima</label>
                    <input type="text" wire:model.defer="receiver_name" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Tanggal Terima</label>
                    <input type="datetime-local" wire:model.defer="received_at" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Foto Bukti</label>
                    <input type="file" wire:model="photo" accept="image/*" class="w-full border rounded px-3 py-2" required>
                    @error('photo')<div class="text-red-600 text-xs">{{ $message }}</div>@enderror
                </div>
                <div class="flex justify-end">
                    <button type="button" @click="openAdd = false" class="bg-gray-300 px-4 py-2 rounded mr-2">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Edit Bukti -->
    <div x-show="openEdit" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
        <div class="bg-white rounded shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Edit Bukti Serah Terima</h3>
            <form wire:submit.prevent="updateReceipt">
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Surat Jalan</label>
                    <select wire:model.defer="delivery_order_id" class="w-full border rounded px-3 py-2" required>
                        <option value="">Pilih Surat Jalan</option>
                        @foreach($orders ?? [] as $order)
                            <option value="{{ $order->id }}">{{ $order->unique_code }} - {{ $order->destination }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Nama Penerima</label>
                    <input type="text" wire:model.defer="receiver_name" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Tanggal Terima</label>
                    <input type="datetime-local" wire:model.defer="received_at" class="w-full border rounded px-3 py-2" required>
                </div>
                <div class="mb-3">
                    <label class="block mb-1 font-medium">Foto Bukti (biarkan kosong jika tidak diubah)</label>
                    <input type="file" wire:model="photo" accept="image/*" class="w-full border rounded px-3 py-2">
                    @if($photo_path)
                        <img src="{{ asset('storage/'.$photo_path) }}" alt="Bukti" class="h-16 mt-2">
                    @endif
                    @error('photo')<div class="text-red-600 text-xs">{{ $message }}</div>@enderror
                </div>
                <div class="flex justify-end">
                    <button type="button" @click="openEdit = false" class="bg-gray-300 px-4 py-2 rounded mr-2">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Hapus Bukti -->
    <div x-show="openDelete" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
        <div class="bg-white rounded shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4 text-red-600">Hapus Bukti</h3>
            <p class="mb-4">Apakah Anda yakin ingin menghapus bukti ini?</p>
            <div class="flex justify-end mt-4">
                <button type="button" @click="openDelete = false" class="bg-gray-300 px-4 py-2 rounded mr-2">Batal</button>
                <button type="button" @click="$wire.deleteReceipt(deleteId); openDelete = false" class="bg-red-600 text-white px-4 py-2 rounded">Hapus</button>
            </div>
        </div>
    </div>
</div>
